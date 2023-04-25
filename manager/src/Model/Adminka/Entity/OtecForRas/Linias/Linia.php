<?php

declare(strict_types=1);

namespace App\Model\Adminka\Entity\OtecForRas\Linias;

use App\Model\Adminka\Entity\OtecForRas\Rasa;
use App\Model\Adminka\Entity\OtecForRas\Linias\Nomers\Nomer;
use App\Model\Adminka\Entity\OtecForRas\Linias\Nomers\Id as NomerId;


use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="adminka_otec_ras_linias")
 */
class Linia
{
    /**
     * @var Rasa
     * @ORM\ManyToOne(targetEntity="App\Model\Adminka\Entity\OtecForRas\Rasa", inversedBy="linias")
     * @ORM\JoinColumn(name="rasa_id", referencedColumnName="id", nullable=false)
     */
    private $rasa;
	
    /**
     * @var Id
     * @ORM\Column(type="adminka_otec_ras_linia_id")
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
    private $matka;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $otec;

     /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $title;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $oblet;
	
	 /**
     * @var ArrayCollection|Nomer[]
     * @ORM\OneToMany(
     *     targetEntity="App\Model\Adminka\Entity\OtecForRas\Linias\Nomers\Nomer",
     *     mappedBy="linia", orphanRemoval=true, cascade={"all"}
     * )
     * @ORM\OrderBy({"name" = "ASC"})
     */
    private $nomers;



    public function __construct(Rasa $rasa, Id $id, 
                                string $name,
                                string $matka,
                                string $otec,
                                string $title,
							    string $oblet
                                )
    {
        $this->rasa = $rasa;
        $this->id = $id;
        $this->name = $name;
        $this->matka = $matka;
        $this->otec = $otec;
        $this->title = $title;
        $this->oblet = $oblet;
		$this->nomers = new ArrayCollection();
    }

	public function edit(string $name, 
                        string $matka,
                         string $otec,
                         string $title,
                         string $oblet
                        ): void
    {
        $this->name = $name;
		$this->matka = $matka;
        $this->otec = $otec;
        $this->title = $title;
        $this->oblet = $oblet;

    }


    public function addNomer(NomerId $id,
                                string $name,
                                string $title
                                ): void
    {
        foreach ($this->nomers as $nomer) {
            if ($nomer->isNameEqual($name)) {
                throw new \DomainException('номер уже существует.');
            }

        }
        $this->nomers->add(new Nomer($this, $id, $name,  $title));
    }

    public function editNomer(NomerId $id, string $name, string $title): void
    {
        foreach ($this->nomers as $current) {
            if ($current->getId()->isEqual($id)) {
                $current->edit($name, $title);
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
	
// равно Ли Имя
    public function isNameEqual(string $name): bool
    {
        return $this->name === $name;
    }

    public function isNameStarEqual(string $matka): bool
    {
        return $this->matka === $matka;
    }


    public function getId(): Id
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getMatka(): string
    {
        return $this->matka;
    }

    public function getTitle(): string
    {
        return $this->title;
    }


    public function getOtec(): string
    {
        return $this->otec;
    }


    public function getOblet(): string
    {
        return $this->oblet;
    }


    public function getNomers()
    {
        return $this->nomers->toArray();
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


    public function getRasa(): Rasa
    {
        return $this->rasa;
    }


}
