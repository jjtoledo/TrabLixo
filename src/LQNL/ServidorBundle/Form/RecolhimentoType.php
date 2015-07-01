<?php

namespace LQNL\ServidorBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RecolhimentoType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('papel', null, array('attr' => array('class' => 'form-control', 'min' => '0', 'max' => '999', 'onkeypress' => 'return SomenteNumero(event)')))
                ->add('metal', null, array('attr' => array('class' => 'form-control', 'min' => '0', 'max' => '999', 'onkeypress' => 'return SomenteNumero(event)')))
                ->add('eletronico', null, array('attr' => array('class' => 'form-control', 'min' => '0', 'max' => '999', 'onkeypress' => 'return SomenteNumero(event)')))
                ->add('vidro', null, array('attr' => array('class' => 'form-control', 'min' => '0', 'max' => '999', 'onkeypress' => 'return SomenteNumero(event)')))
                ->add('plastico', null, array('attr' => array('class' => 'form-control', 'min' => '0', 'max' => '999', 'onkeypress' => 'return SomenteNumero(event)')))
                ->add('outros', null, array('attr' => array('class' => 'form-control', 'min' => '0', 'max' => '999', 'onkeypress' => 'return SomenteNumero(event)')))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'LQNL\ServidorBundle\Entity\Recolhimento'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'lqnl_servidorbundle_recolhimento';
    }

}
