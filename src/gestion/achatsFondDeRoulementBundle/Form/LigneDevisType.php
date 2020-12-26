<?php

namespace gestion\achatsFondDeRoulementBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class LigneDevisType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('qte', TextType::class)
                ->add('prixHt', TextType::class)
                ->add('remise', TextType::class)
                ->add('produit', EntityType::class, array(
                    'class' => 'gestionachatsFondDeRoulementBundle:Produit',
                    'choice_label' => 'libelle',
                    'placeholder' => 'Choisissez un produit',
                    'attr' => array(
                        'disabled' => true
                    )
                ))
                ->add('tauxTva', EntityType::class, array(
                    'class' => 'gestionachatsFondDeRoulementBundle:TauxTva',
                    'choice_label' => 'taux',
                    'placeholder' => 'Choisissez un taux'
                ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'gestion\achatsFondDeRoulementBundle\Entity\LigneDevis'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'gestion_achatsfondderoulementbundle_ligneDevis';
    }


}
