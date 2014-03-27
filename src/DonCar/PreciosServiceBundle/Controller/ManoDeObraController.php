<?php

namespace DonCar\PreciosServiceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ManoDeObraController extends Controller{
  public function administrarAction()    {


  	$tiposManoDeObra= $this->getDoctrine()
        ->getRepository('DonCarPreciosServiceBundle:TipoManoDeObra')
        ->findAll(); 

    return $this->render(
    	'DonCarPreciosServiceBundle:Admin:administrarManoDeObra.html.twig', 
    	array('tiposmdo' => $tiposManoDeObra)
    );
  }
}
