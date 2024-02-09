<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function login(AuthenticationUtils $authUtils): Response
    {   
        //
        $error = $authUtils->getLastAuthenticationError();
        
        return $this->render('login/login.html.twig', [
            'error' => $error
        ]);
    }
    
    #[Route('/logout', name:'app_logout')]
    public function logout():void
    {
        throw new \Exception("Oublie pas d'activer Logout dans security.yaml !");
    }
}
