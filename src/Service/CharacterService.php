<?php

namespace App\Service;

use DateTime;
use App\Entity\Character;
use Doctrine\ORM\EntityManagerInterface;

class CharacterService implements CharacterServiceInterface
{
  public function __construct(private EntityManagerInterface $em)
  {
  }

  /**
   * {inheritdoc}
   */
  public function create()
  {
    $character = new Character();
    $character
      ->setIdentifier(hash('sha1', uniqid()))
      ->setKind('Dame')
      ->setName("Eldalote")
      ->setSurname("Fleur elfique")
      ->setCaste("Elfe")
      ->setKnowledge("Arts")
      ->setIntelligence(120)
      ->setLife(12)
      ->setImage('/images/eldalote.jpg')
      ->setCreation(new DateTime());

    $this->em->persist($character);
    $this->em->flush();

    return $character;
  }
}
