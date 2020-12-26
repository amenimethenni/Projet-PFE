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
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class AchatRechercheType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('dateDe',DateType::class, array(
                      'widget' => 'single_text',
                      'html5' => false,
                      'data' => new \DateTime('first day of this month'),
                      'format' => 'yyyy-MM-dd',
                      'placeholder' => "Date du",
                      'attr' => ['class' => 'datepicker']))
                ->add('dateA',DateType::class, array(
                      'widget' => 'single_text',
                      'html5' => false,
                      'data' => new \DateTime(),
                      'format' => 'yyyy-MM-dd',
                      'placeholder' => "Jusqu'au",
                      'attr' => ['class' => 'datepicker']))
                // ->add('fournisseur', EntityType::class, array(
                //     'class' => 'gestionachatsFondDeRoulementBundle:Fournisseur',
                //     'choice_label' => function ($fournisseur) {
                //         return $fournisseur->getLibelle();
                //     },
                //     'placeholder' => 'Choisissez un fournisseur'
                // ))
                ->add('factured', CheckboxType::class, array(
                    'label'    => 'Facturés',
                    'required' => false,
                    'data' => true
                ))
                ->add('notFactured', CheckboxType::class, array(
                    'label'    => 'Non facturés',
                    'required' => false,
                    'data' => true
                ))
                ->add('renouvele', CheckboxType::class, array(
                    'label'    => 'Achetés',
                    'required' => false,
                    'data' => true
                ))
                ->add('nonRenouvle', CheckboxType::class, array(
                    'label'    => 'Non achetés',
                    'required' => false,
                    'data' => true
                ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array());
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'gestionachatsFondDeRoulement_achat';
    }


}
