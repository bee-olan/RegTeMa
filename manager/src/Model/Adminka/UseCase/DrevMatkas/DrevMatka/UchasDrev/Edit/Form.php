<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\DrevMatkas\DrevMatka\UchasDrev\Edit;

//use App\ReadModel\Adminka\Matkas\PlemMatka\DepartmentFetcher;
//use App\ReadModel\Adminka\Matkas\RoleFetcher;
use App\ReadModel\Adminka\DrevMatkas\SezonDrevFetcher;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Form extends AbstractType
{
//    private $roles;
    private $sezondrevs;

    public function __construct( SezonDrevFetcher $sezondrevs)
    {
//        $this->roles = $roles;
        $this->sezondrevs = $sezondrevs;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('sezondrevs', Type\ChoiceType::class, [
                'choices' => array_flip($this->sezondrevs->allOfDrevMatka($options['plemmatka'])),
                'expanded' => true,
                'multiple' => true,
            ])
//            ->add('roles', Type\ChoiceType::class, [
//                'choices' => array_flip($this->roles->allList()),
//                'expanded' => true,
//                'multiple' => true,
//            ])
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
