<?php

namespace App\Listener;

use App\Event\CharacterEvent;
use DateTime;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CharacterListener implements EventSubscriberInterface
{
  public static function getSubscribedEvents()
  {
    return array(CharacterEvent::CHARACTER_CREATED => 'characterCreated',);
  }

  public function characterCreated($event)
  {
    $character = $event->getCharacter();
    $character->setIntelligence(250);

    if ($character->getCreation() < new DateTime('2022-03-10') && $character->getCreation() > new DateTime('2022-03-07'))
      $character->setLife(20);
  }
}
