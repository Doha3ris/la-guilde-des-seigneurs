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
    public function create(string $data);

    /**
     * Checks if the entity has been well filled
     */
    public function isEntityFilled(Character $character);

    /**
     * Submits the data to hydrate the
     */
    public function submit(Character $character, $formName, $data);

    /**
     * Modifies the character
     */
    public function modify(string $data, Character $character);

    /**
     * Deletes the character
     */
    public function delete(Character $character);

    /**
     * Gets image randomly
     */
    public function getImages(int $number, ?string $kind = null);

    /**
     * Serialize the object(s)
     */
    public function serializeJson($data);

    /**
     *  Creates the character from html form
     */
    public function createFromHtml(Character $character);

    /**
     *  Modifies the character from html form
     */
    public function modifyFromHtml(Character $character);
}
