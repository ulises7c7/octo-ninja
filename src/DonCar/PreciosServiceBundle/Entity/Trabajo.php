<?php

namespace DonCar\PreciosServiceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Table(name="ps_trabajos")
 * @ORM\Entity
 *
*/

class Trabajo{
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
    * @ORM\Column(type="string", length=500, nullable=true)
    */
    protected $descripcion;

    /**
    * @ORM\ManyToOne(targetEntity="TipoManoDeObra")
    * @ORM\JoinColumn(name="mdo_id", referencedColumnName="id")
    */
    protected $tipoManoDeObra;

    /**
    * @ORM\Column(type="float", nullable=true, precision=3 )
    */
    protected $precio;

    /**
    * @ORM\Column(type="float", nullable=true, precision=3)
    */
    protected $tiempo;

    /**
    * @ORM\Column(type="boolean", nullable=true)
    */
    protected $costoPorUso;

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
     * @return Trabajo
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
     * @return Trabajo
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
     * Set precio
     *
     * @param float $precio
     * @return Trabajo
     */
    public function setPrecio($precio)
    {
        $this->precio = $precio;

        return $this;
    }

    /**
     * Get precio
     *
     * @return float 
     */
    public function getPrecio()
    {
        return $this->precio;
    }

    /**
     * Set tiempo
     *
     * @param float $tiempo
     * @return Trabajo
     */
    public function setTiempo($tiempo)
    {
        $this->tiempo = $tiempo;

        return $this;
    }

    /**
     * Get tiempo
     *
     * @return float 
     */
    public function getTiempo()
    {
        return $this->tiempo;
    }

    /**
     * Set costoPorUso
     *
     * @param boolean $costoPorUso
     * @return Trabajo
     */
    public function setCostoPorUso($costoPorUso)
    {
        $this->costoPorUso = $costoPorUso;

        return $this;
    }

    /**
     * Get costoPorUso
     *
     * @return boolean 
     */
    public function getCostoPorUso()
    {
        return $this->costoPorUso;
    }

    /**
     * Set tipoManoDeObra
     *
     * @param \DonCar\PreciosServiceBundle\Entity\TipoManoDeObra $tipoManoDeObra
     * @return Trabajo
     */
    public function setTipoManoDeObra(\DonCar\PreciosServiceBundle\Entity\TipoManoDeObra $tipoManoDeObra = null)
    {
        $this->tipoManoDeObra = $tipoManoDeObra;

        return $this;
    }

    /**
     * Get tipoManoDeObra
     *
     * @return \DonCar\PreciosServiceBundle\Entity\TipoManoDeObra 
     */
    public function getTipoManoDeObra()
    {
        return $this->tipoManoDeObra;
    }
}
