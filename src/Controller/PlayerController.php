<?php

namespace App\Controller;

use App\Entity\Player;
use App\Service\Player\PlayerServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class PlayerController extends AbstractController
{
    public function __construct(private PlayerServiceInterface $playerService)
    {
    }

    #[Route('/player', name: 'player_redirect_index', methods: ["GET", "HEAD"])]
    public function redirectIndex(): Response
    {
        return $this->redirectToRoute('player_index');
    }

    #[Route('/player/index', name: 'player_index', methods: ["GET", "HEAD"])]
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('playerIndex', null);

        $players = $this->playerService->getAll();

        return new JsonResponse($players);
    }

    #[Route('/player/display/{identifier}', name: 'player_display', requirements: ["identifier" => "^([a-é0-9]{40})$"], methods: ["GET", "HEAD"])]
    public function display(Player $player): Response
    {
        $this->denyAccessUnlessGranted('playerDisplay', $player);

        return new JsonResponse($player->toArray());
    }

    #[Route('/player/create', name: 'player_create', methods: ["POST", "HEAD"])]
    public function create(): Response
    {
        $this->denyAccessUnlessGranted('playerCreate', null);

        return new JsonResponse($this->playerService->create()->toArray());
    }

    //MODIFY
    #[Route('/player/modify/{identifier}', name: 'player_modify', requirements: ["identifier" => "^([a-é0-9]{40})$"], methods: ["PUT", "HEAD"])]
    public function modify(Player $player): Response
    {
        $this->denyAccessUnlessGranted('playerModify', $player);

        $player = $this->playerService->modify($player);

        return new JsonResponse($player->toArray());
    }

    //DELETE
    #[Route('/player/delete/{identifier}', name: 'player_delete', requirements: ["identifier" => "^([a-é0-9]{40})$"], methods: ["DELETE", "HEAD"])]
    public function delete(Player $player): Response
    {
        $this->denyAccessUnlessGranted('playerDelete', $player);

        $response = $this->playerService->delete($player);

        return new JsonResponse(array('delete' => $response));
    }
}
