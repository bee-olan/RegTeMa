<?php

namespace App\ReadModel\Proekt\Pasekas\ChildMatka\Side\Filter;

use App\Model\Adminka\Entity\Matkas\ChildMatka\Status;
use App\Model\Adminka\Entity\Matkas\ChildMatka\Type as ChildMatkaType;
use App\ReadModel\Adminka\Uchasties\Uchastie\UchastieFetcher;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Form extends AbstractType
{
    private $uchasties;

    public function __construct(UchastieFetcher $uchasties)
    {
        $this->uchasties = $uchasties;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $uchasties = [];
        foreach ($this->uchasties->activeGroupedList() as $item) {
            $uchasties[$item['group']][$item['name']] = $item['id'];
        }

        $builder
            ->add('text', Type\TextType::class, ['required' => false, 'attr' => [
                'placeholder' => 'Поиск...',
                'onchange' => 'this.form.submit()',
            ]])
            ->add('type', Type\ChoiceType::class, ['choices' => [
                'тф-бк' => ChildMatkaType::TFBK,
                'ио' => ChildMatkaType::IO,
                'ос' => ChildMatkaType::OS,
                'тф-90' => ChildMatkaType::TF90,
                'тф-50' => ChildMatkaType::TF50,
                
            ],
                'required' => false,
                'placeholder' => 'Спаринг',
                'attr' => [
                    'onchange' => 'this.form.submit()']
            ])
            ->add('status', Type\ChoiceType::class, ['choices' => [
                'Новая' => Status::NEW,
                'Заказана' => Status::ZAKAZ ,
                'Тестируется' => Status::WORKING,
                'Вопрос' => Status::HELP,
                'ПлемМатка' => Status::REJECTED,
                'Тест завершено' => Status::DONE,
            ], 
            'required' => false,
            'placeholder' => 'Статусы', 
            'attr' => ['onchange' => 'this.form.submit()']
            ])

            ->add('urowni', Type\ChoiceType::class, [
                'choices' => [
                    'Уровни все' => 0,
                    'уровень >= 1' => 1,
                    'уровень >= 2' => 2,
                    'уровень >= 3' => 3,
                    'уровень >= 4' => 4,
                    'уровень >= 5' => 5
                ],
                'required' => false,
                'placeholder' => 'Уровни больше ..',
                'attr' => ['onchange' => 'this.form.submit()']
            ])

//            ->add('priority', Type\ChoiceType::class, ['choices' => [
//                'Низкий' => 1,
//                'Обычный' => 2,
//                'Высокий' => 3,
//                'Срочный' => 4
//            ], 'required' => false, 'placeholder' => 'Приоритеты', 'attr' => ['onchange' => 'this.form.submit()']])
//
            ->add('author', Type\ChoiceType::class, [
                'choices' => $uchasties,
                'required' => false,
                'placeholder' => 'Автор',
                'attr' => ['onchange' => 'this.form.submit()']
            ])
            ->add('executor', Type\ChoiceType::class, [
                'choices' => $uchasties,
                'required' => false,
                'placeholder' => 'Исполнитель',
                'attr' => ['onchange' => 'this.form.submit()']
            ])
             ->add('roots', Type\ChoiceType::class, [
                 'choices' => [
                     'уровень = 0' => 0,
                     'уровень <= 1' => 1,
                     'уровень <= 2' => 2,
                     'уровень <= 3' => 3,
                     'уровень <= 4' => 4,
                     'уровень <= 5' => 5
             ], 'required' => false,
            'placeholder' => 'Уровни меньше ..',
            'attr' => ['onchange' => 'this.form.submit()']
        ])
        ;
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
