<?php

namespace App\Service;

use App\Entity\Character;

interface CharacterServiceInterface
{
  /**
   * Gets all the characters
   */
  public function getAll();

  /**
   * Creates the character
   */
  public function create();

  /**
   * Modifies the character
   */
  public function modify(Character $character);
}
