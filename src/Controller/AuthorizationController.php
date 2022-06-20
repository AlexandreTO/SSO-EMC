<?php

namespace App\Controller;

use League\OAuth2\Server\AuthorizationServer;
use App\Entity\User;
use League\OAuth2\Server\Exception\OAuthServerException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AuthorizationController extends AbstractController
{
    public function getToken(ServerRequestInterface $request, AuthorizationServer $authorizationServer, ResponseInterface $responseInterface)
    {
        try {
           return $authorizationServer->respondToAccessTokenRequest($request, $responseInterface);
        } catch (OAuthServerException $exception) {
            return $exception->generateHttpResponse($responseInterface);
        } catch (\Exception $exception) {
            $body = $responseInterface->getBody();
            $body->write($exception->getMessage());
            return $responseInterface->withStatus(500)->withBody($body);
        }
    }

    public function getAuthorization(ServerRequestInterface $request, ResponseInterface $responseInterface, AuthorizationServer $authorizationServer)
    {
        try {
            $authRequest = $authorizationServer->validateAuthorizationRequest($request);
            $user = new User();

            $user->setIdentifier($_SESSION['user_id']);
            $authRequest->setUser($user);

            if ($request->getMethod() == 'GET') {
                $queryParam = $request->getQueryParams();
                $scopes = isset($queryParam['scope']) ? explode("", $queryParam['scope']) : ['default'];

                return $this->render('auth/index.html.twig', ['pageTitle' =>  'Authorize', 'clientName' => $authRequest->getClient()->getName(),  'scopes' => $scopes]);
            }

            $params = (array) $request->getParsedBody();
            $authorized = $params['authorized'] == "true";
            $authRequest->setAuthorizationApproved($authorized);

            return $authorizationServer->completeAuthorizationRequest($authRequest, $responseInterface);

        } catch (OAuthServerException $exception) {
            return $exception->generateHttpResponse($responseInterface);
        } catch (\Exception $exception) {
            $body = $responseInterface->getBody();
            $body->write($exception->getMessage());

            return $responseInterface->withStatus(500)->withBody($body);
        }
    }
} 
