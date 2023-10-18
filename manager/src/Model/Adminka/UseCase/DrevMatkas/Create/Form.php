<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\DrevMatkas\Create;

use App\ReadModel\Adminka\Matkas\KategoriaFetcher;

use App\ReadModel\Adminka\OtecForRas\Linias\LiniaFetcher;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Form extends AbstractType
{
//    private $otecLinias;
//    private $kategorias;
//
//    public function __construct(LiniaFetcher $otecLinias, KategoriaFetcher $kategorias)
//    {
//        $this->otecLinias = $otecLinias;
//        $this->kategorias = $kategorias;
//    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
//        $otecLinia = [];
//        foreach ($this->otecLinias->otecLiniaNomerList($options['rasa_id']) as $item) {
//            $otecLinia[$item['linia']][$item['nomer'].' ( '.$item['title'].' )'] = $item['otnomer_id'];
//        }

//        $builder
//            ->add('kategoria', Type\ChoiceType::class, [
//                'label' => 'Категория ПлемМатки',
//                'choices' => array_flip($this->kategorias->allList()),
//                'expanded' => true,
//                'multiple' => false
//            ])

//            ->add('otecNomer', Type\ChoiceType::class, [
//                'label' => 'Отцовская линия',
//                'choices' => $otecLinia,
//
//            ])

//            ->add('title', Type\TextType::class, array(
//                'label' => ' Внутренняя нумерация',
//                'attr' => [
//                    'placeholder' => 'Внутреняя нумрация или комментарий. Пример: рыжая красотка )))'
//                ]
//            ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array(
            'data_class' => Command::class,
        ));
//        $resolver->setRequired(['rasa_id']);
    }
}