<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Form\LoginType;
use App\Service\ApiAuthService;
use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class ApiLoginController extends AbstractController
{
    #[Route('/api/login', name: 'api_login')]
    public function index( Request $request, ApiAuthService $apiAuthService): Response
    {
        // REquestStack pour l'accès aux pages protégées    
        $success = false;
        
        $form = $this->createForm(LoginType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $success = $apiAuthService->login($form->getData());

            if ($success) {
                return $this->redirectToRoute('list');
            } else {
                return $this->render('security/index.html.twig',[
                    'form' => $form->createView(),
                ]);
            }
        }

        return $this->render('security/index.html.twig',[
            'form' => $form->createView(),
        ]);
    }
}