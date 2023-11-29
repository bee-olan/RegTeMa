<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\DrevMatkas\ChildDrev\Create;

use App\Model\Adminka\Entity\DrevMatkas\ChildDrevs\Type as ChildDrevType;
use App\ReadModel\Adminka\OtecForRas\Linias\LiniaFetcher;
use App\ReadModel\Adminka\Uchasties\GroupFetcher;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Form extends AbstractType
{
    private $otecLinias;


    public function __construct(LiniaFetcher $otecLinias)
    {
        $this->otecLinias = $otecLinias;

    }


    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $otecLinia = [];

        foreach ($this->otecLinias->otecLiniaNomerList($options['rasa_id']) as $item) {
            $otecLinia[$item['linia']][$item['nomer'].' ( '.$item['title'].' )'] = $item['otnomer_id'];
        }

        $builder

            ->add('content', Type\TextareaType::class, [
                'label' => '1) Описание ДочьМатки  ',
                'required' => false,
                'attr' => ['rows' => 3,
                'placeholder' => ' комментарий '
                ]])

            ->add('kolChild', Type\ChoiceType::class, [
                'label' => '2) Сколько (кол-во) маточек регистрировать?',
//                'required' => false,
                'choices' => [
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                    '4' => 4,
                    '10' => 5
                ],
                'expanded' => true,
                'multiple' => false,
            ])
            ->add('plan_date', Type\DateType::class, [
                'label' => '3) Дата выхода ДочьМатки  ',
                'required' => false, 
                'widget' => 'single_text', 
                'input' => 'datetime_immutable'
                ])
             ->add('type', Type\ChoiceType::class, [
                 'label' => '4) Выбрать вид   облета !!!:   ',
                 'choices' => [
                     'тф-бк' => ChildDrevType::TFBK,
                     'ио' => ChildDrevType::IO,
                     'ос' => ChildDrevType::OS,
                     'тф-90' => ChildDrevType::TF90,
                     'тф-50' => ChildDrevType::TF50,
             ],
                 'expanded' => true,
                 'multiple' => false,
             ])

            ->add('otecNomer', Type\ChoiceType::class, [
                'label' => '5) Отцовская линия . .  ',
                'choices' => $otecLinia,
            ])

            ->add('priority', Type\ChoiceType::class, [
                'label' => '6) Приоритеты для заказа на тестирование   ',
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
        $resolver->setRequired(['rasa_id']);
    }
}