<?php

namespace App\Event;

use App\Entity\Player;
use Symfony\Contracts\EventDispatcher\Event;

class PlayerEvent extends Event
{
  public const PLAYER_MODIFIED = 'app.player.modified';


  public function __construct(private Player $player)
  {
  }

  public function getPlayer()
  {
    return $this->player;
  }
}
