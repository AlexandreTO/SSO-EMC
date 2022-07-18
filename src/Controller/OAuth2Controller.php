<?php

namespace App\Controller;

use App\EventListener\AuthorizationRequestResolverSubscriber;
use App\Form\AuthorizationType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OAuth2Controller extends AbstractController
{
	#[Route('/consent', name: 'app_consent')]
	public function consent(Request $request): Response
	{
		$form = $this->createForm(AuthorizationType::class);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			switch (true) {
				case
				$form->get('allow')->isClicked():
					$request->getSession()->set(
						AuthorizationRequestResolverSubscriber::SESSION_AUTHORIZATION_RESULT,
						true
					);
					break;
				case $form->get('deny')->isClicked():
					$request->getSession()->set(
						AuthorizationRequestResolverSubscriber::SESSION_AUTHORIZATION_RESULT,
						false
					);
					break;
			}

			return $this->redirectToRoute('oauth2_authorize', $request->query->all());
		}

		return $this->render('login/authorization.html.twig', [
			'form' => $form->createView(),
		]);
	}
}
