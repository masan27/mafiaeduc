<?php

namespace App\Services\Mentors\Auth;

use App\Entities\AccessLogEntities;
use App\Entities\MentorEntities;
use App\Helpers\ResponseHelper;
use App\Mail\ForgotPasswordTokenMail;
use App\Repository\AccessLogs\AccessLogRepoInterface;
use App\Repository\Mentors\MentorRepoInterface;
use App\Repository\PasswordResetToken\PasswordResetTokenRepoInterface;
use App\Validators\AdminAuthValidator;
use App\Validators\AuthValidator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class MentorAuthService implements MentorAuthServiceInterface
{
    protected MentorRepoInterface $mentorRepo;
    protected AccessLogRepoInterface $accessLogRepo;
    protected AdminAuthValidator $adminAuthValidator;
    protected AuthValidator $authValidator;
    protected PasswordResetTokenRepoInterface $passwordResetTokenRepo;

    public function __construct(
        MentorRepoInterface             $mentorRepo,
        AccessLogRepoInterface          $accessLogRepo,
        AdminAuthValidator              $adminAuthValidator,
        AuthValidator                   $authValidator,
        PasswordResetTokenRepoInterface $passwordResetTokenRepo,
    )
    {
        $this->mentorRepo = $mentorRepo;
        $this->accessLogRepo = $accessLogRepo;
        $this->adminAuthValidator = $adminAuthValidator;
        $this->authValidator = $authValidator;
        $this->passwordResetTokenRepo = $passwordResetTokenRepo;
    }

    public function logout($request): array
    {
        DB::beginTransaction();
        try {
            $mentorId = $request->mentor->id;
            $token = $request->header('X-Mentor-Token');

            $this->accessLogRepo->updateLogoutLogs($mentorId, $token, AccessLogEntities::MENTOR_LOGIN_TYPE);

            DB::commit();
            return ResponseHelper::success('Berhasil logout');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseHelper::serverError($e->getMessage());
        }
    }

    public function login($request): array
    {
        $validator = $this->adminAuthValidator->validateLoginInput($request);

        if ($validator) return $validator;

        DB::beginTransaction();
        try {
            $email = $request->input('email');
            $password = $request->input('password');

            $mentor = $this->mentorRepo->getMentorByEmail($email);

            if (!$mentor) return ResponseHelper::error('Emailp atau password salah');

            if ($mentor->status == MentorEntities::INACTIVE_CREDENTIALS) return ResponseHelper::error('Akun dinonaktifkan sementara');

            if (!Hash::check($password, $mentor->password)) return ResponseHelper::error('Email atau password salah');

            $data = [
                'token' => $mentor->api_token,
                'mentor' => $mentor
            ];

            $clientIP = $request->ip();
            $this->accessLogRepo->createLoginLogs($mentor->id, $clientIP, $mentor->api_token,
                AccessLogEntities::ADMIN_LOGIN_TYPE);

            DB::commit();
            return ResponseHelper::success('Berhasil login', $data);
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseHelper::serverError($e->getMessage());
        }
    }

    public function sendResetLinkEmail($request): array
    {
        $validator = $this->authValidator->validateForgotPasswordInput($request);

        if ($validator) return $validator;

        DB::beginTransaction();
        try {
            $email = $request->input('email');

            $mentorCredentials = $this->mentorRepo->getMentorByEmail($email);

            if (!$mentorCredentials) return ResponseHelper::error('Email tidak terdaftar');

            $token = self::createNewResetPasswordToken();
            $expiredAt = now()->addMinutes(5);
            $type = 'mentor';
            $this->passwordResetTokenRepo->insertOrUpdateToken($email, $token, $type, $expiredAt);

            $mentorFullName = $this->mentorRepo->getMentorFullName($mentorCredentials->mentor_id);
            Mail::to($email)->send(new ForgotPasswordTokenMail($token, $email, $mentorFullName));

            $data = [
                'email' => $email,
                'token' => $token
            ];

            DB::commit();
            return ResponseHelper::success('Berhasil mengirim email reset password', $data);
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseHelper::serverError($e->getMessage());
        }
    }

    private function createNewResetPasswordToken(): string
    {
        $token = Str::random(60);
        return hash('sha256', $token);
    }

    public function resetPassword($request): array
    {
        $validator = $this->authValidator->validateResetPasswordTokenInput($request);

        if ($validator) return $validator;

        DB::beginTransaction();
        try {
            $email = $request->input('email');
            $token = $request->input('token');
            $password = $request->input('password');

            $mentorCredentials = $this->mentorRepo->getMentorByEmail($email);

            if (!$mentorCredentials) return ResponseHelper::error('Email tidak terdaftar', null, ResponseAlias::HTTP_UNAUTHORIZED);

            $tokenStatus = $this->passwordResetTokenRepo->checkTokenValid($email, $token);

            if (!$tokenStatus) return ResponseHelper::error('Token tidak valid', null, ResponseAlias::HTTP_UNAUTHORIZED);

            $mentorCredentialId = $mentorCredentials->mentor_id;
            $rememberToken = $this->mentorRepo->getCurrentRememberToken($mentorCredentialId);

            if ($rememberToken === $token) {
                return ResponseHelper::error('Token tidak valid', null, ResponseAlias::HTTP_UNAUTHORIZED);
            }

            $this->mentorRepo->updatePassword($mentorCredentialId, $password);

            $this->mentorRepo->updateRememberToken($mentorCredentialId, $token);

            $this->passwordResetTokenRepo->deleteToken($email, $token);

            DB::commit();

            return ResponseHelper::success('Berhasil reset password');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseHelper::serverError($e->getMessage());
        }
    }
}
