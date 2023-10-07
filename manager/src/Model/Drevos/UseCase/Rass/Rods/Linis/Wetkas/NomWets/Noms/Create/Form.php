<?php

declare(strict_types=1);

namespace App\Model\Drevos\UseCase\Rass\Rods\Linis\Wetkas\NomWets\Noms\Create;

use App\ReadModel\Adminka\Uchasties\Uchastie\UchastieFetcher;
use App\ReadModel\Adminka\Sezons\Godas\GodaFetcher;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Form extends AbstractType
{

    private $uchasties;

    private $godas;

    public function __construct(GodaFetcher $godas, UchastieFetcher $uchasties)
    {
        $this->godas = $godas;
        $this->uchasties = $uchasties;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

//        $uchasties = [];
//        foreach ($this->uchasties->activeGroupedList() as $item) {
//            $uchasties[$item['group']][$item['nike'].' ('.$item['persona'].')'] = $item['id'];
//        }

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

            ->add('zakazal', Type\ChoiceType::class, [
                'label' => 'Заказал',
                'choices' => array_flip($this->uchasties->assoc()),
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
