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

class OrdenesController extends Controller{

public function detenerOrdenAction($mecanicoid, $ordenid){
  $mensaje = '0';
  $em = $this->getDoctrine()->getManager();

  $orden = $this->getDoctrine()
                ->getRepository('DonCarTallerBundle:Orden')
                ->find($ordenid); 

  $mecanico = $this->getDoctrine()
                   ->getRepository('DonCarTallerBundle:Mecanico')
                   ->find($mecanicoid); 

  $estadoDetenido = $this->getDoctrine()
                  ->getRepository('DonCarTallerBundle:EstadoOrden')
                  ->findOneByNumero(EstadoOrden::DETENIDO); 

 $mecanico->getOrdenesAsignadas()->add($orden);
  $orden->setMecanico($mecanico);

  //array('errores' y 'mensaje')
  $result = $orden->detener($mecanico, $estadoDetenido);
  $em->persist($orden);
  $em->flush();
  $mensaje = '1';
  return $this->render('DonCarTallerBundle:Default:mensaje.html.twig', array('mensaje' => $mensaje));
}


public function iniciarOrdenAction($mecanicoid, $ordenid){
  $mensaje = '0';
  $em = $this->getDoctrine()->getManager();

  $orden = $this->getDoctrine()
                ->getRepository('DonCarTallerBundle:Orden')
                ->find($ordenid); 

  $mecanico = $this->getDoctrine()
                   ->getRepository('DonCarTallerBundle:Mecanico')
                   ->find($mecanicoid); 

  $estadoIniciado = $this->getDoctrine()
                  ->getRepository('DonCarTallerBundle:EstadoOrden')
                  ->findOneByNumero(EstadoOrden::EN_EJECUCION); 


  $mecanico->getOrdenesAsignadas()->add($orden);
  $orden->setMecanico($mecanico);


  //array('errores' y 'mensaje')
  $result = $orden->iniciar($mecanico, $estadoIniciado);
  $em->persist($orden);
  $em->flush();
  $mensaje = '1';
  return $this->render('DonCarTallerBundle:Default:mensaje.html.twig', array('mensaje' => $mensaje));
}

public function finalizarOrdenAction($mecanicoid, $ordenid){
  $mensaje = '0';
  $em = $this->getDoctrine()->getManager();

  $orden = $this->getDoctrine()
                ->getRepository('DonCarTallerBundle:Orden')
                ->find($ordenid); 

  $mecanico = $this->getDoctrine()
                   ->getRepository('DonCarTallerBundle:Mecanico')
                   ->find($mecanicoid); 

  $estadoFinalizado = $this->getDoctrine()
                  ->getRepository('DonCarTallerBundle:EstadoOrden')
                  ->findOneByNumero(EstadoOrden::FINALIZADA); 

  $result = $orden->finalizar($mecanico, $estadoFinalizado);

  $mecanico->getOrdenesAsignadas()->removeElement($orden);
  $orden->setMecanico(null);

  $em->persist($mecanico);
  $em->persist($orden);

  $em->flush();
  $mensaje = '1';
  return $this->render('DonCarTallerBundle:Default:mensaje.html.twig', array('mensaje' => $mensaje));
}

public function tercerizarOrdenAction($mecanicoid, $ordenid){
  $mensaje = '0';
$em = $this->getDoctrine()->getManager();

  $orden = $this->getDoctrine()
                ->getRepository('DonCarTallerBundle:Orden')
                ->find($ordenid); 

  $mecanico = $this->getDoctrine()
                   ->getRepository('DonCarTallerBundle:Mecanico')
                   ->find($mecanicoid); 

  $estadoTercerizado = $this->getDoctrine()
                  ->getRepository('DonCarTallerBundle:EstadoOrden')
                  ->findOneByNumero(EstadoOrden::TERCERIZADO); 
  
  $result = $orden->tercerizar($mecanico, $estadoTercerizado);

  $mecanico->getOrdenesAsignadas()->removeElement($orden);
  $orden->setMecanico(null);

  $em->persist($mecanico);
  $em->persist($orden);

  $em->flush();
  $mensaje = '1';
  return $this->render('DonCarTallerBundle:Default:mensaje.html.twig', array('mensaje' => $mensaje));
}

public function ponerEnEsperaOrdenAction($mecanicoid, $ordenid){
  $mensaje = '0';
$em = $this->getDoctrine()->getManager();

  $orden = $this->getDoctrine()
                ->getRepository('DonCarTallerBundle:Orden')
                ->find($ordenid); 

  $mecanico = $this->getDoctrine()
                   ->getRepository('DonCarTallerBundle:Mecanico')
                   ->find($mecanicoid); 

  $estadoEspera = $this->getDoctrine()
                  ->getRepository('DonCarTallerBundle:EstadoOrden')
                  ->findOneByNumero(EstadoOrden::ESPERA_REPUESTOS); 
  
  $result = $orden->ponerEnEspera($mecanico, $estadoEspera);

  $mecanico->getOrdenesAsignadas()->removeElement($orden);
  $orden->setMecanico(null);

  $em->persist($mecanico);
  $em->persist($orden);

  $em->flush();

  
  $mensaje = '1';
  return $this->render('DonCarTallerBundle:Default:mensaje.html.twig', array('mensaje' => $mensaje));
}


public function listarOrdenesMecanicoAction($mecanicoid){
  $ordenesMecanico = null;
  $mensaje = null;
  $mecanico = null;

  //Obtener mecanico mediante numero
  $mecanico = $this->getDoctrine()
                   ->getRepository('DonCarTallerBundle:Mecanico')
                   ->find($mecanicoid); 

  if($mecanico){
    $ordenesMecanico = $mecanico->getOrdenesAsignadas();
    if (count($ordenesMecanico)==0){
      $mensaje = 'No tiene ordenes asignadas';
    }
  }else{
    $mensaje = "Numero de mecanico incorrecto";
  }

    $estadoFinalizado = $this->getDoctrine()
                  ->getRepository('DonCarTallerBundle:EstadoOrden')
                  ->findOneByNumero(EstadoOrden::FINALIZADA); 

  $ordenesSinAsignar = $this->getDoctrine()
                ->getRepository('DonCarTallerBundle:Orden')
                ->findSinAsignar($estadoFinalizado); 

  $params = array(
    'mecanico' => $mecanico, 
    'ordenes' => $ordenesMecanico,
    'ordenesSinAsignar' => $ordenesSinAsignar, 
    'mensaje'=> $mensaje); 

  return $this->render('DonCarTallerBundle:Default:listarOrdenesMecanicoTabla.html.twig', $params);
}




public function liberarOrdenAction($mecanicoid, $ordenid){
  $mensaje = '0';
$em = $this->getDoctrine()->getManager();

  $orden = $this->getDoctrine()
                ->getRepository('DonCarTallerBundle:Orden')
                ->find($ordenid); 

  $mecanico = $this->getDoctrine()
                   ->getRepository('DonCarTallerBundle:Mecanico')
                   ->find($mecanicoid); 

  $estadoDetenido = $this->getDoctrine()
                  ->getRepository('DonCarTallerBundle:EstadoOrden')
                  ->findOneByNumero(EstadoOrden::DETENIDO); 
  
  $result = $orden->ponerEnEspera($mecanico, $estadoDetenido);

  $mecanico->getOrdenesAsignadas()->removeElement($orden);
  $orden->setMecanico(null);

  $em->persist($mecanico);
  $em->persist($orden);

  $em->flush();
  $mensaje = '1';
  return $this->render('DonCarTallerBundle:Default:mensaje.html.twig', array('mensaje' => $mensaje));
}


// Nueva ventana de gestion

public function gestionOrdenAction(Request $request){
  $form = $this->createFormBuilder()
               ->add('numero_mecanico', 'text')
               ->add('Ver mis ordenes', 'submit')
               ->getForm();

  $ordenesMecanico = null;
  $mensaje = null;
  $mecanico = null;

  $form->handleRequest($request);
  if ($form->isValid()) {
    //Obtener numero de mecanico del formulario
    $data = $form->getData();
    $numeroMecanico = $data['numero_mecanico'];

    //Obtener mecanico mediante numero
    $mecanico = $this->getDoctrine()
                    ->getRepository('DonCarTallerBundle:Mecanico')
                    ->findOneByNumero($numeroMecanico);
    if($mecanico){
      $ordenesMecanico = $mecanico ->getOrdenesAsignadas();

      if (count($ordenesMecanico)==0){
        $mensaje = 'No tiene ordenes asignadas';
      }

    }else{
      $mensaje = "Numero de mecanico incorrecto";
    }
  }

    $estadoFinalizado = $this->getDoctrine()
                  ->getRepository('DonCarTallerBundle:EstadoOrden')
                  ->findOneByNumero(EstadoOrden::FINALIZADA); 

   $ordenesSinAsignar = $this->getDoctrine()
                ->getRepository('DonCarTallerBundle:Orden')
                ->findSinAsignar($estadoFinalizado); 
 
  $params = array('mecanico' => $mecanico, 
    'ordenes' => $ordenesMecanico,
    'form' => $form->createView(), 
    'ordenesSinAsignar' => $ordenesSinAsignar, 
    'mensaje'=> $mensaje); 

  return $this->render('DonCarTallerBundle:Default:listarOrdenesMecanico.html.twig',$params);
}

}
