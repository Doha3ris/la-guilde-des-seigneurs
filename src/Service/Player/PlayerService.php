<?php

namespace App\Service\Player;

use DateTime;
use App\Entity\Player;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PlayerRepository;

class PlayerService implements PlayerServiceInterface
{
  public function __construct(private EntityManagerInterface $em, private PlayerRepository $playerRepository)
  {
  }

  /**
   * {inheritdoc}
   */
  public function getAll()
  {
    $playersFinal = array();
    $players = $this->playerRepository->findAll();
    foreach ($players as $player) {
      $playersFinal[] = $player->toArray();
    }

    return $playersFinal;
  }

  /**
   * {inheritdoc}
   */
  public function create()
  {
    $player = new Player();
    $player
      ->setIdentifier(hash('sha1', uniqid()))
      ->setFirstname("Val")
      ->setLastname("Fol")
      ->setEmail("valfol@mirian.org")
      ->setMirian(500000)
      ->setCreation(new DateTime())
      ->setModification(new DateTime());

    $this->em->persist($player);
    $this->em->flush();

    return $player;
  }

  public function modify(Player $player)
  {
    $player
      ->setFirstname("Oofed")
      ->setLastname("Sheesh")
      ->setEmail("suuu@suuu.suuu")
      ->setMirian(544444)
      ->setModification(new DateTime());

    $this->em->persist($player);
    $this->em->flush();

    return $player;
  }

  public function delete(Player $player)
  {
    $this->em->remove($player);

    $this->em->flush();

    return true;
  }
}
