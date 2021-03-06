<?php

namespace App\Security\Voter;

use App\Entity\Character;
use LogicException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class CharacterVoter extends Voter
{
    public const CHARACTER_DISPLAY = 'characterDisplay';
    public const CHARACTER_CREATE = 'characterCreate';
    public const CHARACTER_INDEX = 'characterIndex';
    public const CHARACTER_MODIFY = 'characterModify';
    public const CHARACTER_DELETE = 'characterDelete';

    private const ATTRIBUTES = array(
        self::CHARACTER_DISPLAY,
        self::CHARACTER_CREATE,
        self::CHARACTER_INDEX,
        self::CHARACTER_MODIFY,
        self::CHARACTER_DELETE
    );

    protected function supports(string $attribute, $subject): bool
    {
        if (null !== $subject) {
            return $subject instanceof Character && in_array($attribute, self::ATTRIBUTES);
        }

        return in_array($attribute, self::ATTRIBUTES);
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        // Defines access rights
        return match ($attribute) {
            self::CHARACTER_DISPLAY, self::CHARACTER_INDEX => $this->canDisplay(),
            self::CHARACTER_CREATE => $this->canCreate(),
            self::CHARACTER_MODIFY => $this->canModify(),
            self::CHARACTER_DELETE => $this->canDelete(),
            default => throw new LogicException('Invalid attribute: ' . $attribute),
        };
    }

    /**
     * Checks if is allowed to display
     */
    private function canDisplay()
    {
        return true;
    }

    /**
     * Checks if is allowed to create
     */
    private function canCreate()
    {
        return true;
    }

    /**
     * Checks if is allowed to modify
     */
    private function canModify()
    {
        return true;
    }

    /**
     * Checks if is allowed to delete
     */
    private function canDelete()
    {
        return true;
    }
}
