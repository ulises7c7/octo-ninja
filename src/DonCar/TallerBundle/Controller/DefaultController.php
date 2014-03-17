<?php

namespace DonCar\TallerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use DonCar\TallerBundle\Form\Type\MecanicoType;
use DonCar\TallerBundle\Entity\PeriodoTrabajo;
use DonCar\TallerBundle\Entity\Mecanico;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{


public function indexAction($name){
  return $this->render('DonCarTallerBundle:Default:index.html.twig', array('name' => $name));
}

public function operacionExitosaAction(){
  return $this->render('DonCarTallerBundle:Default:operacionExitosa.html.twig', array());
}

public function notasAction(){
  return $this->render('DonCarTallerBundle:Default:notas.html.twig', array());
}



}
