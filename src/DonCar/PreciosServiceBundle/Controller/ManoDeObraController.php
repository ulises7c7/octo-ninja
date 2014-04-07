<?php

namespace DonCar\PreciosServiceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use DonCar\PreciosServiceBundle\Entity\TipoManoDeObra;
use DonCar\PreciosServiceBundle\Form\Type\ManoDeObraType;
use Symfony\Component\HttpFoundation\Request;

class ManoDeObraController extends Controller{
  public function administrarAction(){


  	$tiposManoDeObra= $this->getDoctrine()
    ->getRepository('DonCarPreciosServiceBundle:TipoManoDeObra')
    ->findAll(); 

    return $this->render(
    	'DonCarPreciosServiceBundle:Admin:administrarManoDeObra.html.twig', 
    	array('tiposmdo' => $tiposManoDeObra)
      );
  }

  public function altaAction(Request $request){
  	$mdo = new TipoManoDeObra();

    $form_alta = $this->createFormBuilder()
    ->add('codigo', 'text', array('label'=> 'Codigo'))
    ->add('nombre', 'text', array('label'=> 'Nombre'))
    ->add('descripcion', 'text', array('label'=> 'Descripcion'))
    ->add('precio', 'number', array('label'=> 'Precio'))
    ->getForm();

    $form_alta->handleRequest($request);

    if ($form_alta->isValid()) {
      $data = $form_alta->getData();

      $mdo->setCodigo($data['codigo'])
      ->setNombre($data['nombre'])
      ->setDescripcion($data['descripcion'])
      ->setPrecio($data['precio']);


      $em = $this->getDoctrine()->getManager();
      $em->persist($mdo);
      $em->flush();

      return $this->redirect($this->generateUrl('ps_mano_de_obra_administrar'));

    }

    return $this->render(
      'DonCarPreciosServiceBundle:Admin:altaManoDeObra.html.twig', 
      array('service' => $mdo, 'form_alta' => $form_alta->createView() )
      );

  }


  public function editarAction(Request $request, $id){
    $mdo = $this->getDoctrine()
    ->getRepository('DonCarPreciosServiceBundle:TipoManoDeObra')
    ->find($id); 

    $form_alta = $this->createForm(new ManoDeObraType(), $mdo);
    $form_alta->handleRequest($request);

    if ($form_alta->isValid()) {    

      $em = $this->getDoctrine()->getManager();
      $em->persist($mdo);
      $em->flush();

      return $this->redirect($this->generateUrl('ps_mano_de_obra_administrar'));

    }

    return $this->render(
      'DonCarPreciosServiceBundle:Admin:altaManoDeObra.html.twig', 
      array('service' => $mdo, 'form_alta' => $form_alta->createView() )
      );

  }



}
