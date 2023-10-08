<?php

declare(strict_types=1);

namespace App\Model\Drevos\UseCase\Rass\Rods\Linis\Wetkas\NomWets\MatTruts\Noms\Edit;


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
            ->add('nom', Type\TextType::class, array(
                'label' => 'Из названия материнки: Номер без даты',

            ))
            ->add('god', Type\ChoiceType::class, [
                'label' => 'Из названия материнки: Год выхода',
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
