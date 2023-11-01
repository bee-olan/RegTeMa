<?php

declare(strict_types=1);

namespace App\Model\Drevos\UseCase\Rass\Rods\Edit;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Form extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nameMatkov', Type\TextType::class, array(
                'label' => 'ФИО матковода')
            )
            ->add('kodMatkov', Type\TextType::class, array(
                'label' => 'Персональный  номер матковода')
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array(
            'data_class' => Command::class,
        ));
    }
}
