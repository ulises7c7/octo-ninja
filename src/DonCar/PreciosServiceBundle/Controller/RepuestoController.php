<?php

namespace DonCar\PreciosServiceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RepuestoController extends Controller{
  public function administrarAction()    {


  	$repuetos = $this->getDoctrine()
        ->getRepository('DonCarPreciosServiceBundle:Repuesto')
        ->findAll(); 

    return $this->render(
    	'DonCarPreciosServiceBundle:Admin:administrarRepuestos.html.twig', 
    	array('repuestos' => $repuetos)
    );
  }
}
