<?php

namespace App\Service;

use Symfony\Component\DependencyInjection\Service\ServiceInterface;

/**
 * Description of APIOracle
 *
 * @author egor_
 */
class APIOracle {
    
    protected $connexion;
    
    private function __construct() {
        $this->connexion = oci_connect("mdl", "mdl", "//freesio.lyc-bonaparte.fr:22140/");
    }
    
    public function connect()
    {
        if (self::$instance == null) {
            self::$instance = new APIOracle();
        }
        return self::$instance;
    }
}
