<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\OtecForRas\Create;

use App\ReadModel\Adminka\OtecForRas\RasaFetcher;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Form extends AbstractType
{
    private $rasas;

    public function __construct(RasaFetcher $rasas)
    {
        $this->rasas = $rasas;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', Type\ChoiceType::class, [
                'label' => 'Выбрать  название расы  ',
                'choices' => array_flip($this->rasas->assoc()),
                'expanded' => true,
                'multiple' => false
            ])

//        ->add('name', Type\TextType::class, array(
//            'label' => 'Сокращенное название расы',
//            'attr' => [
//                'placeholder' => 'Введите название'
//            ]
//        ))
//        ->add('title', Type\TextType::class, array(
//            'label' => 'Полное название расы',
//            'attr' => [
//                'placeholder' => 'Введите текст'
//            ]
//        ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array(
            'data_class' => Command::class,
        ));
    }
}
