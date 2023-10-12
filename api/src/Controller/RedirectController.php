<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

class RedirectController extends AbstractController
{
    /**
     * @Route("/redirect-to-client", name="redirect_to_client")
     */
    public function redirectToClient()
    {
        return new RedirectResponse('http://localhost:5173');
    }
}