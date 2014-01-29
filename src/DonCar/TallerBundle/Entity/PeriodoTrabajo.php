<?php

namespace DonCar\TallerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use \DateTime;

/**
 * @ORM\Table(name="periodo_trabajo")
 * @ORM\Entity
 *
*/

class PeriodoTrabajo{

	/**
	* @ORM\Id
	* @ORM\Column(type="integer")
	* @ORM\GeneratedValue(strategy="AUTO")
	*/
	protected $id;

	/**
	* @ORM\Column(type="datetime")
	*/
	protected $inicio;

	/**
	* @ORM\Column(type="datetime",  nullable=true)
	*/
	protected $fin;

  	/**
     	* @ORM\ManyToOne(targetEntity="Orden", inversedBy="periodos")
     	* @ORM\JoinColumn(name="orden_id", referencedColumnName="id")
     	*/   
	protected $orden;

  	/**
     	* @ORM\ManyToOne(targetEntity="Mecanico", inversedBy="periodosTrabajados")
     	* @ORM\JoinColumn(name="mecanico_id", referencedColumnName="id")
     	*/   
	protected $mecanico;





   public function getTiempo(){
     if ($this->getFin()){
       $diferencia = $this->getFin()->diff( $this->getInicio());
     }else{
	$horaActual = new DateTime();
       $diferencia =  $horaActual->diff( $this->getInicio());
     }
      return $diferencia;
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
     * Set inicio
     *
     * @param \DateTime $inicio
     * @return PeriodoTrabajo
     */
    public function setInicio($inicio)
    {
        $this->inicio = $inicio;

        return $this;
    }

    /**
     * Get inicio
     *
     * @return \DateTime 
     */
    public function getInicio()
    {
        return $this->inicio;
    }

    /**
     * Set fin
     *
     * @param \DateTime $fin
     * @return PeriodoTrabajo
     */
    public function setFin($fin)
    {
        $this->fin = $fin;

        return $this;
    }

    /**
     * Get fin
     *
     * @return \DateTime 
     */
    public function getFin()
    {
        return $this->fin;
    }

    /**
     * Set orden
     *
     * @param \DonCar\TallerBundle\Entity\Orden $orden
     * @return PeriodoTrabajo
     */
    public function setOrden(\DonCar\TallerBundle\Entity\Orden $orden = null)
    {
        $this->orden = $orden;

        return $this;
    }

    /**
     * Get orden
     *
     * @return \DonCar\TallerBundle\Entity\Orden 
     */
    public function getOrden()
    {
        return $this->orden;
    }

    /**
     * Set mecanico
     *
     * @param \DonCar\TallerBundle\Entity\Mecanico $mecanico
     * @return PeriodoTrabajo
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
}
