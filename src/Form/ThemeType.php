<?php

namespace App\Form;

use App\Entity\Theme;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Atelier;

class ThemeType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options): void {
        $builder
                ->add('libelle', TextType::class, [
                    'required' => true,
                ])
                ->add('ateliers', EntityType::class, [
                    'class' => Atelier::class, // Entité Atelier
                    'choice_label' => 'libelle', // Remplacez 'nom' par le champ que vous souhaitez afficher dans la liste déroulante
                    'multiple' => true, // Si vous voulez permettre la sélection de plusieurs ateliers
                    'expanded' => true,
                    'required' => true,
        ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void {
        $resolver->setDefaults([
            'data_class' => Theme::class,
        ]);
    }
}
