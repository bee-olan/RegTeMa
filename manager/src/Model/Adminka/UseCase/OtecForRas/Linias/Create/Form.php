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
            'label' => 'Добавить название отцовской линии ',
            'attr' => [
                'placeholder' => 'Введите название линии ....'
            ]
        ))

        ->add('title', Type\TextType::class, array(

            'label' => 'Не обязательный  ком-рий',
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
