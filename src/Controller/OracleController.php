<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use App\Entity\Licencie;
use App\Entity\Club;
use App\Entity\Qualite;

class OracleController extends AbstractController {

    #[Route('/oracle', name: 'app_oracle')]
    public function index(): JsonResponse {
        return $this->json([
                    'message' => 'Welcome to your new controller!',
                    'path' => 'src/Controller/OracleController.php',
        ]);
    }

    /**
     * Retourne un licencie selon l'idée fournie dans l'url
     * 
     * @param EntityManagerInterface $em
     * @param Request $r
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    #[Route('/getlicenicie/{numlicence}', name: 'getlicencie')]
    public function getLicencie(EntityManagerInterface $em, Request $r, SerializerInterface $serializer): JsonResponse {
        $numlicence = $r->get('numlicence');

        $licencie = $em->getRepository(Licencie::class)->findOneBy(['numlicence' => $numlicence]);

        $licencieJson = $serializer->serialize($licencie, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);
        return new JsonResponse($licencieJson, Response::HTTP_OK, [], true);
    }

    /**
     * Retourne la liste de tous les licencies
     * 
     * @param EntityManagerInterface $em
     * @param Request $r
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    #[Route('/getlicenicies/{numlicence}', name: 'getlicencies')]
    public function getLicencies(EntityManagerInterface $em, SerializerInterface $serializer): JsonResponse {
        $licencies = $em->getRepository(Licencie::class)->findAll();

        $licenciesJson = $serializer->serialize($licencies, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);
        return new JsonResponse($licenciesJson, Response::HTTP_OK, [], true);
    }
}
