<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    /**
     * @Route("/test", name="log")
     */
    public function log(): Response
    {
        $baseUrl = 'http://127.0.0.1:8000/authorize?response_type=code&client_id='.$_ENV["CLIENT_ID"].'&redirect_uri=http://127.0.0.1:8000/user/info&scope=email';
        return $this->render('test/index.html.twig', [
            'client_id' => $_ENV["CLIENT_ID"],
            'baseUrl' => $baseUrl
        ]);
    }
}
