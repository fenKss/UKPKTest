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
                'label' => 'Стоимость',
                'html5' => true,
                'input' => 'number'
            ])
            ->add('startedAt', DateTimeType::class, [
                'label' => 'Начало Тура',
                'html5' => true,
                'widget' => 'single_text',
                'data' => new \DateTime()
            ])
            ->add('expiredAt', DateTimeType::class, [
                'label' => 'Конец Тура',
                'html5' => true,
                'widget' => 'single_text',
                'data' => new \DateTime()
            ]);
        $olymp = $options['olymp'];
        $olympSettings = [
            "label" => "Олимпиада",
            'class' => Olymp::class,
            'choice_label' => function ($choice, $key, $value) {
                return $choice->getName();
            },
            'required' => true,
        ];
        if ($olymp) {
            $olympSettings['data'] = $olymp;
        }
        $builder->add("olymp", EntityType::class, $olympSettings);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Tour::class,
            'allow_extra_fields' => true,
            "olymp" => null
        ]);
    }
}
