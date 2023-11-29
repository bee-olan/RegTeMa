<?php

declare(strict_types=1);

namespace App\Model\Adminka\Entity\Rasas;

use App\Model\Adminka\Entity\Rasas\Linias\Linia;
use App\Model\Adminka\Entity\Rasas\Linias\Id as LiniaId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="adminka_rasas")
 */
class Rasa
{
    /**
     * @var Id
     * @ORM\Column(type="adminka_rasa_id")
     * @ORM\Id
     */
    private $id;
    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $name;

     /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $title;
	
	 /**
     * @var ArrayCollection|Linia[]
     * @ORM\OneToMany(
     *     targetEntity="App\Model\Adminka\Entity\Rasas\Linias\Linia",
     *     mappedBy="rasa", orphanRemoval=true, cascade={"all"}
     * )
     * @ORM\OrderBy({"name" = "ASC"})
     */
    private $linias;

    public function __construct(Id $id, string $name, string $title)
    {
        $this->id = $id;
        $this->name = $name;
        $this->title = $title;
		$this->linias = new ArrayCollection();
    }

    public function edit(string $name, string $title): void
    {
        $this->name = $name;
        $this->title = $title;
    }

    public function setVetkaChildOf(?Linia $vetka): void
    {
        if ($vetka) {
            $current = $vetka;
            do {
                if ($current === $this) {
                    throw new \DomainException('Cyclomatic children.');
                }
            }
            while ($current && $current = $current->getVetka());
        }

        $this->vetka = $vetka;
    }
    public function addLinia(LiniaId $id,
                                string $name,
                                string $nameStar,
                                string $title,
								?string $idVetka,
								int $sortLinia,
                             ?Linia $vetka
                                ): void
    {
        foreach ($this->linias as $linia) {
            if ($linia->isNameStarEqual($nameStar)) {
                throw new \DomainException('Линия уже существует. Попробуйте для
                этой линии добавить свой номер');
            }
        }

        $this->linias->add(new Linia($this,
									$id,
									$name,
									$nameStar,
									$title,
                                    $idVetka,
									$sortLinia,
                                    $vetka
                                    ));
    }

    public function editLinia(LiniaId $id,
                                string $name,
                                string $nameStar,
                                string $title
                                ): void
    {
        foreach ($this->linias as $current) {
            if ($current->getId()->isEqual($id)) {
                $current->edit($name, $nameStar, $title );
                return;
            }
        }
        throw new \DomainException('Linia is not found.');
    }

    public function removeLinia(LiniaId $id): void
    {
        foreach ($this->linias as $linia) {
            if ($linia->getId()->isEqual($id)) {
                $this->linias->removeElement($linia);
                return;
            }
        }
        throw new \DomainException('Linia is not found.');
    }

	 public function getLinias()
    {
        return $this->linias->toArray();
    }


    public function getLinia(LiniaId $id): Linia
    {
        foreach ($this->linias as $linia) {
            if ($linia->getId()->isEqual($id)) {
                return $linia;
            }
        }
        throw new \DomainException('Linia is not found.');
    }
///////////////////////////////////////
    public function getId(): Id
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }
	
	public function getTitle(): string
    {
        return $this->title;
    }
}
