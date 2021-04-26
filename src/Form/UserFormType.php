<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\SubmitButton;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('avatarFile', FileType::class, [
                'multiple' => "false",
                'label' => 'Изображение профиля',
                'required' => false,
                'mapped' => false
            ])
            ->add('name', TextType::class, [
                'label' => "Имя",
            ])
            ->add('surname', TextType::class, [
                'label' => "Фамилия",
            ])
            ->add('bornAt', DateType::class, [
                'label' => "Дата Рождения",
                'html5' => true,
                'widget' => 'single_text',
                'required' => true
            ])
            ->add('studyPlace', TextType::class, [
                'label' => "Место учебы",
                'required' => true
            ])
            ->add('class', TextType::class, [
                'label' => "Класс/Курс",
                'required' => true
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'mapped' => false,
                'required' => false,
                'first_options' => [
                    'label' => 'Пароль'
                ],
                'second_options' => [
                    'label' => 'Повторите пароль'
                ],
                'constraints' => [
                    new Length([
                        'min' => 5,
                        'minMessage' => 'Ваш пароль должен содержать минимум {{ limit }} символов',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('class', TextType::class, [
                'label' => "Класс/Группа",
                'required' => true,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Сохранить',
                'attr' => [

                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'allow_extra_fields' => true,
        ]);
    }
}
