<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\Matkas\Role\Edit;

use App\Model\Adminka\Entity\Matkas\Role\Permission;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Form extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', Type\TextType::class, [
                'label' => 'Название Роли',
            ])
            ->add('permissions', Type\ChoiceType::class, [
                'label' => 'Разрешения для роли',
                'choices' => array_combine(Permission::names(), Permission::names()),
                'required' => false,
                'expanded' => true,
                'multiple' => true,
                'translation_domain' => 'paseka_permissions',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array(
            'data_class' => Command::class,
        ));
    }
}

