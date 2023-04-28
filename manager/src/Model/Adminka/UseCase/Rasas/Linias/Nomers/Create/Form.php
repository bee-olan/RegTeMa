<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\Rasas\Linias\Nomers\Create;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Form extends AbstractType
{

//    private $sparings;
//
//    public function __construct(SparingFetcher $sparings)
//    {
//        $this->sparings = $sparings;
//    }

//            ->add('sparing', Type\ChoiceType::class, ['choices' => array_flip($this->sparings->assoc())])

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('name', Type\TextType::class, array(
                'label' => 'Добавить название номераааа из документов или личных архивных данных',
                'attr' => [
                    'placeholder' => 'Введите название линии ....'
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

