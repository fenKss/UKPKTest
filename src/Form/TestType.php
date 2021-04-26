<?php

namespace App\Form;

use App\Entity\Language;
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
                'choice_label' => function ($choice) {
                    return $choice->getName();
                },
                'required' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Test::class,
            'allow_extra_fields'=>true,
            'tour'=>null
        ]);
    }
}
