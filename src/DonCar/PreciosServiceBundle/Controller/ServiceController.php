<?php

namespace DonCar\PreciosServiceBundle\Controller;

use DonCar\PreciosServiceBundle\Entity\Service;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ServiceController extends Controller
{
  public function editarAction($id){
    $service = $this->getDoctrine()
        ->getRepository('DonCarPreciosServiceBundle:Service')
        ->find($id); 

    return $this->render('DonCarPreciosServiceBundle:Admin:editarService.html.twig', array('service' => $service));
  }


  public function verAction($id){
    $service = $this->getDoctrine()
        ->getRepository('DonCarPreciosServiceBundle:Service')
        ->find($id); 

    $condiciones = $this->getDoctrine()
        ->getRepository('DonCarPreciosServiceBundle:Condicion')
        ->findAll(); 

    return $this->render('DonCarPreciosServiceBundle:Usuario:verService.html.twig', array('service' => $service, 'condiciones' => $condiciones));
  }

  public function administrarAction()    {
  	$services = $this->getDoctrine()
        ->getRepository('DonCarPreciosServiceBundle:Service')
        ->findAll(); 

    return $this->render(
    	'DonCarPreciosServiceBundle:Admin:administrarServices.html.twig', 
    	array('services' => $services)
    );
  }



  public function listarAction()    {
    $services = $this->getDoctrine()
        ->getRepository('DonCarPreciosServiceBundle:Service')
        ->findAll(); 

    return $this->render(
      'DonCarPreciosServiceBundle:Usuario:listarServices.html.twig', 
      array('services' => $services)
    );
  }


  public function altaAction(Request $request){
    $service = new Service();

    $form_alta = $this->createFormBuilder()
      ->add('vehiculo', 'entity', array('class'=>'DonCarPreciosServiceBundle:Vehiculo', 'property'=>'nombre', 'label'=>'Vehiculo'))
      ->add('descripcion', 'text', array('label'=> 'Descripcion'))
      ->add('preciosbs', 'number', array('label'=> 'Precio SBS'))
      ->add('preciovw', 'number', array('label'=> 'Precio VW'))
      ->getForm();

    $form_alta->handleRequest($request);

    if ($form_alta->isValid()) {
    $data = $form_alta->getData();
    
    $service->setDescripcion($data['descripcion'])
      ->setPrecioComp($data['preciosbs'])
      ->setPrecioVW($data['preciovw'])
      ->setVehiculo($data['vehiculo']);

    $em = $this->getDoctrine()->getManager();
    $em->persist($service);
    $em->flush();
    return $this->redirect($this->generateUrl('ps_service_administrar'));
        
    }

    return $this->render(
      'DonCarPreciosServiceBundle:Admin:altaService.html.twig', 
      array('service' => $service, 'form_alta' => $form_alta->createView() )
    );

  }


}
