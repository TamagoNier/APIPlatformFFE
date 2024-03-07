<?php

namespace App\Form;

use App\Entity\Nuite;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Hotel;
use App\Entity\CategorieChambre;

class NuiteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('hotel', EntityType::class, [
                    'class' => Hotel::class,
                    'choice_label' => 'nom',
                    'multiple' => true, 
                    'expanded' => true,
                    'required' => true,
            ])
            ->add('categorie' ,EntityType::class, [
                    'class' => CategorieChambre::class, 
                    'choice_label' => 'libelleCategorie', 
                    'multiple' => true, 
                    'expanded' => true,
                    'required' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Nuite::class,
        ]);
    }
}
