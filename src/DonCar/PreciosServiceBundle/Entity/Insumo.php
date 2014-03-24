<?php

namespace DonCar\PreciosServiceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Table(name="ps_insumos")
 * @ORM\Entity
 *
*/

class Insumo{

	/**
	* @ORM\Id
	* @ORM\Column(type="integer")
	* @ORM\GeneratedValue(strategy="AUTO")
	*/
	protected $id;

  	/**
	* @ORM\Column(type="string", length=100, unique=true)
	*/
	protected $nombre;

    /**
    * @ORM\Column(type="string", length=500)
    */
    protected $descripcion;


	/**
	* @ORM\ManyToOne(targetEntity="Repuesto")
	* @ORM\JoinColumn(name="repuesto_id", referencedColumnName="id")
	*/
	protected $repuesto;


	/**
	* @ORM\ManyToOne(targetEntity="Condicion")
	* @ORM\JoinColumn(name="condicion_id", referencedColumnName="id")
	*/
	protected $condicion;


	/**
	* @ORM\ManyToOne(targetEntity="Service", inversedBy="insumos")
	* @ORM\JoinColumn(name="service_id", referencedColumnName="id")
	*/
	protected $service;




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
     * Set nombre
     *
     * @param string $nombre
     * @return Insumo
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return Insumo
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set repuesto
     *
     * @param \DonCar\PreciosServiceBundle\Entity\Repuesto $repuesto
     * @return Insumo
     */
    public function setRepuesto(\DonCar\PreciosServiceBundle\Entity\Repuesto $repuesto = null)
    {
        $this->repuesto = $repuesto;

        return $this;
    }

    /**
     * Get repuesto
     *
     * @return \DonCar\PreciosServiceBundle\Entity\Repuesto 
     */
    public function getRepuesto()
    {
        return $this->repuesto;
    }

    /**
     * Set condicion
     *
     * @param \DonCar\PreciosServiceBundle\Entity\Condicion $condicion
     * @return Insumo
     */
    public function setCondicion(\DonCar\PreciosServiceBundle\Entity\Condicion $condicion = null)
    {
        $this->condicion = $condicion;

        return $this;
    }

    /**
     * Get condicion
     *
     * @return \DonCar\PreciosServiceBundle\Entity\Condicion 
     */
    public function getCondicion()
    {
        return $this->condicion;
    }

    /**
     * Set service
     *
     * @param \DonCar\PreciosServiceBundle\Entity\Service $service
     * @return Insumo
     */
    public function setService(\DonCar\PreciosServiceBundle\Entity\Service $service = null)
    {
        $this->service = $service;

        return $this;
    }

    /**
     * Get service
     *
     * @return \DonCar\PreciosServiceBundle\Entity\Service 
     */
    public function getService()
    {
        return $this->service;
    }
}
