<?php

declare(strict_types=1);

namespace App\Model\Drevos\UseCase\Rass\Rods\Linis\Wetkas\NomWets\Noms\Create;


use App\ReadModel\Adminka\Sezons\Godas\GodaFetcher;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Form extends AbstractType
{
    private $godas;

    public function __construct(GodaFetcher $godas)
    {
        $this->godas = $godas;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('nameOt', Type\TextType::class, array(
                'label' => 'Название материнки трутня',
                'attr' => [
                    'placeholder' => 'мат. трутня ....'
                ]
            ))

            ->add('nom', Type\TextType::class, array(
            'label' => 'Из паспорта.  Матку купил: Номер без даты',
            'attr' => [
                'placeholder' => 'номер ....'
            ]
        ))
            ->add('god', Type\ChoiceType::class, [
                'label' => 'Год выхода',
                'choices' => array_flip($this->godas->assocGod()),
            ])


        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array(
            'data_class' => Command::class,
        ));
    }
}
