<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\DrevMatkas\ChildDrev\Status;

use App\Model\Adminka\Entity\DrevMatkas\ChildDrevs\Status;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Form extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('status', Type\ChoiceType::class, ['choices' => [
                'Новая' => Status::NEW,
                'Заказана' => Status::ZAKAZ ,
                'В работе' => Status::WORKING,
                'Вопрос' => Status::HELP,
                'ПлемМатка' => Status::REJECTED,
                'Тест завершено' => Status::DONE,
            ], 'attr' => ['onchange' => 'this.form.submit()']]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array(
            'data_class' => Command::class,
        ));
    }

    public function getBlockPrefix(): string
    {
        return 'status';
    }
}
