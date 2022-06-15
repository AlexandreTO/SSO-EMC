<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiAuthService
{
    public function __construct(HttpClientInterface $httpClientInterface)
    {
        $this->httpClientInterface = $httpClientInterface;
    }

    public function login($data): bool
    {
        $request = $this->httpClientInterface->request(
            'POST',
            'http://localhost:8000/api/login_check',
            [
                'json' => [
                    'email'=>$data->getEmail(), 
                    'password' => $data->getPassword()
                ]
            ]
        );

        dump($request->toArray()['token']);

        return false;
    }
}