<?php

namespace DonCar\TallerBundle\Entity;

use DateInterval;
use Doctrine\ORM\EntityRepository;

class OrdenRepository extends EntityRepository{


  public function findAllOrderedByNumero(){
    return $this->getEntityManager()
                ->createQuery('SELECT o FROM DonCarTallerBundle:Orden o ORDER BY o.numero DESC')
                ->getResult();
    }


  public function findOrdenesDelDia($fechaInicio){

  	$fechaFin = clone $fechaInicio;  
    $fechaFin->add(new DateInterval('P1D'));

  $qb = $this->createQueryBuilder('o')
    ->where('o.fechaAlta < :fechaFin AND o.fechaAlta > :fechaInicio')
    ->setParameter(':fechaFin', $fechaFin)
    ->setParameter(':fechaInicio', $fechaInicio)
    ->orderBy('o.numero', 'ASC');
   

  return $qb->getQuery()->getResult();
  }  


  public function getListBy($criteria){
    $qb = $this->createQueryBuilder('i');

    foreach ($criteria as $field => $value) {
        if (!$this->getClassMetadata()->hasField($field)) {
            // Make sure we only use existing fields (avoid any injection)
            continue;
        }

        $qb ->andWhere($qb->expr()->eq('i.'.$field, ':i_'.$field))
            ->setParameter('i_'.$field, $value);
    }

    return $qb->getQuery()->getResult();
}

public function getByFechaNumero($fechaInicio, $fechaFin, $numero){
  $qb = $this->createQueryBuilder('i');

  if($fechaInicio && $fechaFin){
    $fechaFin->add(new DateInterval('P1D'));
    $qb ->andWhere('i.fechaAlta < :fechaFin AND i.fechaAlta > :fechaInicio')
        ->setParameter(':fechaFin', $fechaFin)
        ->setParameter(':fechaInicio', $fechaInicio);
    }

  if($numero){
    $qb->andWhere("i.numero like '%".$numero."%'");
       

    //$qb ->andWhere($qb->expr()->eq('i.'.'numero', ':numero'))
    //    ->setParameter('numero', $numero);
  }

  $qb->orderBy('i.numero', 'DESC');
  return $qb->getQuery()->getResult();
}

public function findSinAsignar($estadoFinalizado){
  $qb = $this->createQueryBuilder('i');
  $qb->andWhere($qb->expr()->isNull('i.mecanico'));
  $qb->andWhere('i.estado != :estado');
  $qb->setParameter(':estado', $estadoFinalizado);
  return $qb->getQuery()->getResult();
}



}