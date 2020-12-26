<?php

namespace gestion\achatsFondDeRoulementBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class LigneDemandeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('qte', TextType::class , array(
                    'data' => '1',
                    'attr' =>   array (
                        'class' => 'quantite positive'
                    )    
                ))
                ->add('produit', EntityType::class, array(
                    'class' => 'gestionachatsFondDeRoulementBundle:Produit',
                    'choice_label' => 'libelle',
                    'placeholder' => 'Choisissez un produit',
                    'attr' => array(
                        'class' => 'produit',
                    )
                ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'gestion\achatsFondDeRoulementBundle\Entity\LigneDemande'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'gestion_achatsfondderoulementbundle_ligneDemande';
    }


}
