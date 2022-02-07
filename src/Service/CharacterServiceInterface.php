<?php

namespace App\Service;

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
}
