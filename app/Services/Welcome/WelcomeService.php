<?php

namespace App\Services\Welcome;

use App\Helpers\ResponseHelper;

class WelcomeService implements WelcomeServiceInterface
{
    public function getAppDetails(): array
    {
        $appDetails = [
            'name' => 'Mafia Education API',
            'version' => '1.0.0',
            'author' => 'Mafia Education',
            'api_url' => '-',
            'details' => [
                'laravel_version' => '^10.8',
                'php_version' => '^8.1',
                'npm_version' => '^9.6.4',
                'node_version' => '^18.16.0',
            ]
        ];

        return ResponseHelper::success('Berhasil mengambil data aplikasi', $appDetails);
    }
}
