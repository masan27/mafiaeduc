<?php

namespace App\Http\Controllers\Contacts;

use App\Http\Controllers\Controller;
use App\Services\Contacts\ContactServiceInterface;
use Illuminate\Http\JsonResponse;

class ContactController extends Controller
{
    protected ContactServiceInterface $contactService;

    public function __construct(ContactServiceInterface $contactService)
    {
        $this->contactService = $contactService;
    }

    public function getAllContacts(): JsonResponse
    {
        $contacts = $this->contactService->getAllContacts();
        return response()->json($contacts);
    }
}
