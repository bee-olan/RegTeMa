<?php

declare(strict_types=1);

namespace App\Model\Drevos\UseCase\Rass\Rods\Linis\Wetkas\Create;

use App\ReadModel\Sezons\Godas\GodaFetcher;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Form extends AbstractType
{
//    private $godas;
//
//    public function __construct(GodaFetcher $godas)
//    {
//        $this->godas = $godas;
//    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('nameW', Type\TextType::class, array(
                'label' => 'Ветка: из названия материнки до !!! номера матки',
                'attr' => [
                    'placeholder' => 'ветка ....'
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
