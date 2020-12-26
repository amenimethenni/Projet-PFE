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

class DevisType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('numero')
                ->add('dateDevis',DateType::class, array(
                      'widget' => 'single_text',
                      'html5' => false,
                      'data' => new \DateTime(),
                      'format' => 'dd-MM-yyyy',
                      'attr' => ['class' => 'datepicker']))
                 ->add('fichierDevis', FileType::class, array('data_class' => null))
                ->add('Fournisseur', EntityType::class, array(
                    'class' => 'gestionachatsFondDeRoulementBundle:Fournisseur',
                    'choice_label' => 'libelle',
                    'placeholder' => 'Fournisseur'
                ))
                ->add('lignesDevis', CollectionType::class, [
                        'entry_type' => LigneDevisType::class,
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
            'data_class' => 'gestion\achatsFondDeRoulementBundle\Entity\Devis'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'gestion_achatsfondderoulementbundle_devis';
    }


}
