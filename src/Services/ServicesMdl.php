<?php
namespace App\Services;

use App\Entity\Inscription;
use \App\Entity\Nuite;
use App\Entity\Proposer;
use App\Entity\Hotel;
use App\Entity\Atelier;
use App\Entity\Theme;
use App\Entity\Vacation;
use Doctrine\ORM\EntityManagerInterface;


abstract class ServicesMdl {
    
    static public function calculTotalInscri(Inscription $inscri, int $tarifRepas, int $fraisInscri) :int
    {
        $total = 0;
        
        return $total;
    }
}