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
    public function create(string $data);

    /**
     * Checks if the entity has been well filled
     */
    public function isEntityFilled(Player $player);

    /**
     * Submits the data to hydrate the
     */
    public function submit(Player $player, $formName, $data);

    /**
     * Modifies the player
     */
    public function modify(string $data, Player $player);

    /**
     * Deletes the player
     */
    public function delete(Player $player);

    /**
     * Serialize the object(s)
     */
    public function serializeJson($data);
}
