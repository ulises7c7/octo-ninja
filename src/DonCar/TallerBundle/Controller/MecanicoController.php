<?php

namespace DonCar\TallerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use DonCar\TallerBundle\Form\Type\MecanicoType;
use DonCar\TallerBundle\Entity\PeriodoTrabajo;
use DonCar\TallerBundle\Entity\Mecanico;
use Symfony\Component\HttpFoundation\Request;

class MecanicoController extends Controller
{


public function indexAction($name){
  return $this->render('DonCarTallerBundle:Default:index.html.twig', array('name' => $name));
}

public function eliminarMecanicoAction($id){

  $mecanico = $this->getDoctrine()
        ->getRepository('DonCarTallerBundle:Mecanico')
        ->find($id); 
  //Obtener entity manager
  $em = $this->getDoctrine()->getManager();

  $em->remove($mecanico);
  $em->flush();

  return $this->render('DonCarTallerBundle:Default:mensaje.html.twig', array('mensaje' => 'Se ha eliminado el mecanico.'));
}



public function editarMecanicoAction(Request $request, $id){
  $mecanico = $this->getDoctrine()
        ->getRepository('DonCarTallerBundle:Mecanico')
        ->find($id); 
  $form = $this->createForm(new MecanicoType(), $mecanico);
  $form->handleRequest($request);

  if ($form->isValid()) {
    $em = $this->getDoctrine()->getManager();
    $em->persist($mecanico);
    $em->flush();

    return $this->redirect($this->generateUrl('taller_listar_mecanico'));
  }

  return $this->render('DonCarTallerBundle:Default:altaMecanico.html.twig', array('form' => $form->createView(),)); 
} //Fin editar mecanico



public function altaMecanicoAction(Request $request){
  $mecanico = new Mecanico();
  $form = $this->createForm(new MecanicoType(), $mecanico);
  $form->handleRequest($request);

  if ($form->isValid()) {
    $em = $this->getDoctrine()->getManager();
    $em->persist($mecanico);
    $em->flush();

    return $this->redirect($this->generateUrl('taller_listar_mecanico'));
  }

  return $this->render('DonCarTallerBundle:Default:altaMecanico.html.twig', array('form' => $form->createView(),)); 
}

public function listarMecanicoAction(){
	$mecanicos = $this->getDoctrine()
        ->getRepository('DonCarTallerBundle:Mecanico')
        ->findAll();
	
	$params = array(
	 'mecanicos' => $mecanicos,);	

	return $this->render('DonCarTallerBundle:Default:listarMecanico.html.twig',$params);
}





public function operacionExitosaAction(){
  return $this->render('DonCarTallerBundle:Default:operacionExitosa.html.twig', array());
}


}