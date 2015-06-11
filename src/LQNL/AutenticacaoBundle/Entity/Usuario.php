<?php

namespace LQNL\AutenticacaoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;

/**
 * Usuario
 */
class Usuario implements UserInterface, EquatableInterface {

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
    private $telefone;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $tipo;

    /**
     * @var \LQNL\AutenticacaoBundle\Entity\Endereco
     */
    private $endereco;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set nome
     *
     * @param string $nome
     * @return Usuario
     */
    public function setNome($nome) {
        $this->nome = $nome;

        return $this;
    }

    /**
     * Get nome
     *
     * @return string 
     */
    public function getNome() {
        return $this->nome;
    }

    /**
     * Set telefone
     *
     * @param string $telefone
     * @return Usuario
     */
    public function setTelefone($telefone) {
        $this->telefone = $telefone;

        return $this;
    }

    /**
     * Get telefone
     *
     * @return string 
     */
    public function getTelefone() {
        return $this->telefone;
    }

    /**
     * Set username
     *
     * @param string $username
     * @return Usuario
     */
    public function setUsername($username) {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return Usuario
     */
    public function setPassword($password) {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * Set tipo
     *
     * @param int $tipo
     * @return Usuario
     */
    public function setTipo($tipo) {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return string 
     */
    public function getTipo() {
        return $this->tipo;
    }

    /**
     * Set endereco
     *
     * @param \LQNL\AutenticacaoBundle\Entity\Endereco $endereco
     * @return Usuario
     */
    public function setEndereco(\LQNL\AutenticacaoBundle\Entity\Endereco $endereco = null) {
        $this->endereco = $endereco;

        return $this;
    }

    /**
     * Get endereco
     *
     * @return \LQNL\AutenticacaoBundle\Entity\Endereco 
     */
    public function getEndereco() {
        return $this->endereco;
    }

    public function eraseCredentials() {
        
    }

    public function getRoles() {
//        if($this->tipo == 1){
        return array("ROLE_USER");
//        }
//            return array("ROLE_ADMIN");
    }

    public function getSalt() {
        return strlen($this->nome);
    }

    public function isEqualTo(UserInterface $user) {
        if (!$user instanceof Usuario) {
            return false;
        }

        if ($this->password !== $user->getPassword()) {
            return false;
        }

        if ($this->username !== $user->getUsername()) {
            return false;
        }

        return true;
    }

}
