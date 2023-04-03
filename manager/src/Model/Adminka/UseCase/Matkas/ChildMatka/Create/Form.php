<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\Matkas\ChildMatka\Create;

use App\ReadModel\Adminka\Matkas\SparingFetcher;
use App\Model\Adminka\Entity\Matkas\ChildMatka\Type as ChildMatkaType;
use App\ReadModel\Adminka\Uchasties\GroupFetcher;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Form extends AbstractType
{



    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
//            ->add('name', Type\TextType::class)
            ->add('content', Type\TextareaType::class, [
                'label' => 'Описание ДочьМатки  ',
                'required' => false,
                'attr' => ['rows' => 3,
                'placeholder' => ' Подробное описание ДочьМатки'
                ]])

            ->add('kolChild', Type\IntegerType::class, [
                'label' => 'Сколько (кол-во) маточек регистрировать?',
                'required' => false
            ])
            ->add('plan_date', Type\DateType::class, [
                'label' => 'Дата выхода ДочьМатки  ',
                'required' => false, 
                'widget' => 'single_text', 
                'input' => 'datetime_immutable'
                ])
             ->add('type', Type\ChoiceType::class, [
                 'label' => 'Выбрать вид   облета !!!:   ',
                 'choices' => [
                     'тф-бк' => ChildMatkaType::TFBK,
                     'ио' => ChildMatkaType::IO,
                     'ос' => ChildMatkaType::OS,
                     'тф-90' => ChildMatkaType::TF90,
                     'тф-50' => ChildMatkaType::TF50,
             ],
                 'expanded' => true,
                 'multiple' => false,
             ])
            ->add('priority', Type\ChoiceType::class, [
                'label' => 'Приоритеты для заказа на тестирование   ',
                'choices' => [
                'Низкий' => 1,
                'Обычный' => 2,
                'Высокий' => 3,
                'Срочный' => 4
                ],
                'expanded' => true,
                'multiple' => false,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array(
            'data_class' => Command::class,
        ));
    }
}