<?php

namespace App\Form;

use App\Entity\Inscription;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Atelier;
use App\Entity\Restauration;

class DemandeInscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('restauration', EntityType::class, [
                    'class' => Restauration::class, // Entité Atelier
                    'choice_label' => 'typeRepas', // Remplacez 'nom' par le champ que vous souhaitez afficher dans la liste déroulante
                    'multiple' => true, // Si vous voulez permettre la sélection de plusieurs ateliers
                    'expanded' => true,
                    'required' => true,
            ])
            ->add('ateliers', EntityType::class, [
                    'class' => Atelier::class, // Entité Atelier
                    'choice_label' => 'libelle', // Remplacez 'nom' par le champ que vous souhaitez afficher dans la liste déroulante
                    'multiple' => true, // Si vous voulez permettre la sélection de plusieurs ateliers
                    'expanded' => true,
                    'required' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Inscription::class,
        ]);
    }
}
