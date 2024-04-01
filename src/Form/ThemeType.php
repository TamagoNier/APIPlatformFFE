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
                    'class' => Atelier::class,
                    'choice_label' => 'libelle', 
                    'multiple' => true, 
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
