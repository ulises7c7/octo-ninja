<?php

namespace DonCar\PreciosServiceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Table(name="ps_services")
 * @ORM\Entity
 *
*/

class Service{

	/**
	* @ORM\Id
	* @ORM\Column(type="integer")
	* @ORM\GeneratedValue(strategy="AUTO")
	*/
	protected $id;

    /**
    * @ORM\Column(type="string", length=500)
    */
    protected $descripcion;

	/**
	* @ORM\ManyToOne(targetEntity="Vehiculo")
	* @ORM\JoinColumn(name="vehiculo_id", referencedColumnName="id")
	*/
	protected $vehiculo;


	/**
    * @ORM\OneToMany(targetEntity="Insumo", mappedBy="service", cascade={"persist", "remove"})
    */
	protected $insumos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->insumos = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set descripcion
     *
     * @param string $descripcion
     * @return Service
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
     * Set vehiculo
     *
     * @param \DonCar\PreciosServiceBundle\Entity\Vehiculos $vehiculo
     * @return Service
     */
    public function setVehiculo(\DonCar\PreciosServiceBundle\Entity\Vehiculos $vehiculo = null)
    {
        $this->vehiculo = $vehiculo;

        return $this;
    }

    /**
     * Get vehiculo
     *
     * @return \DonCar\PreciosServiceBundle\Entity\Vehiculos 
     */
    public function getVehiculo()
    {
        return $this->vehiculo;
    }

    /**
     * Add insumos
     *
     * @param \DonCar\PreciosServiceBundle\Entity\Insumo $insumos
     * @return Service
     */
    public function addInsumo(\DonCar\PreciosServiceBundle\Entity\Insumo $insumos)
    {
        $this->insumos[] = $insumos;

        return $this;
    }

    /**
     * Remove insumos
     *
     * @param \DonCar\PreciosServiceBundle\Entity\Insumo $insumos
     */
    public function removeInsumo(\DonCar\PreciosServiceBundle\Entity\Insumo $insumos)
    {
        $this->insumos->removeElement($insumos);
    }

    /**
     * Get insumos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getInsumos()
    {
        return $this->insumos;
    }
}