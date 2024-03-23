<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use App\Services\ServicesMdl;
use App\Entity\Atelier;
use App\Entity\Theme;
use App\Entity\Vacation;
use App\Form\AtelierType;
use App\Form\VacationType;
use App\Form\ThemeType;
use App\Form\DemandeInscriptionType;
use App\Entity\Inscription;
use \App\Entity\Nuite;
use App\Entity\Proposer;
use App\Entity\Hotel;

class HomeController extends AbstractController {

    #[Route('/home', name: 'app_home')]
    public function index(): Response {
        $number = random_int(0, 100);

        return new Response(
                '<html><body>Lucky number: ' . $number . '</body></html>'
        );
    }

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
        return $this->render("home/form.html.twig", [
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
        return $this->render("home/form.html.twig", [
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
        return $this->render("home/form.html.twig", [
                    'form' => $form->createView(),
        ]);
    }

    #[Route('/choisiratelier', name: 'choisir_atelier')]
    public function choisirAtelier(EntityManagerInterface $em): Response {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'ROLE USER necessaire');
        $ateliers = $em->getRepository(Atelier::class)->findAteliersWithVacations();

        return $this->render("home/choisirAtelier.html.twig", [
                    'ateliers' => $ateliers,
        ]);
    }

    #[Route('choisirvacation', name: 'choisir_vacation')]
    public function choisirVacation(Request $r, EntityManagerInterface $em): Response {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'ROLE USER necessaire');
        
        $idAtelier = $r->query->get('idAtelier');
        $atelier = $em->getRepository(Atelier::class)->findOneById($idAtelier);

        $vacations = $atelier->getVacations();

        return $this->render("home/choisirVacation.html.twig", [
                    'vacations' => $vacations,
        ]);
    }

    #[Route('demandeinscription', name: 'demande_inscription')]
    public function demandeInscription(Request $r, EntityManagerInterface $em, MailerInterface $mailer): Response {
        $user = $this->getUser();
        
        $inscription = $user->getInscription();
        if($inscription){
            return $this->redirectToRoute('valider_inscription');
        }
        
        $fraisInscription = $this->getParameter('fraisInscription');
        $tarifRepas = $this->getParameter('tarifRepas');

        $form = $this->createForm(DemandeInscriptionType::class);
        $form->handleRequest($r);

        $proposer = $em->getRepository(Proposer::class)->findAll();
        $hotels = $em->getRepository(Hotel::class)->findAll();

        $total = $fraisInscription;

        if ($form->isSubmitted() && $form->isValid()) {
            $inscription = new Inscription();
            
            $inscription->setDateInscription(new \DateTime());

            $formData = $form->getData();

            $inscription->addRestaurations($formData['restauration']);
            $total += $tarifRepas * count($formData['restauration']);

            $inscription->addAteliers($formData['ateliers']);

            $email = $r->request->get('email');

            $nuitsId =[];
            if($r->request->get('sept6_7')){
                array_push($nuitsId,$r->request->get('sept6_7'));
            }
            if($r->request->get('sept7_8')){
                array_push($nuitsId,$r->request->get('sept7_8'));
            }
            foreach($nuitsId as $nuitId) {
                $nuit = $em->getRepository(Proposer::class)->findOneById($nuitId);

                $nuite = new Nuite();
                $nuite->setDateNuitee(new \DateTime('2024-09-06'));
                $nuite->setHotel($nuit->getHotel());
                $nuite->setCategorie($nuit->getCategorie());
                $nuite->setInscription($inscription);
                $em->persist($nuite);
                
                $total += $nuit->getTarifNuite();
                $inscription->addNuite($nuite);
            }

            $user->setInscription($inscription);
            
            $em->persist($inscription);
            $em->persist($user);
            $em->flush();
            
            $emailTotal = (new TemplatedEmail())
                    ->from('egor_gut@outlook.fr')
                    ->to($email)
                    //->to('egor-gut@outlook.fr')
                    ->subject("Inscription mise en attente")
                    ->htmlTemplate('email/inscriptionAttente.html.twig')
                    ->context([
                'user' => $user,
                'total' => $total,
                'ateliers' => $inscription->getAteliers(),
                    ])
            ;

            $mailer->send($emailTotal);

            return $this->redirectToRoute('valider_inscription');
        }

        return $this->render('home/demandeInscription.html.twig', [
                    'form' => $form->createView(),
                    'user' => $user,
                    'proposer' => $proposer,
                    'hotels' => $hotels,
        ]);
    }
    
    #[Route('validerinscription', name: 'valider_inscription')]
    public function validerInscription(Request $r, EntityManagerInterface $em)
    {
        $user = $this->getUser();
        $inscription = $user->getInscription();
        
        if($r->request->get('inscriptionValide')){
            $inscription->setDateValidation(new \DateTime());
            $em->persist($inscription);
            $em->flush();
        }
        
        $fraisInscription = $this->getParameter('fraisInscription');
        $tarifRepas = $this->getParameter('tarifRepas');
        
        $total = $fraisInscription + $tarifRepas*count($inscription->getRestauration());
        
        foreach($inscription->getNuites() as $nuite){
            $propose = $em->getRepository(Proposer::class)->findOneBy(
                    ['hotel' => $nuite->getHotel(),
                    'categorie' => $nuite->getCategorie()->getId()]
            );
            $total += $propose->getTarifNuite();
        }
        $nuites = $inscription->getNuites();
        
        $restaurations = $inscription->getRestauration();
        return $this->render('/home/infoInscription.html.twig', [
            'inscription' => $inscription,
            'nuites' => $nuites,
            'restaurations' => $restaurations,
            'total' => $total,
            
        ]);
    }
}
