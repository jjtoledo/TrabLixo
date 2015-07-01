<?php

namespace LQNL\ServidorBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RecolhimentoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('data')
            ->add('papel')
            ->add('metal')
            ->add('eletronico')
            ->add('vidro')
            ->add('plastico')
            ->add('outros')
            ->add('total')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'LQNL\ServidorBundle\Entity\Recolhimento'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'lqnl_servidorbundle_recolhimento';
    }
}
