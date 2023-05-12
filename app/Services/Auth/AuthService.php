<?php

namespace App\Services\Auth;

use App\Entities\AccessLogEntities;
use App\Entities\NotificationEntities;
use App\Entities\RoleEntities;
use App\Helpers\ResponseHelper;
use App\Repository\AccessLogs\AccessLogRepoInterface;
use App\Repository\Auth\AuthRepoInterface;
use App\Repository\Notifications\NotificationRepoInterface;
use App\Repository\Users\UserRepoInterface;
use App\Validators\AuthValidator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class AuthService implements AuthServiceInterface
{
    protected AuthValidator $authValidator;
    protected AuthRepoInterface $authRepo;

    protected UserRepoInterface $userRepo;

    protected NotificationRepoInterface $notificationRepo;

    protected AccessLogRepoInterface $accessLogRepo;

    public function __construct(
        AuthValidator             $authValidator,
        AuthRepoInterface         $authRepo,
        UserRepoInterface         $userRepo,
        NotificationRepoInterface $notificationRepo,
        AccessLogRepoInterface    $accessLogRepo
    )
    {
        $this->authValidator = $authValidator;
        $this->authRepo = $authRepo;
        $this->userRepo = $userRepo;
        $this->notificationRepo = $notificationRepo;
        $this->accessLogRepo = $accessLogRepo;
    }

    public function register($request): array
    {
        $validator = $this->authValidator->validateRegisterInput($request);

        if ($validator) return $validator;

        DB::beginTransaction();
        try {
            $fullName = $request->input('full_name');
            $email = $request->input('email');
            $password = $request->input('password');
            $role = RoleEntities::GUEST_ROLE;

            $userId = $this->authRepo->registerUser($fullName, $email, $password, $role);

            $this->sendWelcomeNotification($userId, $fullName);

            DB::commit();
            return ResponseHelper::success('Berhasil mendaftarkan user');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseHelper::serverError($e->getMessage());
        }
    }

    private function sendWelcomeNotification(int $userId, string $fullName): void
    {
        $notificationTitle = 'Selamat datang di aplikasi';
        $notificationBody = 'Halo, ' . $fullName . ' Selamat datang di mafia education, pilih kelas yang kamu inginkan dan mulai belajar sekarang';

        $notificationData = [
            $userId,
            $notificationTitle,
            $notificationBody,
            NotificationEntities::TYPE_GENERAL
        ];

        $this->notificationRepo->createUserNotification(...$notificationData);
    }

    public function login($request): array
    {
        $validator = $this->authValidator->validateLoginInput($request);

        if ($validator) return $validator;

        DB::beginTransaction();
        try {
            $email = $request->input('email');
            $password = $request->input('password');

            $user = $this->authRepo->getUserByEmail($email);

            if (!$user) return ResponseHelper::success('Akun kamu telah dinonaktifkan sementara, Silahkan hubungi admin untuk mengaktifkan kembali');

            if (!Hash::check($password, $user->password)) return ResponseHelper::error(
                'Email atau password salah',
                null,
                ResponseAlias::HTTP_UNAUTHORIZED
            );

            $userData = $this->userRepo->getUserDetailByUserId($user->id);

            $token = $user->createToken('user_token')->plainTextToken;

            $clientIP = $request->ip();
            $this->accessLogRepo->createLoginLogs($user->id, $clientIP, $token, AccessLogEntities::USER_LOGIN_TYPE);

            $data = [
                'token' => $token,
                'user' => $userData
            ];

            DB::commit();
            return ResponseHelper::success('Berhasil login', $data);
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseHelper::serverError($e->getMessage());
        }
    }

    public function logout($request): array
    {
        DB::beginTransaction();
        try {
            $userId = $request->user()->id;
            $token = $request->bearerToken();

            $request->user()->currentAccessToken()->delete();

            $this->accessLogRepo->updateLogoutLogs($userId, $token, AccessLogEntities::USER_LOGIN_TYPE);

            DB::commit();
            return ResponseHelper::success('Berhasil logout');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseHelper::serverError($e->getMessage());
        }
    }

    public function getUser($request): array
    {
        try {
            $userId = $request->user()->id;
            $userData = $this->userRepo->getUserDetailByUserId($userId);
            return ResponseHelper::success('Berhasil mengambil data user', $userData);
        } catch (\Exception $e) {
            return ResponseHelper::serverError($e->getMessage());
        }
    }
}
