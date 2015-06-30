<?php

namespace LQNL\ClienteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SolicitacaoType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
//            ->add('data')
//            ->add('usuario')
//            ->add('status')
//            ->add('catador')
                ->add('papel', null, array('attr' => array('class' => 'form-control', 'min' => '0', 'max' => '999', 'onkeypress' => 'return SomenteNumero(event)')))
                ->add('metal', null, array('attr' => array('class' => 'form-control', 'min' => '0', 'max' => '999', 'onkeypress' => 'return SomenteNumero(event)')))
                ->add('eletronico', null, array('attr' => array('class' => 'form-control', 'min' => '0', 'max' => '999', 'onkeypress' => 'return SomenteNumero(event)')))
                ->add('vidro', null, array('attr' => array('class' => 'form-control', 'min' => '0', 'max' => '999', 'onkeypress' => 'return SomenteNumero(event)')))
                ->add('plastico', null, array('attr' => array('class' => 'form-control', 'min' => '0', 'max' => '999', 'onkeypress' => 'return SomenteNumero(event)')))
                ->add('outros', null, array('attr' => array('class' => 'form-control', 'min' => '0', 'max' => '999', 'onkeypress' => 'return SomenteNumero(event)')))
//            ->add('disponibilidade1', 'text', array('attr' => array('class' => 'form-control datepicker', 'date-provide' => 'datepicker')))
//            ->add('disponibilidade2', 'text', array('attr' => array('class' => 'form-control datepicker', 'date-provide' => 'datepicker')))
//            ->add('disponibilidade3', 'text', array('attr' => array('class' => 'form-control datepicker', 'date-provide' => 'datepicker')))
                ->add('observacoes', null, array('attr' => array('class' => 'form-control', 'rows' => '7')))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'LQNL\ClienteBundle\Entity\Solicitacao'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'lqnl_clientebundle_solicitacao';
    }

}
