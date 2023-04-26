<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\OtecForRas\Linias\Nomers\Create;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Form extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('name', Type\TextType::class, array(
                'label' => 'Добавить  номер',
                'attr' => [
                    'placeholder' => 'Введите название номера ....'
                ]
            ))
            ->add('matkaLinia', Type\TextType::class, array(
                'label' => 'Добавить  линию отцовской матки',
                'attr' => [
                    'placeholder' => 'Введите линию матки ....'
                ]
            ))
            ->add('matkaNomer', Type\TextType::class, array(
                'label' => 'Добавить номер отцовской матки',
                'attr' => [
                    'placeholder' => 'Введите номер матки ....'
                ]
            ))

            ->add('otecLinia', Type\TextType::class, array(
                'label' => 'Добавить название отцовской линию',
                'attr' => [
                    'placeholder' => 'Введите название  ....'
                ]
            ))

            ->add('otecNomer', Type\TextType::class, array(
                'label' => 'Добавить номер отцовской линию',
                'attr' => [
                    'placeholder' => 'Введите номер  ....'
                ]
            ))

            ->add('oblet', Type\TextType::class, array(
                'label' => 'Вид спаривания',
                'attr' => [
                    'placeholder' => 'Введите текст ....'
                ]
            ))

            ->add('title', Type\TextType::class, array(
                'label' => 'От кого материал или просто ком-рий',
                'attr' => [
                    'placeholder' => 'Введите текст ....'
                ]
            ))



        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array(
            'data_class' => Command::class,
        ));
    }
}

