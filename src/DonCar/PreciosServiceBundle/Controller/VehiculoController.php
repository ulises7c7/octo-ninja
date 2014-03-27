<?php

namespace DonCar\PreciosServiceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class VehiculoController extends Controller{
  public function administrarAction()    {


  	$vehiculos = $this->getDoctrine()
        ->getRepository('DonCarPreciosServiceBundle:Vehiculo')
        ->findAll(); 

    return $this->render(
    	'DonCarPreciosServiceBundle:Admin:administrarVehiculos.html.twig', 
    	array('vehiculos' => $vehiculos)
    );
  }
}
