<?php

namespace DonCar\PreciosServiceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use DonCar\PreciosServiceBundle\Entity\Vehiculo;
use DonCar\PreciosServiceBundle\Form\Type\VehiculoType;
use Symfony\Component\HttpFoundation\Request;

class VehiculoController extends Controller{
  public function administrarAction(){
  	$vehiculos = $this->getDoctrine()
        ->getRepository('DonCarPreciosServiceBundle:Vehiculo')
        ->findAll(); 
    return $this->render(
    	'DonCarPreciosServiceBundle:Admin:administrarVehiculos.html.twig', 
    	array('vehiculos' => $vehiculos)
    );
  }

  public function altaAction(Request $request){
  	$vehiculo = new Vehiculo();

    $form_alta = $this->createForm(new VehiculoType(), $vehiculo, array(
      'action' => $this->generateUrl('ps_vehiculo_alta'),
      'method' => 'GET',
    ));

    $form_alta->handleRequest($request);

    if ($form_alta->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($vehiculo);
      $em->flush();
      return $this->redirect($this->generateUrl('ps_vehiculo_administrar'));
    }

    return $this->render(
      'DonCarPreciosServiceBundle:Admin:altaVehiculo.html.twig', 
      array('form_alta' => $form_alta->createView() )
    );

  }



  public function editarAction(Request $request, $id){
    $vehiculo = $this->getDoctrine()
    ->getRepository('DonCarPreciosServiceBundle:Vehiculo')
    ->find($id); 

    $form_alta = $this->createForm(new VehiculoType(), $vehiculo, array(
      'action' => $this->generateUrl('ps_vehiculo_editar', array('id' => $id)),
      'method' => 'GET',
    ));

    $form_alta->handleRequest($request);

    if ($form_alta->isValid()) {    
      $em = $this->getDoctrine()->getManager();
      $em->persist($vehiculo);
      $em->flush();
      return $this->redirect($this->generateUrl('ps_vehiculo_administrar'));
    }

    return $this->render(
      'DonCarPreciosServiceBundle:Admin:altaVehiculo.html.twig', 
      array('vehiculo' => $vehiculo, 'form_alta' => $form_alta->createView() )
    );

  }
}
