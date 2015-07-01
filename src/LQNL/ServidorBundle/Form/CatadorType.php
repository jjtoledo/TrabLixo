<?php

namespace LQNL\ServidorBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CatadorType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('nome', null, array('attr' => array('class' => 'form-control')))
                ->add('email', null, array('attr' => array('class' => 'form-control')))
                ->add('telefone', "email", array('attr' => array('class' => 'form-control')))
                ->add('nascimento', 'text', array('attr' => array('class' => 'form-control')))
                ->add('nascimento', 'date', array(
                    'years' => range(date('Y') - 70, date('Y') - 14),
                    'attr' => array('class' => 'form-control')))
        //->add('endereco')
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'LQNL\ServidorBundle\Entity\Catador'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'lqnl_servidorbundle_catador';
    }

}
