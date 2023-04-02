<?php

namespace App\ReadModel\Adminka\Matkas\ChildMatka\Filter;

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
             ], 'required' => false, 'placeholder' => 'Спаринг', 'attr' => ['onchange' => 'this.form.submit()']])
            ->add('status', Type\ChoiceType::class, ['choices' => [
                'новая' => Status::NEW,
                'Заказана' => Status::ZAKAZ ,
                'в работе' => Status::WORKING,
                'вопрос' => Status::HELP,
                'отклонена' => Status::REJECTED,
                'завершено' => Status::DONE,
            ], 
            'required' => false, 
            'placeholder' => 'Статусы', 
            'attr' => ['onchange' => 'this.form.submit()']])
//            ->add('priority', Type\ChoiceType::class, [
//                'choices' => [
//                'Низкий' => 1,
//                'Обычный' => 2,
//                'Высокий' => 3,
//                'Срочный' => 4
//            ],
//            'required' => false,
//            'placeholder' => 'Приоритет',
//            'attr' => ['onchange' => 'this.form.submit()']
//            ])
            ->add('author', Type\ChoiceType::class, [
                'choices' => $uchasties,
                'required' => false,
                'placeholder' => 'Авторы',
                'attr' => ['onchange' => 'this.form.submit()']
            ])
            ->add('executor', Type\ChoiceType::class, [
                'choices' => $uchasties,
                'required' => false, 'placeholder' => 'Исполнители',
                'attr' => ['onchange' => 'this.form.submit()']
            ])
             ->add('roots', Type\ChoiceType::class, ['choices' => [
                 'Только родители' => Status::NEW,
             ], 'required' => false,
                'placeholder' => 'Все уровни',
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
