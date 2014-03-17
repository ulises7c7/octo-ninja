<?php

namespace DonCar\TallerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use DonCar\TallerBundle\Form\Type\MecanicoType;
use DonCar\TallerBundle\Form\Type\OrdenType;
use DonCar\TallerBundle\Entity\PeriodoTrabajo;
use DonCar\TallerBundle\Entity\Mecanico;
use DonCar\TallerBundle\Entity\EstadoOrden;
use DonCar\TallerBundle\Entity\Orden;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\Tools\Pagination\Paginator;
use DateInterval;

class OrdenesABMController extends Controller{

public function listarOrdenAction(Request $request){
  //Obtener parametros de filtro por fecha
  $em = $this->getDoctrine()->getManager();

  $form = $this ->createFormBuilder()
  ->add('numero', 'text')
              ->add('fecha', 'date', array(
                    'input'  => 'datetime',
                    'widget' => 'choice',
                    'data' => new \DateTime("now"),
                    'empty_value' => '',
                    'format' => 'dd / MM / yyyy' ))
              ->add('hasta', 'date', array(
                    'input'  => 'datetime',
                    'widget' => 'choice',
                    'data' => new \DateTime("now"),
                    'empty_value' => '',
                    'format' => 'dd / MM / yyyy' ))
              
              ->getForm();

  $form->handleRequest($request);

  
  $fechaInicio = new \DateTime("now");  
  $fechaFin = clone $fechaInicio;  
  $numero = '';
  
  if ($form->isValid()) {
    $data = $form->getData();
    $fechaInicio = $data['fecha'];
    $numero = $data['numero'];
    $fechaFin == $data['hasta'];
  }



  $ordenes = $this->getDoctrine()
                    ->getRepository('DonCarTallerBundle:Orden')
                    ->getByFechaNumero($fechaInicio, $fechaFin, $numero );

  $params = array('ordenes' => $ordenes,'form' => $form->createView(),); 

  return $this->render('DonCarTallerBundle:Default:listarOrden.html.twig',$params);

} //fin listarOrdenAction()


public function editarOrdenAction(Request $request, $id){
  $orden = $this->getDoctrine()
                ->getRepository('DonCarTallerBundle:Orden')
                ->find($id); 
  $form = $this->createForm(new OrdenType(), $orden);
  $form->handleRequest($request);
  if ($form->isValid()) {
    $em = $this->getDoctrine()->getManager();
    $em->persist($orden);
    $em->flush();
    return $this->redirect($this->generateUrl('taller_listar_orden'));
  }
  return $this->render('DonCarTallerBundle:Default:altaOrden.html.twig', 
      array('form' => $form->createView(),)); 
} //Fin editarOrdenAction()


public function altaOrdenAction(Request $request){
  $orden = new Orden();
  $form = $this->createForm(new OrdenType(), $orden);
  $form->handleRequest($request);

  if ($form->isValid()) {
    $estado_objeto = $this->getDoctrine()
        ->getRepository('DonCarTallerBundle:EstadoOrden')
        ->find(1); 
    $orden->setEstado($estado_objeto);

    //Obtener hora actual 
    $horaActual = new \DateTime("now");
    $orden->setFechaAlta($horaActual);
 
    $em = $this->getDoctrine()->getManager();
    $em->persist($orden);
    $em->flush();

    return $this->redirect($this->generateUrl('taller_listar_orden'));
  }

  return $this->render('DonCarTallerBundle:Default:altaOrden.html.twig', array('form' => $form->createView(),)); 
} //Fin altaOrdenAction()

//ABM: B

public function eliminarOrdenAction($id){

  $orden = $this->getDoctrine()
        ->getRepository('DonCarTallerBundle:Orden')
        ->find($id); 
  //Obtener entity manager
  $em = $this->getDoctrine()->getManager();

  $em->remove($orden);
  $em->flush();

  return $this->render('DonCarTallerBundle:Default:mensaje.html.twig', array('mensaje' => 'Se ha eliminado la orden'));
} //Fin eliminarOrdenAction

}
