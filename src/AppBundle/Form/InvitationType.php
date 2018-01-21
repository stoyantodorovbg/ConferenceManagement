<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InvitationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'speaker' => 'speaker',
                    'audience' => 'audience'
                ],
                'placeholder' => 'choose type of invitation'
            ])
            ->add('name')
            ->add('text')
            ->add('users', EntityType::class, [
                'class' => 'AppBundle:User',
                'choice_label' => 'username',
                'placeholder' => 'choose users',
                'multiple' => true,
                'expanded' => true,
                'label' => ' '
            ]);;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Invitation'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_invitation';
    }


}
