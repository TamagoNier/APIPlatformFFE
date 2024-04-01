<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Atelier;
use Doctrine\ORM\EntityManagerInterface;

class HomeController extends AbstractController {

    #[Route('/home', name: 'app_home')]
    public function index(EntityManagerInterface $em): Response {
        
        $ateliers = $em->getRepository(Atelier::class)->findAll();
        return $this->render('/home/index.html.twig', [
            'ateliers' => $ateliers
        ]);
    }
}