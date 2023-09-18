<?php

declare(strict_types=1);

namespace App\Model\Drevos\UseCase\Rass\Rods\Create;


use App\ReadModel\Drevos\StranFetcher;
use App\ReadModel\Sezons\Godas\GodaFetcher;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Form extends AbstractType
{

    private $stranas;

    public function __construct( StranFetcher $stranas)
    {

        $this->stranas = $stranas;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder

        ->add('strana', Type\ChoiceType::class, [
            'label' => 'Страны ',
            'choices' => array_flip($this->stranas->assoc()),

        ])

         ->add('nameMatkov', Type\TextType::class, array(
            'label' => 'ФИО матковода',
            'attr' => [
                'placeholder' => 'ФИО ..'
            ]
        ))
        ->add('kodMatkov', Type\TextType::class, array(
            'label' => 'Персональный  номер матковода',
            'attr' => [
                'placeholder' => 'Код ...'
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
