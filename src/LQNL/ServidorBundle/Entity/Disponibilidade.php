<?php

namespace LQNL\ServidorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Disponibilidade
 */
class Disponibilidade
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $dia;

    /**
     * @var string
     */
    private $turno;

    /**
     * @var \LQNL\ServidorBundle\Entity\Usuario
     */
    private $responsavel;


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
     * Set dia
     *
     * @param \DateTime $dia
     * @return Disponibilidade
     */
    public function setDia($dia)
    {
        $this->dia = $dia;

        return $this;
    }

    /**
     * Get dia
     *
     * @return \DateTime 
     */
    public function getDia()
    {
        return $this->dia;
    }

    /**
     * Set turno
     *
     * @param string $turno
     * @return Disponibilidade
     */
    public function setTurno($turno)
    {
        $this->turno = $turno;

        return $this;
    }

    /**
     * Get turno
     *
     * @return string 
     */
    public function getTurno()
    {
        return $this->turno;
    }

    /**
     * Set responsavel
     *
     * @param \LQNL\ServidorBundle\Entity\Usuario $responsavel
     * @return Disponibilidade
     */
    public function setResponsavel(\LQNL\ServidorBundle\Entity\Usuario $responsavel = null)
    {
        $this->responsavel = $responsavel;

        return $this;
    }

    /**
     * Get responsavel
     *
     * @return \LQNL\ServidorBundle\Entity\Usuario 
     */
    public function getResponsavel()
    {
        return $this->responsavel;
    }
}
