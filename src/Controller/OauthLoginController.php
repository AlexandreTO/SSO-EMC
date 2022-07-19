<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\ClientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class OauthLoginController extends AbstractController
{
    #[Route('/oauth/login', name: 'oauth_login')]
    public function index(ClientRepository $clientRepository): Response
    {
        $client_id = $this->getParameter('app.client_id');

        $existingClientId = $clientRepository->findOneBy(['identifier' => $client_id]);

        if($existingClientId == null ) {
            return $this->render('security/error.html.twig');
        }
        
        $existClientId = $existingClientId->getIdentifier() == $client_id;

        return $this->render('security/index.html.twig',[
            'client_id' => $client_id,
            'exist_client' => $existClientId
        ]);
    }
}
