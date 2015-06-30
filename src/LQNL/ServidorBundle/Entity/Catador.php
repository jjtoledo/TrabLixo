<?php

namespace LQNL\ServidorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Catador
 */
class Catador
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $nome;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $telefone;

    /**
     * @var \DateTime
     */
    private $nascimento;

    /**
     * @var \LQNL\ServidorBundle\Entity\Endereco
     */
    private $endereco;


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
     * Set nome
     *
     * @param string $nome
     * @return Catador
     */
    public function setNome($nome)
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * Get nome
     *
     * @return string 
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Catador
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set telefone
     *
     * @param string $telefone
     * @return Catador
     */
    public function setTelefone($telefone)
    {
        $this->telefone = $telefone;

        return $this;
    }

    /**
     * Get telefone
     *
     * @return string 
     */
    public function getTelefone()
    {
        return $this->telefone;
    }

    /**
     * Set nascimento
     *
     * @param \DateTime $nascimento
     * @return Catador
     */
    public function setNascimento($nascimento)
    {
        $this->nascimento = $nascimento;

        return $this;
    }

    /**
     * Get nascimento
     *
     * @return \DateTime 
     */
    public function getNascimento()
    {
        return $this->nascimento;
    }

    /**
     * Set endereco
     *
     * @param \LQNL\ServidorBundle\Entity\Endereco $endereco
     * @return Catador
     */
    public function setEndereco(\LQNL\ServidorBundle\Entity\Endereco $endereco = null)
    {
        $this->endereco = $endereco;

        return $this;
    }

    /**
     * Get endereco
     *
     * @return \LQNL\ServidorBundle\Entity\Endereco 
     */
    public function getEndereco()
    {
        return $this->endereco;
    }
}
