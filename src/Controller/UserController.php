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

#[Route('/user', name: 'user_')]
class UserController extends AbstractController
{
    #[Route('/choixform', name: 'choix_form')]
    public function choixForm(): Response {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'ROLE USER necessaire');
        return $this->render('home/addChoice.html.twig');
    }

    #[Route('/formajout', name: 'form_ajout')]
    public function formAjout(Request $r): Response {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'ROLE USER necessaire');
        
        $choice = $r->request->get('choice');

        switch ($choice) {
            case 'vacation' :
                return $this->redirectToRoute('user_add_vacation');
                break;

            case 'theme':
                return $this->redirectToRoute('user_add_theme');
                break;

            case 'atelier':
                return $this->redirectToRoute('user_add_atelier');
                break;
        }
    }

    #[Route('/addvacation', name: 'add_vacation')]
    public function addVacation(Request $r, EntityManagerInterface $em): Response {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'ROLE USER necessaire');
        
        $idVacation = $r->query->get('idVacation');

        if ($idVacation) {
            $vacation = $em->getRepository(Vacation::class)->find($idVacation);
        } else {
            $vacation = new Vacation();
        }
        $form = $this->createForm(VacationType::class, $vacation);
        $form->handleRequest($r);

        if ($form->isSubmitted() && $form->isValid()) {
            $dateheureDebut = $form->get('dateheureDebut')->getData();
            $dateheureFin = $form->get('dateheureFin')->getData();

            if ($dateheureDebut > $dateheureFin) {
                throw new \Exception('La date de fin doit etre inferieure à la date de début !');
            } else {

                $em->persist($vacation);
                $em->flush();
                return $this->redirectToRoute('app_home');
            }
        }
        return $this->render("home/formTemplate.html.twig", [
                    'form' => $form->createView(),
        ]);
    }

    #[Route('/addtheme', name: 'add_theme')]
    public function addTheme(Request $r, EntityManagerInterface $em): Response {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'ROLE USER necessaire');
        
        $theme = new Theme();
        $form = $this->createForm(ThemeType::class, $theme);
        $form->handleRequest($r);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($theme);
            $em->flush();
            return $this->redirectToRoute('app_home');
        }
        return $this->render("home/formTemplate.html.twig", [
                    'form' => $form->createView(),
        ]);
    }

    #[Route('/addatelier', name: 'add_atelier')]
    public function addAtelier(Request $r, EntityManagerInterface $em): Response {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'ROLE USER necessaire');
        
        $atelier = new Atelier();
        $form = $this->createForm(AtelierType::class, $atelier);
        $form->handleRequest($r);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($atelier);
            $em->flush();
            return $this->redirectToRoute('app_home');
        }
        return $this->render("home/formTemplate.html.twig", [
                    'form' => $form->createView(),
        ]);
    }

    #[Route('/choisiratelier', name: 'choisir_atelier')]
    public function choisirAtelier(EntityManagerInterface $em): Response {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'ROLE USER necessaire');
        $ateliers = $em->getRepository(Atelier::class)->findAteliersWithVacations();

        return $this->render("atelier/choisirAtelier.html.twig", [
                    'ateliers' => $ateliers,
        ]);
    }

    #[Route('choisirvacation', name: 'choisir_vacation')]
    public function choisirVacation(Request $r, EntityManagerInterface $em): Response {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'ROLE USER necessaire');
        
        $idAtelier = $r->query->get('idAtelier');
        $atelier = $em->getRepository(Atelier::class)->findOneById($idAtelier);

        $vacations = $atelier->getVacations();

        return $this->render("vacation/choisirVacation.html.twig", [
                    'vacations' => $vacations,
        ]);
    }
}
