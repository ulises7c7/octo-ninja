<?php

namespace DonCar\PreciosServiceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use DonCar\PreciosServiceBundle\Entity\TipoManoDeObra;
use DonCar\PreciosServiceBundle\Entity\Trabajo;
use DonCar\PreciosServiceBundle\Form\Type\TrabajoType;
use Symfony\Component\HttpFoundation\Request;

class TrabajoController extends Controller{

  public function altaAction(Request $request){
  	$trabajo = new Trabajo();

    $form_alta = $this->createForm(new TrabajoType(), $trabajo, array(
      'action' => $this->generateUrl('ps_trabajo_alta'),
      'method' => 'GET',
    ));

    $form_alta->handleRequest($request);

    if ($form_alta->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($trabajo);
      $em->flush();
      return $this->redirect($this->generateUrl('ps_mano_de_obra_administrar'));
    }

    return $this->render(
      'DonCarPreciosServiceBundle:Admin:altaTrabajo.html.twig', 
      array('form_alta' => $form_alta->createView() )
    );

  }




  public function editarAction(Request $request, $id){
    $trabajo = $this->getDoctrine()
    ->getRepository('DonCarPreciosServiceBundle:Trabajo')
    ->find($id); 

    $form_alta = $this->createForm(new TrabajoType(), $trabajo, array(
      'action' => $this->generateUrl('ps_trabajo_editar', array('id' => $id)),
      'method' => 'GET',
    ));

    $form_alta->handleRequest($request);

    if ($form_alta->isValid()) {    
      $em = $this->getDoctrine()->getManager();
      $em->persist($trabajo);
      $em->flush();
      return $this->redirect($this->generateUrl('ps_mano_de_obra_administrar'));
    }

    return $this->render(
      'DonCarPreciosServiceBundle:Admin:altaTrabajo.html.twig', 
      array('trabajo' => $trabajo, 'form_alta' => $form_alta->createView() )
    );

  }


  public function eliminarAction($id){
    $trabajo = $this->getDoctrine()
    ->getRepository('DonCarPreciosServiceBundle:Trabajo')
    ->find($id); 

    $em = $this->getDoctrine()->getManager();
    $em->remove($trabajo);
    $em->flush();

    return $this->redirect($this->generateUrl('ps_mano_de_obra_administrar'));
  }

}
