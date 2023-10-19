<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class LoginController extends AbstractController
{
    // #[Route('/login', name: 'login')]
    // public function index(AuthenticationUtils $authenticationUtils, Security $security): Response
    // {
    //     $error = $authenticationUtils->getLastAuthenticationError();
    //     $lastUsername = $authenticationUtils->getLastUsername();

    //     // if ($security->getUser()) {
    //     //     error_log('User is logged in, redirecting...');
    //     //     return new RedirectResponse('http://localhost:5173');
    //     // }
    //     return $this->render('login/index.html.twig', [
    //         'last_username' => $lastUsername,
    //         'error' => $error,
    //     ]);
    // }
    #[Route('/initialisationSession', name: 'initialisation_session')]
    public function initialisationSession(Request $request): Response
    {
        $email = $request->query->get('email');
        
        // Construisez l'URL de redirection vers votre front-end avec l'email en tant que paramètre
        $redirectUrl = 'http://localhost:5173/initialisationSession?email=' . urlencode($email);
    
        return new RedirectResponse($redirectUrl);
    }
    #[Route('/login', name: 'login')]
    public function index(AuthenticationUtils $authenticationUtils, Security $security): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        /** @var User $user */
        $user = $security->getUser();
        if ($security->getUser()) {
            return $this->redirectToRoute('initialisation_session', ['email' => $user->getEmail()]);
        }

        return $this->render('login/index.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }
    #[Route('/logout', name: 'logout')]
    public function logout()
    {
    }

    #[Route('/whoami', name: 'whoami')]
    public function whoAmI(Security $security): Response
    {
        /** @var User $user */
        $user = $security->getUser();
        if (null === $user) {
            // Let's change this to return a message indicating no user was found
            return new JsonResponse(['message' => 'No authenticated user found.'], Response::HTTP_OK);
        }
        return new JsonResponse([
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'roles' => $user->getRoles(),
        ]);
    }
}
