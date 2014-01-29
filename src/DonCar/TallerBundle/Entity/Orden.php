<?php

namespace DonCar\TallerBundle\Entity;

use \DateTime;
use \DateInterval;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="ordenes")
 * @ORM\Entity
 *
*/

class Orden{

  //TODO: Convertir e variables de clase de la clase EstadoOrden
  private $DETENIDO = 1;
  private $EN_EJECUCION = 2;

	/**
	* @ORM\Id
	* @ORM\Column(type="integer")
	* @ORM\GeneratedValue(strategy="AUTO")
	*/
	protected $id;

  	/**
	* @ORM\Column(type="string", length=100)
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
  if ($this->getEstado()->getNumero() == $DETENIDO){
	$nuevoTrabajo = new PeriodoTrabajo();
	$nuevoTrabajo->setMecanico($mecanico);
	$nuevoTrabajo->setOrden($this);
	$horaActual = new \DateTime("now");
	$nuevoTrabajo->setInicio($horaActual);
	
	$this->setEstado($estado_iniciado);
	$this->setMecanico($mecanico);
	$this->addPeriodosTrabajo($nuevoTrabajo);
  }else {
	//TODO: Tratar excepcion
	$msj = "No se pudo iniciar el trabajo"
	return  $msj;
 }
}


public function detener($mecanico, $estado_detenido){
  $errores = true;
  $msj = "No se pudo detener el trabajo";

  if($mecanico->getId() != $this->getMecanico()->getId()){
	//TODO: Tratar excepcion
	$errores = true;
	$msj = "No se pudo detener el trabajo porque la orden esta asignada a otro mecanico";
  }elseif($this->getEstado()-getNumero() == $EN_EJECUCION){
	
	//Obtener ultimo trabajo
	$periodos = $this->getPeriodosTrabajo();
	$cant = count($periodos);
	$ultimoTrabajo = $periodosOrden->get($cant -1);

	//Establecer datos ultimo trabajo
	$horaActual = new \DateTime("now");
	$ultimoTrabajo->setFin($horaActual);
	
	//Estabecer datos de la orden
	$this->setEstado($estado_detenido);
	$errores = false;
	$msj = "La operacion se completo exitosamente";

  }else{
	//TODO: Tratar excepcion
	$errores = true;
	$msj = "No se pudo detener el trabajo porque no esta en ejecucion";
  }
  
  return  array('errores'=> $errores, 'mensaje'=> $msj);

}

private function iniciarDetener($mecanico, $estado){

  if ($this->getEstado()->getNumero()== $DETENIDO){
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
