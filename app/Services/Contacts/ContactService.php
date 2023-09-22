<?php

namespace App\Services\Contacts;

use App\Helpers\ResponseHelper;
use App\Models\Contacts\AppContact;

class ContactService implements ContactServiceInterface
{
    public function getAllContacts(): array
    {
        try {
            $contacts = AppContact::all();

            if ($contacts->isEmpty()) {
                return ResponseHelper::notFound('Tidak ada kontak yang tersedia');
            }

            return ResponseHelper::success('Berhasil mengambil data kontak', $contacts);
        } catch (\Exception $e) {
            return ResponseHelper::serverError($e->getMessage());
        }
    }
}
