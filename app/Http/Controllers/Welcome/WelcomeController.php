<?php

namespace App\Http\Controllers\Welcome;

use App\Http\Controllers\Controller;
use App\Services\Welcome\WelcomeServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class WelcomeController extends Controller
{
    protected WelcomeServiceInterface $welcomeService;

    public function __construct(WelcomeServiceInterface $welcomeService)
    {
        $this->welcomeService = $welcomeService;
    }

    public function index(): JsonResponse
    {
        $data = $this->welcomeService->getAppDetails();
        return response()->json($data, $data['code']);
    }

    public function welcome(): View
    {
        return view('welcome');
    }

    public function viewPrivacyPolicy(): View
    {
        return view('privacy-policy');
    }
}
