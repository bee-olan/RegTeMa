<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\Matkas\ChildMatka\Type;

use App\Model\Adminka\Entity\Matkas\ChildMatka\Type as ChildMatkaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Form extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type', Type\ChoiceType::class, ['choices' => [
                    'тф-бк' => ChildMatkaType::TFBK,
                    'ио' => ChildMatkaType::IO,
                    'ос' => ChildMatkaType::OS,
                    'тф-90' => ChildMatkaType::TF90,
                    'тф-50' => ChildMatkaType::TF50,
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
        return 'type';
    }
}