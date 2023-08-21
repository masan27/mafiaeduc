<?php

namespace App\Repository\MentorPaymentMethod;

interface MentorPaymentMethodRepoInterface
{
    public static function getAllMentorPaymentMethod(int $mentorId, string|null $search): object;

    public static function addMentorPaymentMethod(int $mentorId, int $paymentMethodId, string $accountNumber, string $accountName, string $bankName): bool;

    public static function deleteMentorPaymentMethod(int $mentorId, int $mentorPaymentMethodId): bool;
}
