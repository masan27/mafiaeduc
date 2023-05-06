<?php

namespace App\Http\Controllers;

use App\Services\WelcomeServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WelcomeController extends Controller
{
    private WelcomeServiceInterface $welcomeService;

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
}
