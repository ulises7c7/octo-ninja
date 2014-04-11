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
    * @ORM\OneToMany(targetEntity="ManoDeObra", mappedBy="service", cascade={"persist", "remove"})
    */
    protected $manosDeObra;


    /**
    * @ORM\OneToMany(targetEntity="Insumo", mappedBy="service", cascade={"persist", "remove"})
    */
    protected $insumos;

    /**
    * @ORM\Column(type="decimal")
    */
    protected $precioComp;


    /**
    * @ORM\Column(type="decimal")
    */
    protected $precioVW;    /**
     * Constructor
     */
    public function __construct()
    {
        $this->manosDeObra = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set precioComp
     *
     * @param string $precioComp
     * @return Service
     */
    public function setPrecioComp($precioComp)
    {
        $this->precioComp = $precioComp;

        return $this;
    }

    /**
     * Get precioComp
     *
     * @return string 
     */
    public function getPrecioComp()
    {
        return $this->precioComp;
    }

    /**
     * Set precioVW
     *
     * @param string $precioVW
     * @return Service
     */
    public function setPrecioVW($precioVW)
    {
        $this->precioVW = $precioVW;

        return $this;
    }

    /**
     * Get precioVW
     *
     * @return string 
     */
    public function getPrecioVW()
    {
        return $this->precioVW;
    }

    /**
     * Set vehiculo
     *
     * @param \DonCar\PreciosServiceBundle\Entity\Vehiculo $vehiculo
     * @return Service
     */
    public function setVehiculo(\DonCar\PreciosServiceBundle\Entity\Vehiculo $vehiculo = null)
    {
        $this->vehiculo = $vehiculo;

        return $this;
    }

    /**
     * Get vehiculo
     *
     * @return \DonCar\PreciosServiceBundle\Entity\Vehiculo 
     */
    public function getVehiculo()
    {
        return $this->vehiculo;
    }

    /**
     * Add manosDeObra
     *
     * @param \DonCar\PreciosServiceBundle\Entity\ManoDeObra $manosDeObra
     * @return Service
     */
    public function addManosDeObra(\DonCar\PreciosServiceBundle\Entity\ManoDeObra $manosDeObra)
    {
        $this->manosDeObra[] = $manosDeObra;

        return $this;
    }

    /**
     * Remove manosDeObra
     *
     * @param \DonCar\PreciosServiceBundle\Entity\ManoDeObra $manosDeObra
     */
    public function removeManosDeObra(\DonCar\PreciosServiceBundle\Entity\ManoDeObra $manosDeObra)
    {
        $this->manosDeObra->removeElement($manosDeObra);
    }

    /**
     * Get manosDeObra
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getManosDeObra()
    {
        return $this->manosDeObra;
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
