<?php

namespace gestion\achatsFondDeRoulementBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class FactureType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('numero')
                ->add('dateFacture',TextType::class, array(
                      'data'=> (new \DateTime())->format('Y-m-d'),
                      'attr' => [
                        'class' => 'dateMask'
                      ]
                ))
                ->add('fichierFacture', FileType::class, array('data_class' => null))
                ->add('Fournisseur', EntityType::class, array(
                    'class' => 'gestionachatsFondDeRoulementBundle:Fournisseur',
                    'choice_label' => 'libelle',
                    'placeholder' => 'Fournisseur'
                ))
                ->add('lignesFactures', CollectionType::class, [
                        'entry_type' => LigneFactureType::class,
                        'allow_add' => true,
                        'allow_delete' => true
                ]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'gestion\achatsFondDeRoulementBundle\Entity\Facture'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'gestion_achatsfondderoulementbundle_facture';
    }


}
