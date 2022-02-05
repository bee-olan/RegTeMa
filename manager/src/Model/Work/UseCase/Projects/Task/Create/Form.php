<?php

declare(strict_types=1);

namespace App\Model\Work\UseCase\Projects\Task\Create;

use App\Model\Work\Entity\Projects\Task\Type as TaskType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Form extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('names', NamesType::class, ['attr' => ['rows' => 3]])
            ->add('content', Type\TextareaType::class, ['required' => false, 'attr' => ['rows' => 10]])
            ->add('parent', Type\IntegerType::class, ['required' => false])
            ->add('plan', Type\DateType::class, ['required' => false, 'widget' => 'single_text', 'input' => 'datetime_immutable'])
            ->add('type', Type\ChoiceType::class, ['choices' => [
                'Нет' => TaskType::NONE,
                'Ошибка' => TaskType::ERROR,
                'Feature' => TaskType::FEATURE,
            ]])
            ->add('priority', Type\ChoiceType::class, ['choices' => [
                'Низкий' => 1,
                'Средний' => 2,
                'Высокий' => 3,
                'Экстренный' => 4
            ]]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array(
            'data_class' => Command::class,
        ));
    }
}
