<?php

// declare(strict_types=1);

// namespace App\Model\Matkis\Entity\Rasas\Rasa\Linia;

// use App\Model\Matkis\Entity\Rasas\Rasa\Rasa;
// use Doctrine\ORM\Mapping as ORM;

// /**
//  * @ORM\Entity
//  * @ORM\Table(name="matkis_rasas_rasa_linias")
//  */
// class Linia
// {
//     /**
//      * @var Rasa
//      * @ORM\ManyToOne(targetEntity="App\Model\Matkis\Entity\Rasas\Rasa\Rasa", inversedBy="linias")
//      * @ORM\JoinColumn(name="rasa_id", referencedColumnName="id", nullable=false)
//      */
//     private $rasa;

//     /**
//      * @var Id
//      * @ORM\Column(type="matkis_rasas_rasa_linia_id")
//      * @ORM\Id
//      */
//     private $id;

//     /**
//      * @var string
//      * @ORM\Column(type="string")
//      */
//     private $name;

//     public function __construct(Rasa $rasa, Id $id, string $name)
//     {
//         $this->rasa = $rasa;
//         $this->id = $id;
//         $this->name = $name;
//     }

//     public function isNameEqual(string $name): bool
//     {
//         return $this->name === $name;
//     }

//     public function edit(string $name): void
// 	{
// 		$this->name = $name;
// //        $this->sort = $sort;
// 	}

//     public function getId(): Id
//     {
//         return $this->id;
//     }

//     public function getName(): string
//     {
//         return $this->name;
//     }
// }
