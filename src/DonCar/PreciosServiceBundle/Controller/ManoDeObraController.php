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

    $trabajos= $this->getDoctrine()
    ->getRepository('DonCarPreciosServiceBundle:Trabajo')
    ->findAll(); 

    return $this->render(
    	'DonCarPreciosServiceBundle:Admin:administrarManoDeObra.html.twig', 
    	array('tiposmdo' => $tiposManoDeObra, 'trabajos' => $trabajos)
      );
  }

  public function altaAction(Request $request){
  	$mdo = new TipoManoDeObra();

    $form_alta = $this->createForm(new ManoDeObraType(), $mdo, array(
      'action' => $this->generateUrl('ps_mano_de_obra_alta'),
      'method' => 'GET',
    ));

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


  public function editarAction(Request $request, $id){
    $mdo = $this->getDoctrine()
    ->getRepository('DonCarPreciosServiceBundle:TipoManoDeObra')
    ->find($id); 

    $form_alta = $this->createForm(new ManoDeObraType(), $mdo, array(
      'action' => $this->generateUrl('ps_mano_de_obra_editar', array('id' => $id)),
      'method' => 'GET',
    ));

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

  public function eliminarAction($id){
    $mdo = $this->getDoctrine()
    ->getRepository('DonCarPreciosServiceBundle:TipoManoDeObra')
    ->find($id); 

    $em = $this->getDoctrine()->getManager();
    $em->remove($mdo);
    $em->flush();

    return $this->redirect($this->generateUrl('ps_mano_de_obra_administrar'));
  }

}
