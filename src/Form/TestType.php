<?php

namespace App\Form;

use App\Entity\Language;
use App\Entity\Olymp;
use App\Entity\Test;
use App\Entity\Tour;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("language", EntityType::class, [
                "label" => "Язык",
                'class' => Language::class,
                'choice_label' => function ($choice, $key, $value) {
                    return $choice->getName();
                },
                'required' => false,
            ])
            ->add("tour", EntityType::class, [
                "label" => "Тур",
                'class' => Tour::class,
                'choice_label' => function ($choice, $key, $value) {
                /** @var Tour $choice */
                    return $choice->getOlymp()->getTours()->indexOf($choice)+1;
                },
                'group_by' => function($choice, $key, $value) {

                   return $choice->getOlymp()->getName();
                },
                'required' => false,
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Test::class,
        ]);
    }
}
