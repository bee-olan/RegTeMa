<?php

declare(strict_types=1);

namespace App\ReadModel\Proekt\Pasekas\Uchasties\Side\Filter;

use App\Model\Adminka\Entity\Uchasties\Uchastie\Status;
//use App\Model\Adminka\Entity\Uchasties\Uchastie\UchKak;
use App\ReadModel\Adminka\Uchasties\GroupFetcher;
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
                'placeholder' => 'Здесь напишите Ник',
                'onchange' => 'this.form.submit()',
            ]])
//             ->add('email', Type\TextType::class, ['required' => false, 'attr' => [
//                 'placeholder' => 'Email',
//                 'onchange' => 'this.form.submit()',
//             ]])
            ->add('group', Type\ChoiceType::class, [
                'choices' => array_flip($this->groups->assoc()),
                'expanded' => true,
                'multiple' => false,
                'required' => false,
                'placeholder' => 'Группы...',
                'attr' => ['onchange' => 'this.form.submit()']
            ])
            ->add('status', Type\ChoiceType::class, [
                'choices' => [
                'Активный' => Status::ACTIVE,
                'Архив' => Status::ARCHIVED,
                ],
                'expanded' => true,
                'multiple' => false,
                'required' => false, 
                'placeholder' => 'Статус', 
                'attr' => ['onchange' => 'this.form.submit()']]);
//           ->add('uchkak', Type\ChoiceType::class,
//           ['choices' => [
//               'Матковод' => UchKak::MATKO,
//               'Пчеловод' => UchKak::PCHEL,
//               'ПчелоМатковод' => UchKak::PCHMAT,
//               'Наблюдатель' => UchKak::NABLUD,
//           ],
//           'expanded' => true,
//           'multiple' => false,
//           'required' => false,
//           'placeholder' => 'Участие как!',
//           'attr' => ['onchange' => 'this.form.submit()']]
//);
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
