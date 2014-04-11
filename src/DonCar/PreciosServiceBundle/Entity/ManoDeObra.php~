<?php

namespace DonCar\PreciosServiceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Table(name="ps_manos_de_obra")
 * @ORM\Entity
 *
*/

class ManoDeObra{

	/**
	* @ORM\Id
	* @ORM\Column(type="integer")
	* @ORM\GeneratedValue(strategy="AUTO")
	*/
	protected $id;

	/**
	* @ORM\ManyToOne(targetEntity="Trabajo")
	* @ORM\JoinColumn(name="trabajo_id", referencedColumnName="id")
	*/
	protected $trabajo;

    /**
    * @ORM\Column(type="boolean")
    */
    protected $activo;

	/**
	* @ORM\ManyToOne(targetEntity="Service", inversedBy="manosDeObra")
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
     * Set activo
     *
     * @param boolean $activo
     * @return ManoDeObra
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get activo
     *
     * @return boolean 
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * Set trabajo
     *
     * @param \DonCar\PreciosServiceBundle\Entity\Trabajo $trabajo
     * @return ManoDeObra
     */
    public function setTrabajo(\DonCar\PreciosServiceBundle\Entity\Trabajo $trabajo = null)
    {
        $this->trabajo = $trabajo;

        return $this;
    }

    /**
     * Get trabajo
     *
     * @return \DonCar\PreciosServiceBundle\Entity\Trabajo 
     */
    public function getTrabajo()
    {
        return $this->trabajo;
    }

    /**
     * Set service
     *
     * @param \DonCar\PreciosServiceBundle\Entity\Service $service
     * @return ManoDeObra
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
