<?php

declare(strict_types=1);

namespace App\Model\Paseka\Entity\Rasas\Rasa\Linia;

use App\Model\Paseka\Entity\Rasas\Rasa\Rasa;

use App\Model\Paseka\Entity\Rasas\Rasa\Linia\Nomer\Nomer;
use App\Model\Paseka\Entity\Rasas\Rasa\Linia\Nomer\Id as NomerId;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="paseka_rasas_rasa_linias")
 */
class Linia
{
    /**
     * @var Rasa
     * @ORM\ManyToOne(targetEntity="App\Model\Paseka\Entity\Rasas\Rasa\Rasa", inversedBy="linias")
     * @ORM\JoinColumn(name="rasa_id", referencedColumnName="id", nullable=false)
     */
    private $rasa;

    /**
     * @var Id
     * @ORM\Column(type="paseka_rasas_rasa_linia_id")
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
    private $nameStar;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $sortLinia;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $title;

     /**
     * @var ArrayCollection|Nomer[]
     * @ORM\OneToMany(
     *     targetEntity="App\Model\Paseka\Entity\Rasas\Rasa\Linia\Nomer\Nomer",
     *     mappedBy="linia", orphanRemoval=true, cascade={"all"}
     * )
     * @ORM\OrderBy({"name" = "ASC"})
     */
    private $nomers;

    public function __construct(Rasa $rasa, 
                                Id $id, 
                                string $name,
                                string $nameStar,
                                string $title,
								int $sortLinia
                                )
    {
        $this->rasa = $rasa;
        $this->id = $id;
        $this->name = $name;
        $this->nameStar = $nameStar;
        $this->title = $title;
		$this->sortLinia = $sortLinia;
        $this->nomers = new ArrayCollection();
    }
    //////////////////// Nomer
    public function addNomer(NomerId $id,
                                ///Sparing $sparing, 
                                string $name, 
                                string $nameStar, 
                                string $title,
                                int $sortNomer   
                                ): void
    {
        foreach ($this->nomers as $nomer) {
            if ($nomer->isNameEqual($name)) {
                throw new \DomainException('номер уже существует.');
            }
            if ($nomer->isNameStarEqual($nameStar)) {
                throw new \DomainException('Такая запись уже существует.');
            }
        }
        $this->nomers->add(new Nomer($this, $id, 
                                    //$sparing, 
                                    $name, 
                                    $nameStar, 
                                    $title, 
                                    $sortNomer));
    }

    public function editNomer(NomerId $id, string $name, string $nameStar): void
    {
        foreach ($this->nomers as $current) {
            if ($current->getId()->isEqual($id)) {
                $current->edit($name, $nameStar);
                return;
            }
        }
        throw new \DomainException('nomer is not found.');
    }

    public function removeNomer(NomerId $id): void
    {
        foreach ($this->nomers as $nomer) {
            if ($nomer->getId()->isEqual($id)) {
                $this->nomers->removeElement($nomer);
                return;
            }
        }
        throw new \DomainException('Linia is not found.');
    }

    //////////////////////// end Nomer

    public function isNameEqual(string $name): bool
    {
        return $this->name === $name;
    }

    public function isNameStarEqual(string $nameStar): bool
    {
        return $this->nameStar === $nameStar;
    }

    public function edit(string $name, 
                        string $nameStar,
                        string $title): void
    {
        $this->name = $name;
        $this->nameStar = $nameStar;
        $this->title = $title;
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getNameStar(): string
    {
        return $this->nameStar;
    }
	
	public function getSortLinia(): int
    {
        return $this->sortLinia;
    }

    public function getNomers()
    {
        return $this->nomers->toArray();
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getNomer(NomerId $id): Nomer
    {
        foreach ($this->nomers as $nomer) {
            if ($nomer->getId()->isEqual($id)) {
                return $nomer;
            }
        }
        throw new \DomainException('Nomer is not found.');
    }
	
}
