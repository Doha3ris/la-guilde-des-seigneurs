<?php

namespace App\Controller;

use App\Entity\Character;
use App\Service\CharacterServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CharacterController extends AbstractController
{
    public function __construct(private CharacterServiceInterface $characterService)
    {
    }

    #[Route('/character', name: 'character', methods: ["GET", "HEAD"])]
    public function index(): Response
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/CharacterController.php',
        ]);
    }

    #[Route('/character/display/{identifier}', name: 'character_display', requirements: ["identifier" => "^([a-é0-9]{40})$"], methods: ["GET", "HEAD"])]
    public function display(Character $character): Response
    {
        // var_dump($character);
        // dump($character);
        // dd($character);

        return new JsonResponse($character->toArray());
    }

    #[Route('/character/create', name: 'character_create', methods: ["POST", "HEAD"])]
    public function create(): Response
    {
        return new JsonResponse($this->characterService->create()->toArray());
    }
}
