<?php

namespace App\Form;

use App\Entity\Olymp;
use App\Entity\Tour;
use Doctrine\DBAL\Types\FloatType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TourType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('price', NumberType::class, [
                'label'=>'Цена'
            ])
            ->add('startedAt', DateTimeType::class, [
                'label'=>'Начало Тура',
                'html5'=>true,
                'widget'=>'single_text'
            ])
            ->add('expiredAt', DateTimeType::class, [
                'label'=>'Конец Тура',
                'html5'=>true,
                'widget'=>'single_text'
            ])
            ->add("olymp", EntityType::class, [
                "label" => "Олимпиада",
                'class' => Olymp::class,
                'choice_label' => function ($choice, $key, $value) {
                    return $choice->getName();
                },
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Tour::class,
        ]);
    }
}
