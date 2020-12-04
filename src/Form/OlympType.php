<?php

namespace App\Form;

use App\Entity\Olymp;
use App\ENum\EOlympType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OlympType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label'=>'Название олимпиады'
            ])
            ->add('type', ChoiceType::class, [
                'label'=>'Тип',
                'choices'=>[
                    'Внутриколледжная'=>EOlympType::COLLEGE_TYPE()->getValue(),
                    'Городская'=>EOlympType::CITY_TYPE()->getValue(),
                    'Областная'=>EOlympType::REGION_TYPE()->getValue(),
                    'Казахстаская'=>EOlympType::COUNTRY_TYPE()->getValue(),
                    'Международная'=>EOlympType::WORLD_TYPE()->getValue(),
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Olymp::class,
        ]);
    }
}
