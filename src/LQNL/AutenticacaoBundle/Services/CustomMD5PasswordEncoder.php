<?php

namespace LQNL\AutenticacaoBundle\Services;

use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;

class CustomMd5PasswordEncoder implements PasswordEncoderInterface
{
    public function __construct() {
    }

    public function encodePassword($raw, $salt) {
        return md5($raw);
    }

    public function isPasswordValid($encoded, $raw, $salt) {
        return md5($raw) == $encoded;
    }
}
