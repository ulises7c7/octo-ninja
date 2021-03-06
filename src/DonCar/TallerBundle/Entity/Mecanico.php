<?php

namespace DonCar\TallerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="mecanicos")
 * @ORM\Entity
 *
*/

class Mecanico{
    const ESTADO_ACTIVO = 1;
    const ESTADO_OCIOSO = 2;

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
	* @ORM\Column(type="string", length=100)
	*/
	protected $nombre;

	/**
	* @ORM\Column(type="string", length=100)
	*/
	protected $apellido;

	/**
     	* @ORM\OneToMany(targetEntity="Orden", mappedBy="mecanico", cascade={"persist", "remove"})
     	*/
	protected $ordenesAsignadas;

	/**
     	* @ORM\OneToMany(targetEntity="PeriodoTrabajo", mappedBy="mecanico", cascade={"persist", "remove"})
     	*/
	protected $periodosTrabajados;


    public function isActivo(){
      $activo = false;
      foreach ($this->getOrdenesAsignadas() as $orden) {
        if ($orden->getEstado()->getNumero()==EstadoOrden::EN_EJECUCION){
          $activo = true;
        }
      }
      return $activo;
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
     * @return Mecanico
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
     * Set username
     *
     * @param string $username
     * @return Mecanico
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return Mecanico
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Mecanico
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
     * Set apellido
     *
     * @param string $apellido
     * @return Mecanico
     */
    public function setApellido($apellido)
    {
        $this->apellido = $apellido;

        return $this;
    }

    /**
     * Get apellido
     *
     * @return string 
     */
    public function getApellido()
    {
        return $this->apellido;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->periodosTrabajados = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add periodosTrabajados
     *
     * @param \DonCar\TallerBundle\Entity\PeriodoTrabajo $periodosTrabajados
     * @return Mecanico
     */
    public function addPeriodosTrabajado(\DonCar\TallerBundle\Entity\PeriodoTrabajo $periodosTrabajados)
    {
        $this->periodosTrabajados[] = $periodosTrabajados;

        return $this;
    }

    /**
     * Remove periodosTrabajados
     *
     * @param \DonCar\TallerBundle\Entity\PeriodoTrabajo $periodosTrabajados
     */
    public function removePeriodosTrabajado(\DonCar\TallerBundle\Entity\PeriodoTrabajo $periodosTrabajados)
    {
        $this->periodosTrabajados->removeElement($periodosTrabajados);
    }

    /**
     * Get periodosTrabajados
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPeriodosTrabajados()
    {
        return $this->periodosTrabajados;
    }

    /**
     * Add ordenesAsignadas
     *
     * @param \DonCar\TallerBundle\Entity\Orden $ordenesAsignadas
     * @return Mecanico
     */
    public function addOrdenesAsignadas(\DonCar\TallerBundle\Entity\Orden $ordenesAsignadas)
    {
        $this->ordenesAsignadas[] = $ordenesAsignadas;

        return $this;
    }

    /**
     * Remove ordenesAsignadas
     *
     * @param \DonCar\TallerBundle\Entity\Orden $ordenesAsignadas
     */
    public function removeOrdenesAsignada(\DonCar\TallerBundle\Entity\Orden $ordenesAsignadas)
    {
        $this->ordenesAsignadas->removeElement($ordenesAsignadas);
    }

    /**
     * Get ordenesAsignadas
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOrdenesAsignadas()
    {
        return $this->ordenesAsignadas;
    }

    /**
     * Set estado
     *
     * @param string $estado
     * @return Mecanico
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return string 
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Add ordenesAsignadas
     *
     * @param \DonCar\TallerBundle\Entity\Orden $ordenesAsignadas
     * @return Mecanico
     */
    public function addOrdenesAsignada(\DonCar\TallerBundle\Entity\Orden $ordenesAsignadas)
    {
        $this->ordenesAsignadas[] = $ordenesAsignadas;

        return $this;
    }
}
