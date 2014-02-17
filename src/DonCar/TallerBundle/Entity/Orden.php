<?php

namespace DonCar\TallerBundle\Entity;

use \DateTime;
use \DateInterval;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Table(name="ordenes")
 * @ORM\Entity
 * @UniqueEntity(fields="numero", message="La orden ya esta cargada")
 *
*/

class Orden{

	/**
	* @ORM\Id
	* @ORM\Column(type="integer")
	* @ORM\GeneratedValue(strategy="AUTO")
	*/
	protected $id;

  	/**
	* @ORM\Column(type="string", length=100, unique=true)
	*/
	protected $numero;

  	/**
	* @ORM\Column(type="integer")
	*/
	protected $tiempo;

 	/**
     	* @Assert\Type(type="DonCar\TallerBundle\Entity\Mecanico")
     	*/
	/**
	* @ORM\ManyToOne(targetEntity="Mecanico")
	* @ORM\JoinColumn(name="mecanico_id", referencedColumnName="id")
	*/
	protected $mecanico;

 	/**
     	* @Assert\Type(type="DonCar\TallerBundle\Entity\EstadoOrden")
     	*/
	/**
	* @ORM\ManyToOne(targetEntity="EstadoOrden")
	* @ORM\JoinColumn(name="estado_id", referencedColumnName="id")
	*/
	protected $estado;

	 /**
     	* @ORM\OneToMany(targetEntity="PeriodoTrabajo", mappedBy="orden", cascade={"persist", "remove"})
     	*/
	protected $periodosTrabajo;


public function iniciar($mecanico, $estado_iniciado){
  $msj = '';
  $errores = true;
  if ($this->getEstado()->getNumero() == EstadoOrden::DETENIDO){
	$nuevoTrabajo = new PeriodoTrabajo();
	$nuevoTrabajo->setMecanico($mecanico);
	$nuevoTrabajo->setOrden($this);
	$horaActual = new \DateTime("now");
	$nuevoTrabajo->setInicio($horaActual);
	
	$this->setEstado($estado_iniciado);
	$this->setMecanico($mecanico);
	$this->addPeriodosTrabajo($nuevoTrabajo);

	//Setear mensajes caso favorable
	$errores = false;
	$msj = "Se ha iniciado el trabajo";
  }else {
	//Tratar Otro caso
	$errores = true;
	$msj = "No se pudo iniciar el trabajo, la orden esta finalizada";
 }
 return  array('errores'=> $errores, 'mensaje'=> $msj);
}


public function detener($mecanico, $estado_detenido){
  $errores = true;
  $msj = "No se pudo detener el trabajo";

  if($mecanico->getId() != $this->getMecanico()->getId()){
	//Tratar caso 'Asignada a otro mecanico'
	$errores = true;
	$msj = "No se pudo detener el trabajo porque la orden esta asignada a otro mecanico";

  }elseif($this->getEstado()->getNumero() == EstadoOrden::EN_EJECUCION){
	
	//Obtener ultimo trabajo
	$periodos = $this->getPeriodosTrabajo();
	$cant = count($periodos);
	$ultimoTrabajo = $periodos->get($cant -1);

	//Establecer datos ultimo trabajo
	$horaActual = new \DateTime("now");
	$ultimoTrabajo->setFin($horaActual);
	
	//Estabecer datos de la orden
	$this->setEstado($estado_detenido);
	$errores = false;
	$msj = "Se detuvo el trabajo";

  }else{
	//TODO: Tratar excepcion
	$errores = true;
	$msj = "No se pudo detener el trabajo porque no esta en ejecucion";
  }
  
  return  array('errores'=> $errores, 'mensaje'=> $msj);

}

private function iniciarDetener($mecanico, $estado){

  if ($this->getEstado()->getNumero()== EstadoOrden::DETENIDO){
	return $this->iniciar($mecanico, $estado);
  }else
	return $this->detener($mecanico, $estado);
}



   public function getTiempoTrabajado(){
	$periodos = $this->getPeriodosTrabajo();
	$e = new DateTime('00:00');
	$f = clone $e;
	foreach($periodos as $periodo){
	  $e->add($periodo->getTiempo());
        }
	return $f->diff($e);
   }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->periodosTrabajo = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set numero
     *
     * @param string $numero
     * @return Orden
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get numero
     *
     * @return string 
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set tiempo
     *
     * @param integer $tiempo
     * @return Orden
     */
    public function setTiempo($tiempo)
    {
        $this->tiempo = $tiempo;

        return $this;
    }

    /**
     * Get tiempo
     *
     * @return integer 
     */
    public function getTiempo()
    {
        return $this->tiempo;
    }

    /**
     * Set mecanico
     *
     * @param \DonCar\TallerBundle\Entity\Mecanico $mecanico
     * @return Orden
     */
    public function setMecanico(\DonCar\TallerBundle\Entity\Mecanico $mecanico = null)
    {
        $this->mecanico = $mecanico;

        return $this;
    }

    /**
     * Get mecanico
     *
     * @return \DonCar\TallerBundle\Entity\Mecanico 
     */
    public function getMecanico()
    {
        return $this->mecanico;
    }

    /**
     * Add periodosTrabajo
     *
     * @param \DonCar\TallerBundle\Entity\PeriodoTrabajo $periodosTrabajo
     * @return Orden
     */
    public function addPeriodosTrabajo(\DonCar\TallerBundle\Entity\PeriodoTrabajo $periodosTrabajo)
    {
        $this->periodosTrabajo[] = $periodosTrabajo;

        return $this;
    }

    /**
     * Remove periodosTrabajo
     *
     * @param \DonCar\TallerBundle\Entity\PeriodoTrabajo $periodosTrabajo
     */
    public function removePeriodosTrabajo(\DonCar\TallerBundle\Entity\PeriodoTrabajo $periodosTrabajo)
    {
        $this->periodosTrabajo->removeElement($periodosTrabajo);
    }

    /**
     * Get periodosTrabajo
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPeriodosTrabajo()
    {
        return $this->periodosTrabajo;
    }

    /**
     * Set estado
     *
     * @param \DonCar\TallerBundle\Entity\EstadoOrden $estado
     * @return Orden
     */
    public function setEstado(\DonCar\TallerBundle\Entity\EstadoOrden $estado = null)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return \DonCar\TallerBundle\Entity\EstadoOrden 
     */
    public function getEstado()
    {
        return $this->estado;
    }
}
