<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use App\Form\DemandeInscriptionType;
use App\Entity\Inscription;
use \App\Entity\Nuite;
use App\Entity\Proposer;
use App\Entity\Hotel;


class InscriptionController extends AbstractController
{   
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

        return $this->render('inscription/demandeInscription.html.twig', [
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
        return $this->render('/inscription/infoInscription.html.twig', [
            'inscription' => $inscription,
            'nuites' => $nuites,
            'restaurations' => $restaurations,
            'total' => $total,
            
        ]);
    }
}
