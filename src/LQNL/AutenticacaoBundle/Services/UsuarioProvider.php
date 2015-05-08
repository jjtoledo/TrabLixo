<?php

namespace LQNL\AutenticacaoBundle\Services;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use LQNL\AutenticacaoBundle\Entity\Usuario;
use Doctrine\ORM\EntityManager;

/**
 * Description of usuarioProvider
 *
 * @author plinio
 */
class UsuarioProvider implements UserProviderInterface {

    /**
     *
     * @var EntityManager 
     */
    protected $em;

    public function __construct(EntityManager $entityManager) {
        $this->em = $entityManager;
    }

    public function loadUserByUsername($username) {
        $user = $this->em->getRepository('AutenticacaoBundle:Usuario')->findOneBy(array('username' => $username));
        if ($user) {
            return $user;
        }
        throw new UsernameNotFoundException(sprintf('Usuário "%s" não encontrado!', $username));
    }

    public function refreshUser(UserInterface $user) {
        if (!$user instanceof Usuario) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
        }

        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass($class) {
        return $class === 'LQNL\AutenticacaoBundle\Entity\Usuario';
    }

}
