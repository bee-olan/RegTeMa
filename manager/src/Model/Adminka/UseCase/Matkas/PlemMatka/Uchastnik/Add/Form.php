<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\Matkas\PlemMatka\Uchastnik\Add;

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
    private $roles;
    private $departments;

    public function __construct(UchastieFetcher $uchasties, RoleFetcher $roles, DepartmentFetcher $departments)
    {
        $this->uchasties = $uchasties;
        $this->roles = $roles;
        $this->departments = $departments;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $uchasties = [];
        foreach ($this->uchasties->activeGroupedList() as $item) {
            $uchasties[$item['group']][$item['nike'].' ('.$item['persona'].')'] = $item['id'];
        }

        $builder
            ->add('uchastie', Type\ChoiceType::class, [
                'label' => 'Участники',
                'choices' => $uchasties,
            ])
            ->add('departments', Type\ChoiceType::class, [
                'label' => ' Сезоны',
                'choices' => array_flip($this->departments->listOfPlemMatka($options['plemmatka'])),
                'expanded' => true,
                'multiple' => true,
            ])
            ->add('roles', Type\ChoiceType::class, [
                'label' => ' Роль участника',
                'choices' => array_flip($this->roles->allList()),
                'expanded' => true,
                'multiple' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array(
            'data_class' => Command::class,
        ));
        $resolver->setRequired(['plemmatka']);

    }
}
