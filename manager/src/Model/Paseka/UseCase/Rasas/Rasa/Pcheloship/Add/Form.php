<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Rasas\Rasa\Pcheloship\Add;

use App\ReadModel\Paseka\Pchelowods\Pchelowod\PchelowodFetcher;
use App\ReadModel\Paseka\Rasas\Rasa\LiniaFetcher;
use App\ReadModel\Paseka\Rasas\KategorFetcher;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Form extends AbstractType
{
    private $pchelowods;
    private $kategors;
    private $linias;

    public function __construct(PchelowodFetcher $pchelowods, KategorFetcher $kategors, LiniaFetcher $linias)
    {
        $this->pchelowods = $pchelowods;
        $this->kategors = $kategors;
        $this->linias = $linias;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $pchelowods = [];
        foreach ($this->pchelowods->activeGroupedList() as $item) {
            $pchelowods[$item['group']][$item['name']] = $item['id'];
        }

        $builder
            ->add('pchelowod', Type\ChoiceType::class, [
                'choices' => $pchelowods,
            ])
            ->add('linias', Type\ChoiceType::class, [
                'choices' => array_flip($this->linias->listOfRasa($options['rasa'])),
                'expanded' => true,
                'multiple' => true,
            ])
            ->add('kategors', Type\ChoiceType::class, [
                'choices' => array_flip($this->kategors->allList()),
                'expanded' => true,
                'multiple' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array(
            'data_class' => Command::class,
        ));
        $resolver->setRequired(['rasa']);
    }
}
