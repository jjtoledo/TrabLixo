<?php

namespace LQNL\AutenticacaoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UsuarioType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nome', null, array('attr' => array('class' => 'form-control')))
            ->add('telefone', null, array('attr' => array('class' => 'form-control')))
            ->add('username', "email", array('attr' => array('class' => 'form-control')))
            ->add('password', 'password', array('attr' => array('class' => 'form-control')))
//            ->add('tipo')
//            ->add('endereco')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'LQNL\AutenticacaoBundle\Entity\Usuario'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'lqnl_autenticacaobundle_usuario';
    }
}
