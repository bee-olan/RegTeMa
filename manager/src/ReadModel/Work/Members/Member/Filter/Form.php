<?php

declare(strict_types=1);

namespace App\ReadModel\Work\Members\Member\Filter;

use App\Model\Work\Entity\Members\Member\Status;
use App\ReadModel\Work\Members\GroupFetcher;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Form extends AbstractType
{
    private $groups;

    public function __construct(GroupFetcher $groups)
    {
        $this->groups = $groups;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', Type\TextType::class, ['required' => false, 'attr' => [
                'placeholder' => 'Ф.И. или Ник',
                'onchange' => 'this.form.submit()',
            ]])
            ->add('email', Type\TextType::class, ['required' => false, 'attr' => [
                'placeholder' => 'Эл-почта',
                'onchange' => 'this.form.submit()',
            ]])
            ->add('group', Type\ChoiceType::class, [
                'choices' => array_flip($this->groups->assoc()),
                'required' => false,
                'placeholder' => 'Все группы',
                'attr' => ['onchange' => 'this.form.submit()']
            ])
            ->add('status', Type\ChoiceType::class, ['choices' => [
                'Активен' => Status::ACTIVE,
                'Архивирован' => Status::ARCHIVED,
            ], 'required' => false, 'placeholder' => 'Все статусы', 'attr' => ['onchange' => 'this.form.submit()']]);
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
