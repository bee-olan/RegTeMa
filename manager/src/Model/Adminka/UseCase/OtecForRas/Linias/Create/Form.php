<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\OtecForRas\Linias\Create;

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
            'label' => 'Добавить название линии из документов или личных архивных данных',
            'attr' => [
                'placeholder' => 'Введите название линии ....'
            ]
        ))

        ->add('matka', Type\TextType::class, array(
            'label' => 'Добавить название бабушка',
            'attr' => [
                'placeholder' => 'Введите название бабушка ....'
            ]
        ))

        ->add('otec', Type\TextType::class, array(
            'label' => 'Добавить название отцовскую линию',
            'attr' => [
                'placeholder' => 'Введите название  ....'
            ]
        ))

        ->add('title', Type\TextType::class, array(
            'label' => 'От кого материал или просто ком-рий',
            'attr' => [
                'placeholder' => 'Введите текст ....'
            ]
        ))

        ->add('oblet', Type\TextType::class, array(
            'label' => 'Вид спаривания',
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
