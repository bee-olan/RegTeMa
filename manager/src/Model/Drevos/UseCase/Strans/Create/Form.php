<?php

declare(strict_types=1);

namespace App\Model\Drevos\UseCase\Strans\Create;

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
                'label' => 'Название страны',
                'attr' => [
                    'placeholder' => 'Введите ...'
                ]
            ))
            ->add('nomer', Type\IntegerType::class, array(
                'label' => 'Номер',
                'attr' => [
                    'placeholder' => 'Введите ...'
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