<?php

namespace LQNL\ClienteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Solicitacao
 */
class Solicitacao
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $data;

    /**
     * @var string
     */
    private $observacoes;

    /**
     * @var integer
     */
    private $papel;

    /**
     * @var integer
     */
    private $metal;

    /**
     * @var integer
     */
    private $eletronico;

    /**
     * @var integer
     */
    private $vidro;

    /**
     * @var integer
     */
    private $plastico;

    /**
     * @var integer
     */
    private $outros;

    /**
     * @var string
     */
    private $status;

    /**
     * @var \LQNL\ClienteBundle\Entity\Catador
     */
    private $catador;

    /**
     * @var \LQNL\ClienteBundle\Entity\Disponibilidade
     */
    private $disponibilidade1;

    /**
     * @var \LQNL\ClienteBundle\Entity\Disponibilidade
     */
    private $disponibilidade2;

    /**
     * @var \LQNL\ClienteBundle\Entity\Disponibilidade
     */
    private $disponibilidade3;

    /**
     * @var \LQNL\ClienteBundle\Entity\Usuario
     */
    private $usuario;


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
     * Set data
     *
     * @param \DateTime $data
     * @return Solicitacao
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get data
     *
     * @return \DateTime 
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set observacoes
     *
     * @param string $observacoes
     * @return Solicitacao
     */
    public function setObservacoes($observacoes)
    {
        $this->observacoes = $observacoes;

        return $this;
    }

    /**
     * Get observacoes
     *
     * @return string 
     */
    public function getObservacoes()
    {
        return $this->observacoes;
    }

    /**
     * Set papel
     *
     * @param integer $papel
     * @return Solicitacao
     */
    public function setPapel($papel)
    {
        $this->papel = $papel;

        return $this;
    }

    /**
     * Get papel
     *
     * @return integer 
     */
    public function getPapel()
    {
        return $this->papel;
    }

    /**
     * Set metal
     *
     * @param integer $metal
     * @return Solicitacao
     */
    public function setMetal($metal)
    {
        $this->metal = $metal;

        return $this;
    }

    /**
     * Get metal
     *
     * @return integer 
     */
    public function getMetal()
    {
        return $this->metal;
    }

    /**
     * Set eletronico
     *
     * @param integer $eletronico
     * @return Solicitacao
     */
    public function setEletronico($eletronico)
    {
        $this->eletronico = $eletronico;

        return $this;
    }

    /**
     * Get eletronico
     *
     * @return integer 
     */
    public function getEletronico()
    {
        return $this->eletronico;
    }

    /**
     * Set vidro
     *
     * @param integer $vidro
     * @return Solicitacao
     */
    public function setVidro($vidro)
    {
        $this->vidro = $vidro;

        return $this;
    }

    /**
     * Get vidro
     *
     * @return integer 
     */
    public function getVidro()
    {
        return $this->vidro;
    }

    /**
     * Set plastico
     *
     * @param integer $plastico
     * @return Solicitacao
     */
    public function setPlastico($plastico)
    {
        $this->plastico = $plastico;

        return $this;
    }

    /**
     * Get plastico
     *
     * @return integer 
     */
    public function getPlastico()
    {
        return $this->plastico;
    }

    /**
     * Set outros
     *
     * @param integer $outros
     * @return Solicitacao
     */
    public function setOutros($outros)
    {
        $this->outros = $outros;

        return $this;
    }

    /**
     * Get outros
     *
     * @return integer 
     */
    public function getOutros()
    {
        return $this->outros;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return Solicitacao
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set catador
     *
     * @param \LQNL\ClienteBundle\Entity\Catador $catador
     * @return Solicitacao
     */
    public function setCatador(\LQNL\ClienteBundle\Entity\Catador $catador = null)
    {
        $this->catador = $catador;

        return $this;
    }

    /**
     * Get catador
     *
     * @return \LQNL\ClienteBundle\Entity\Catador 
     */
    public function getCatador()
    {
        return $this->catador;
    }

    /**
     * Set disponibilidade1
     *
     * @param \LQNL\ClienteBundle\Entity\Disponibilidade $disponibilidade1
     * @return Solicitacao
     */
    public function setDisponibilidade1(\LQNL\ClienteBundle\Entity\Disponibilidade $disponibilidade1 = null)
    {
        $this->disponibilidade1 = $disponibilidade1;

        return $this;
    }

    /**
     * Get disponibilidade1
     *
     * @return \LQNL\ClienteBundle\Entity\Disponibilidade 
     */
    public function getDisponibilidade1()
    {
        return $this->disponibilidade1;
    }

    /**
     * Set disponibilidade2
     *
     * @param \LQNL\ClienteBundle\Entity\Disponibilidade $disponibilidade2
     * @return Solicitacao
     */
    public function setDisponibilidade2(\LQNL\ClienteBundle\Entity\Disponibilidade $disponibilidade2 = null)
    {
        $this->disponibilidade2 = $disponibilidade2;

        return $this;
    }

    /**
     * Get disponibilidade2
     *
     * @return \LQNL\ClienteBundle\Entity\Disponibilidade 
     */
    public function getDisponibilidade2()
    {
        return $this->disponibilidade2;
    }

    /**
     * Set disponibilidade3
     *
     * @param \LQNL\ClienteBundle\Entity\Disponibilidade $disponibilidade3
     * @return Solicitacao
     */
    public function setDisponibilidade3(\LQNL\ClienteBundle\Entity\Disponibilidade $disponibilidade3 = null)
    {
        $this->disponibilidade3 = $disponibilidade3;

        return $this;
    }

    /**
     * Get disponibilidade3
     *
     * @return \LQNL\ClienteBundle\Entity\Disponibilidade 
     */
    public function getDisponibilidade3()
    {
        return $this->disponibilidade3;
    }

    /**
     * Set usuario
     *
     * @param \LQNL\ClienteBundle\Entity\Usuario $usuario
     * @return Solicitacao
     */
    public function setUsuario(\LQNL\ClienteBundle\Entity\Usuario $usuario = null)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return \LQNL\ClienteBundle\Entity\Usuario 
     */
    public function getUsuario()
    {
        return $this->usuario;
    }
}
