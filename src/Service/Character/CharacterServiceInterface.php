<?php

namespace App\Service\Character;

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

  /**
   * Deletes the character
   */
  public function delete(Character $character);

  /**
   * Gets image randomly
   */
  public function getImages(int $number, ?string $kind = null);
}
