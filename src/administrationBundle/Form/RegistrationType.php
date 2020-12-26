<?php

namespace administrationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

class RegistrationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('profil', EntityType::class, array(
                    'class' => 'administrationBundle:Profil',
                    'choice_label' => 'libelle'
                ))
                ->add('unite', EntityType::class, array(
                    'class' => 'gestionachatsFondDeRoulementBundle:Unite',
                    'choice_label' => 'libelle',
                    'placeholder' => 'Choisissez une unité'
                ))
                ->add('crb', EntityType::class, array(
                    'class' => 'gestionachatsFondDeRoulementBundle:Unite',
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('u')
                            ->where('u.parent is not null');
                    },
                    'choice_label' => 'libelle',
                    'placeholder' => 'Choisissez un CRB'
                ))
                ->add('prenom')
                ->add('nom');
    }
    
    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'administrationBundle\Entity\User'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }

    // For Symfony 2.x
    public function getName()
    {
        return $this->getBlockPrefix();
    }


}
