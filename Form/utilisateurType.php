<?php

namespace OVE\AuthentificationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class utilisateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('login')
            ->add('id_association');
            //->add('roles')
  
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'OVE\AuthentificationBundle\Entity\utilisateur'
        ));
    }

    public function getName()
    {
        return 'ove_authentificationbundle_utilisateurtype';
    }
}
