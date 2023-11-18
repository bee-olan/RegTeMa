<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\DrevMatkas\DrevMatka\UchasDrev\Add;

use App\ReadModel\Adminka\DrevMatkas\SezonDrevFetcher;
use App\ReadModel\Adminka\Matkas\PlemMatka\DepartmentFetcher;
use App\ReadModel\Adminka\Matkas\RoleFetcher;
use App\ReadModel\Adminka\Uchasties\Uchastie\UchastieFetcher;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Form extends AbstractType
{
    private $uchasties;
    private $sezondrevs;

    public function __construct(UchastieFetcher $uchasties, SezonDrevFetcher $sezondrevs)
    {
        $this->uchasties = $uchasties;
        $this->sezondrevs = $sezondrevs;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $uchasties = [];
        foreach ($this->uchasties->activeGroupedList() as $item) {
            $uchasties[$item['group']][$item['nike'].' ('.$item['persona'].')'] = $item['id'];
        }
//dd($this->sezondrevs->allOfDrevMatka($options['plemmatka']));
        $builder
            ->add('uchastie', Type\ChoiceType::class, [
                'label' => 'Участники',
                'choices' => $uchasties,
            ])
            ->add('sezondrevs', Type\ChoiceType::class, [
                'label' => ' Сезоны',
                'choices' => array_flip($this->sezondrevs->listOfDrevMatka($options['plemmatka'])),
                'expanded' => true,
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array(
            'data_class' => Command::class,
        ));
        $resolver->setRequired(['plemmatka']);

    }
}
