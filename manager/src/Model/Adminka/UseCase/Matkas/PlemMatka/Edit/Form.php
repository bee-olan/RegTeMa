<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\Matkas\PlemMatka\Edit;



use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Form extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder

            ->add('title', Type\TextType::class, array(
                'label' => 'В БД она - нумерация  маточки - записана так. Можно изменить!',
                'attr' => [
                    'placeholder' => 'Пример: рыжая красотка )))'
                ]
            ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array(
            'data_class' => Command::class,
        ));
    }
}