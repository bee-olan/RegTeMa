<?php

namespace App\ReadModel\User\Filter;

use App\Model\User\Entity\User\Role;
use App\Model\User\Entity\User\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Form extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', Type\TextType::class, ['required' => false, 'attr' => ['placeholder' => 'Ф.И. или Ник',
							'onchange' => 'this.form.submit()',
						]])
            ->add('email', Type\TextType::class, ['required' => false, 'attr' => ['placeholder' => 'Эл.почта',
							'onchange' => 'this.form.submit()',
						]])
            ->add('status', Type\ChoiceType::class, ['choices' => [
                'Ожидает' => User::STATUS_WAIT,
                'Активен' => User::STATUS_ACTIVE,
                'Блокирован' => User::STATUS_BLOCKED,
            ], 'required' => false, 'placeholder' => 'Все статусы',
								'attr' => ['onchange' => 'this.form.submit()']])
            ->add('role', Type\ChoiceType::class, ['choices' => [
                'Пользователи' => Role::USER,
								'Модераторы' => Role::MODERATOR,
                'Админы' => Role::ADMIN,
            ], 'required' => false, 'placeholder' => 'Все роли',
								'attr' => ['onchange' => 'this.form.submit()']]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Filter::class,
            'method' => 'GET',
            'csrf_protection' => false,
        ]);
    }
}
