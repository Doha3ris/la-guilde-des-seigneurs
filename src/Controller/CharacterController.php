<?php

namespace App\Controller;

use App\Entity\Character;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CharacterController extends AbstractController
{
    #[Route('/character/display', name: 'character_display')]
    public function display(): Response
    {
        $character = new Character();

//        var_dump($character);
//        dump($character);
//        dd($character);

        return new JsonResponse($character->toArray());

    }
}
