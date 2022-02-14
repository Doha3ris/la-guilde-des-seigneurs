<?php

namespace App\Service\Player;

use App\Entity\Player;

interface PlayerServiceInterface
{
  /**
   * Gets all the players
   */
  public function getAll();

  /**
   * Creates the player
   */
  public function create();

  /**
   * Modifies the player
   */
  public function modify(Player $player);

  /**
   * Deletes the player
   */
  public function delete(Player $player);
}
