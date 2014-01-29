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

class OrdenesController extends Controller{

public function eliminarOrdenAction($id){

  $orden = $this->getDoctrine()
        ->getRepository('DonCarTallerBundle:Orden')
        ->find($id); 
  //Obtener entity manager
  $em = $this->getDoctrine()->getManager();

  $em->remove($orden);
  $em->flush();

  return $this->render('DonCarTallerBundle:Default:mensaje.html.twig', array('mensaje' => 'Se ha eliminado la orden'));
}


public function gestionarOrdenAction(Request $request){
    $errores = false;
    $mensaje = "";   
    $logger = $this->get('logger');
    $estado = null;

    $defaultData = array('ordnum' => '0000000');
    $form = $this->createFormBuilder($defaultData)
        ->add('numero_mecanico', 'text')
        ->add('numero_orden', 'text')
	->add('Acepar','submit')
        ->getForm();
 
    $form->handleRequest($request);
 
    if ($form->isValid()) {
        $data = $form->getData();

	$numeroMecanico = $data['numero_mecanico'];
	$numeroOrden = $data['numero_orden'];

	//Buscar Mecanico en base de datos
	$mecanico = $this->getDoctrine()
        ->getRepository('DonCarTallerBundle:Mecanico')
        ->findOneByNumero($numeroMecanico);
 
	//Comprobar existencia de mecanico
    	if ($mecanico) {
	  //Buscar Orden en base de datos
	  $orden = $this->getDoctrine()
          	->getRepository('DonCarTallerBundle:Orden')
          	->findOneByNumero($numeroOrden);
    	
	  //Comprobar existencia de Orden
	  if ($orden) {

 	    //Obtener entity manager
    	    $em = $this->getDoctrine()->getManager();

	    //Obtener estado correspondiente
	    $estadoDetenido = $this->getDoctrine()
        	->getRepository('DonCarTallerBundle:EstadoOrden')
		->findOneByNumero(1);
 
	    $estadoEnEjecucion = $this->getDoctrine()
        	->getRepository('DonCarTallerBundle:EstadoOrden')
		->findOneByNumero(2); 

	    if ($orden->getEstado()->getNumero() == EstadoOrden::EN_EJECUCION){
	      $result = $orden->detener($mecanico, $estadoDetenido);
	    }else{
	      $result = $orden->iniciar($mecanico, $estadoEnEjecucion);
	    }
	      $mensaje = $result['mensaje'];

	    //Guardar todos los cambios en la base de datos
    	    $em->flush();

	  }else{
            $errores = true;
            $mensaje = 'No se ha cargado la orden con el numero: '.$numeroOrden;
          }

	}else{
          $errores = true;
          $mensaje = 'No se ha cargado el mecanico con el numero: '.$numeroMecanico;
        }

  
  } //Cierra isValid
	

        return $this->render('DonCarTallerBundle:Default:gestionOrden.html.twig',
		array('form' => $form->createView(),'mensaje' => $mensaje));
} //Cierra el Action






public function gestionOrdenAction(Request $request){
    $logger = $this->get('logger');
    $INICIADO = 1;
    $REANUDADO = 2;
    $DETENIDO = 3;
    $estado = null;

    $defaultData = array('ordnum' => '0000000');
    $form = $this->createFormBuilder($defaultData)
        ->add('numero_mecanico', 'text')
        ->add('numero_orden', 'text')
	->add('Acepar','submit')
        ->getForm();
 
    $form->handleRequest($request);
    
    if ($form->isValid()) {
        $data = $form->getData();



	$numeroMecanico = $data['numero_mecanico'];
	$numeroOrden = $data['numero_orden'];

	//Buscar Mecanico en base de datos
	$mecanico = $this->getDoctrine()
        ->getRepository('DonCarTallerBundle:Mecanico')
        ->findOneByNumero($numeroMecanico);
 
	//Comprobar existencia de mecanico
    	if (!$mecanico) {
          throw $this->createNotFoundException(
            'No se ha cargado el mecanico con el numero: '.$numeroMecanico);
        }

	//Buscar Orden en base de datos
	$orden = $this->getDoctrine()
        ->getRepository('DonCarTallerBundle:Orden')
        ->findOneByNumero($numeroOrden);
    	
	//Comprobar existencia de Orden
	if (!$orden) {
          throw $this->createNotFoundException(
            'No se ha cargado la orden con el numero: '.$numeroOrden);
        }

	//Comprobar asignacion de orden a mecanico especificado
	if ($orden->getMecanico() != $mecanico)	{
          throw $this->createNotFoundException(
            'La orden '.$numeroOrden.' pero no se ha asignado al mecanico '.$numeroMecanico);
	}

	$logger->info('Se encontraron el mecanico y la orden`');


	$periodosOrden = $orden->getPeriodosTrabajo();
	if ($periodosOrden == null){
	  $logger->info('la lista de periodos es null');
	  $periodosOrden = array();
	  $logger->info('se asigno un array vacio');
	}

	//Obtener hora actual	
	$horaActual = new \DateTime("now");

	//Obtener entity manager
    	$em = $this->getDoctrine()->getManager();
	
	//Insertar un nuevo periodos si es el primer trabajo
	if ( count($periodosOrden) == 0){
	  $periodo = new PeriodoTrabajo();
	  $orden->addPeriodosTrabajo($periodo);
	  $periodo->setOrden($orden);
    	  $em->persist($periodo);
	  $periodo->setInicio($horaActual);	
	  

    $estado_objeto = $this->getDoctrine()
        ->getRepository('DonCarTallerBundle:EstadoOrden')
        ->find(2); 
    $orden->setEstado($estado_objeto);


	  $estado = $INICIADO;
	}else{

	  $periodosOrden = $orden->getPeriodosTrabajo();
	  $cant = count($periodosOrden);
	  $ultimoPeriodo = $periodosOrden->get($cant -1);

	  if ($ultimoPeriodo->getFin() == null){
	    $ultimoPeriodo->setFin($horaActual);
	    $estado = $DETENIDO;

    $estado_objeto = $this->getDoctrine()
        ->getRepository('DonCarTallerBundle:EstadoOrden')
        ->find(1); 
    $orden->setEstado($estado_objeto);


	  }else{
	    $periodo = new PeriodoTrabajo();
	    $orden->addPeriodosTrabajo($periodo);
	    $periodo->setOrden($orden);
    	    $em->persist($periodo);
	    $periodo->setInicio($horaActual);	
	    $estado= $REANUDADO;

    $estado_objeto = $this->getDoctrine()
        ->getRepository('DonCarTallerBundle:EstadoOrden')
        ->find(2); 
    $orden->setEstado($estado_objeto);



	  }
	}
	//Guardar todos los cambios en la base de datos
    	$em->flush();

    }

    //Crear mensajes
    $msj = null;
    switch ($estado) {
      case $INICIADO:
        $msj = "La tarea se ha iniciado \n Para detenerla ingrese nuevamente su Numero de Mecanico y Numero de Orden \n";
        break;
      case $REANUDADO:
        $msj = "El trabajo se ha renudado";
        break;
      case $DETENIDO:
        $msj = "El trabajo se ha detenido \n Para continuar trabajando en la misma orden vuelva a ingresar su Numero de Mecanico y Numero de Orden";
        break;
      }
	

        return $this->render('DonCarTallerBundle:Default:gestionOrden.html.twig',array('form' => $form->createView(),'mensaje' => $msj));
}


public function listarOrdenAction(){
	$ordenes = $this->getDoctrine()
        ->getRepository('DonCarTallerBundle:Orden')
        ->findAll();
	
	$params = array(
	 'ordenes' => $ordenes,);	

	return $this->render('DonCarTallerBundle:Default:listarOrden.html.twig',$params);
}


public function altaOrdenAction(Request $request){
  $orden = new Orden();
  $form = $this->createForm(new OrdenType(), $orden);
  $form->handleRequest($request);

  if ($form->isValid()) {
    $estado_objeto = $this->getDoctrine()
        ->getRepository('DonCarTallerBundle:EstadoOrden')
        ->find(1); 
    $orden->setEstado($estado_objeto);
 
    $em = $this->getDoctrine()->getManager();
    $em->persist($orden);
    $em->flush();

    return $this->redirect($this->generateUrl('taller_listar_orden'));
  }

  return $this->render('DonCarTallerBundle:Default:altaOrden.html.twig', array('form' => $form->createView(),)); 
}

}
