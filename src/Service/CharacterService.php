<?php

namespace App\Service;

use DateTime;
use App\Entity\Character;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CharacterRepository;

class CharacterService implements CharacterServiceInterface
{
  public function __construct(private EntityManagerInterface $em, private CharacterRepository $characterRepository)
  {
  }

  /**
   * {inheritdoc}
   */
  public function getAll()
  {
    $charactersFinal = array();
    $characters = $this->characterRepository->findAll();
    foreach ($characters as $character) {
      $charactersFinal[] = $character->toArray();
    }

    return $charactersFinal;
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
      ->setCreation(new DateTime())
      ->setModification(new DateTime());

    $this->em->persist($character);
    $this->em->flush();

    return $character;
  }

  public function modify(Character $character)
  {
    $character
      ->setKind('Seigneur')
      ->setName("Gorthol")
      ->setSurname("Haume de Terreur")
      ->setCaste("Chevalier")
      ->setKnowledge("Diplomatie")
      ->setIntelligence(110)
      ->setLife(13)
      ->setImage('/images/gorthol.jpg')
      ->setModification(new DateTime());

    $this->em->persist($character);
    $this->em->flush();

    return $character;
  }

  public function delete(Character $character)
  {
    $this->em->remove($character);

    $this->em->flush();

    return true;
  }
}
