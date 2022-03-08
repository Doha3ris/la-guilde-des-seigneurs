<?php

namespace App\Event;

use App\Entity\Character;
use Symfony\Contracts\EventDispatcher\Event;

class CharacterEvent extends Event
{
  public const CHARACTER_CREATED = 'app.character.created';


  public function __construct(private Character $character)
  {
  }

  public function getCharacter()
  {
    return $this->character;
  }
}
