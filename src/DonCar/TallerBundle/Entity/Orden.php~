<?php

namespace DonCar\TallerBundle\Entity;

use \DateTime;
use \DateInterval;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Table(name="ordenes")
 * @ORM\Entity(repositoryClass="DonCar\TallerBundle\Entity\OrdenRepository")
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
	* @ORM\Column(type="datetime",  nullable=true)
	*/
	protected $fechaAlta;

  	/**
	* @ORM\Column(type="integer")
	*/
	protected $tiempo;

 	/**
     	* @Assert\Type(type="DonCar\TallerBundle\Entity\Mecanico")
     	*/
	/**
	* @ORM\ManyToOne(targetEntity="Mecanico", inversedBy="ordenesAsignadas")
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
  return $this->cambiarEstado($mecanico,$estado_iniciado);
  $mecanico->addOrdenesAsignadas($this);
  $this->setMecanico($mecanico);
}

public function detener($mecanico, $estado_detenido){
  return $this->cambiarEstado($mecanico,$estado_detenido);
}

public function finalizar($mecanico, $estado_finalizado){
  return $this->cambiarEstado($mecanico,$estado_finalizado);
}

public function liberar($mecanico, $estado_detenido){
  return $this->cambiarEstado($mecanico,$estado_detenido);
}

public function tercerizar($mecanico, $estado_tercerizado){
  return $this->cambiarEstado($mecanico,$estado_tercerizado);
}

public function ponerEnEspera($mecanico, $estado_en_espera){
  return $this->cambiarEstado($mecanico,$estado_en_espera);
}


private function cambiarEstado($mecanico,$estado){
    $ultimoEvento = null;
    $periodosActuales = $this->getPeriodosTrabajo();
    if ($periodosActuales && (count($periodosActuales) > 0)){
        $ultimoEvento = $periodosActuales->get(count($periodosActuales)-1);
    }

    $nuevoEvento = new PeriodoTrabajo();
    $nuevoEvento->setMecanico($mecanico);
    $nuevoEvento->setOrden($this);
    $horaActual = new \DateTime("now");
    $nuevoEvento->setInicio($horaActual);
    if($ultimoEvento){
        $ultimoEvento->setFin($horaActual);
    }
    $nuevoEvento->setEstadoOrden($estado);
    
    $this->setEstado($estado);
    $this->addPeriodosTrabajo($nuevoEvento);

    return true;
}


   public function getTiempoTrabajado(){
	$periodos = $this->getPeriodosTrabajo();
	$e = new DateTime('00:00');
	$f = clone $e;
	foreach($periodos as $periodo){
      if ($periodo->getEstadoOrden()->getNumero() == EstadoOrden::EN_EJECUCION){
	    $e->add($periodo->getTiempo());
      }
    }
	return $f->diff($e);
   }

   public function getPeriodosDeEjecucion(){
    $cont = 0;
    $periodos = $this->getPeriodosTrabajo();
    foreach($periodos as $periodo){
      if ($periodo->getEstadoOrden()->getNumero() == EstadoOrden::EN_EJECUCION){
        $cont++;  
      }
    }
    return $cont;
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

    /**
     * Set fechaAlta
     *
     * @param \DateTime $fechaAlta
     * @return Orden
     */
    public function setFechaAlta($fechaAlta)
    {
        $this->fechaAlta = $fechaAlta;

        return $this;
    }

    /**
     * Get fechaAlta
     *
     * @return \DateTime 
     */
    public function getFechaAlta()
    {
        return $this->fechaAlta;
    }
}
