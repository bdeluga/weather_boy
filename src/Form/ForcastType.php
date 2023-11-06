<?php

namespace App\Form;

use App\Entity\Forcast;
use App\Entity\City;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ForcastType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', DateType::class, [
                'widget' => 'single_text',
                'html5' => true,
            ])
            ->add('temperature', NumberType::class, [
                'attr' => [
                    'min' => -10,
                    'max' => 30,
                ],
                'html5' => true,
            ])
            ->add('city', EntityType::class, [
                'class' => 'App\Entity\City',
                'choice_label' => 'name',
            ])
            ->add('condition', null, [
                'attr' => [
                    'placeholder' => 'E.g Windy',
                ],
            ])
            ->add('humidity', null, [
                'attr' => [
                    'placeholder' => '69%',
                ],
            ])
            
       
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Forcast::class,
        ]);
    }
}
