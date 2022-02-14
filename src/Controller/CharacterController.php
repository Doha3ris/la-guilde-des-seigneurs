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

    #[Route('/character', name: 'character_redirect_index', methods: ["GET", "HEAD"])]
    public function redirectIndex(): Response
    {
        return $this->redirectToRoute('character_index');
    }

    #[Route('/character/index', name: 'character_index', methods: ["GET", "HEAD"])]
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('characterIndex', null);

        $characters = $this->characterService->getAll();

        return new JsonResponse($characters);
    }

    #[Route('/character/display/{identifier}', name: 'character_display', requirements: ["identifier" => "^([a-é0-9]{40})$"], methods: ["GET", "HEAD"])]
    public function display(Character $character): Response
    {
        $this->denyAccessUnlessGranted('characterDisplay', $character);

        // var_dump($character);
        // dump($character);
        // dd($character);

        return new JsonResponse($character->toArray());
    }

    #[Route('/character/create', name: 'character_create', methods: ["POST", "HEAD"])]
    public function create(): Response
    {
        $this->denyAccessUnlessGranted('characterCreate', null);

        return new JsonResponse($this->characterService->create()->toArray());
    }

    //MODIFY
    #[Route('/character/modify/{identifier}', name: 'character_modify', requirements: ["identifier" => "^([a-é0-9]{40})$"], methods: ["PUT", "HEAD"])]
    public function modify(Character $character): Response
    {
        $this->denyAccessUnlessGranted('characterModify', $character);

        $character = $this->characterService->modify($character);

        return new JsonResponse($character->toArray());
    }
}
