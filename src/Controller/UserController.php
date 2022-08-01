<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class UserController extends AbstractController
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    #[Route("/profile", name:"user_profile")]
    public function profile(): Response
    {
        return $this->render('user/profile.html.twig');
    }


    /**
     * @Route("/user", name="user")
     */
    public function index(Request $request): Response
    {
        $request = $request->query->get('code');
        return $this->render('user/index.html.twig', [
            'request' => $request,
        ]);
    }

    /**
     * @Route("/user/token", name="user_token")
     */
    public function generateJWTToken(Request $request, UserRepository $userRepository): Response
    {
        $url = 'http://127.0.0.1:8000/token';
        $authCode = $request->query->get('code');
        if (!$authCode) {
            return $this->redirectToRoute('login');
        }
        $response = $this->client->request('POST', $url, [
            'body' => [
                'grant_type' => 'authorization_code',
                'client_id' => $_ENV['CLIENT_ID'],
                'client_secret' => $_ENV['CLIENT_SECRET'],
                'redirect_uri' => 'http://127.0.0.1:8000/user',
                'code' => $authCode
            ],
        ]);
        $data = json_decode($response->getContent(), true);
        $jwt = $data['access_token'];
        $info = explode(".", $jwt);
        $tokenPayload = base64_decode($info[1]);
        $jwtPayload = json_decode($tokenPayload, true);
        return $this->render('user/token.html.twig', [
            'email' => $jwtPayload['sub']
        ]);
    }

    /**
     * @Route("/user/info", name="user_info")
     */
    public function getUserInfo(Request $request, UserRepository $userRepository): Response
    {
        $fetchInfo = $request->query->get('email');
        if (!$fetchInfo) {
            return $this->redirectToRoute('login');
        }
        $userInfo = $userRepository->findOneBy(['email' => $fetchInfo]);

        return $this->render('user/info.html.twig', [
            'info' => $userInfo
        ]);
        
    }
}

