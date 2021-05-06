<?php

namespace App\Form;

use App\Entity\Language;
use App\Entity\Olympic;
use App\ENum\EOlympicType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OlympicType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label'=>'Название олимпиады'
            ])
            ->add("languages", EntityType::class, [
                "label" => "Языки",
                'multiple' => true,
                'class' => Language::class,
                'choice_label' => function ($choice) {
                    return $choice->getName();
                },
                'required' => true,
            ])
            ->add('type', ChoiceType::class, [
                'label'=>'Тип',
                'choices'=>[
                    'Внутриколледжная'=>EOlympicType::COLLEGE_TYPE()->getValue(),
                    'Городская'=>EOlympicType::CITY_TYPE()->getValue(),
                    'Региональная'=>EOlympicType::REGION_TYPE()->getValue(),
                    'Республиканская'=>EOlympicType::COUNTRY_TYPE()->getValue(),
                    'Международная'=>EOlympicType::WORLD_TYPE()->getValue(),
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Olympic::class,
        ]);
    }
}
