<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Atelier;
use App\Entity\Theme;
use App\Entity\Vacation;
use App\Form\AtelierType;
use App\Form\VacationType;
use App\Form\ThemeType;

class HomeController extends AbstractController {

    #[Route('/home', name: 'app_home')]
    public function index(): Response {
        $number = random_int(0, 100);

        return new Response(
                '<html><body>Lucky number: ' . $number . '</body></html>'
        );
    }

    #[Route('/choixform', name: 'app_choix_form')]
    public function choixForm(): Response {
        return $this->render('home/addChoice.html.twig');
    }

    #[Route('/formajout', name: 'app_form_ajout')]
    public function formAjout(Request $r): Response {
        $choice = $r->request->get('choice');

        switch ($choice) {
            case 'vacation' :
                return $this->redirectToRoute('add_vacation');
                break;
            case 'theme':
                return $this->redirectToRoute('add_theme');
                break;
            case 'atelier':
                return $this->redirectToRoute('add_atelier');
                break;
        }
    }

    #[Route('/addvacation', name: 'add_vacation')]
    public function addVacation(Request $r, EntityManagerInterface $em): Response {
        $vacation = new Vacation();
        $form = $this->createForm(VacationType::class, $vacation);
        $form->handleRequest($r);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($vacation);
            $em->flush();
            return $this->redirectToRoute('app_home');
        }
        
        return $this->render("home/form.html.twig", [
           'form' => $form->createView(),
        ]);
    }

    #[Route('/addtheme', name: 'add_theme')]
    public function addTheme(Request $r, EntityManagerInterface $em): Response {
        $theme = new Theme();
        $form = $this->createForm(ThemeType::class, $theme);
        $form->handleRequest($r);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($theme);
            $em->flush();
            return $this->redirectToRoute('app_home');
        }
        return $this->render("home/form.html.twig", [
           'form' => $form->createView(),
        ]);
    }

    #[Route('/addatelier', name: 'add_atelier')]
    public function addAtelier(Request $r, EntityManagerInterface $em): Response {
        $atelier = new Atelier();
        $form = $this->createForm(AtelierType::class, $atelier);
        $form->handleRequest($r);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($atelier);
            $em->flush();
            return $this->redirectToRoute('app_home');
        }
        return $this->render("home/form.html.twig", [
           'form' => $form->createView(),
        ]);
    }
}
