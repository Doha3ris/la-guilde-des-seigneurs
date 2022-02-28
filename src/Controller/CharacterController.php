<?php

namespace App\Controller;

use App\Entity\Character;
use App\Service\Character\CharacterServiceInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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

        return JsonResponse::fromJsonString($this->characterService->serializeJson($characters));
    }

    #[Route('/character/display/{identifier}', name: 'character_display', requirements: ["identifier" => "^([a-é0-9]{40})$"], methods: ["GET", "HEAD"])]
    #[Entity("character", "repository.findOneByIdentifier(identifier)")]
    public function display(Character $character): Response
    {
        $this->denyAccessUnlessGranted('characterDisplay', $character);

        // var_dump($character);
        // dump($character);
        // dd($character);

        return JsonResponse::fromJsonString($this->characterService->serializeJson($character));
    }

    #[Route('/character/create', name: 'character_create', methods: ["POST", "HEAD"])]
    public function create(Request $request): Response
    {
        $this->denyAccessUnlessGranted('characterCreate', null);

        $character = $this->characterService->create($request->getContent());

        return JsonResponse::fromJsonString($this->characterService->serializeJson($character));
    }

    //MODIFY
    #[Route('/character/modify/{identifier}', name: 'character_modify', requirements: ["identifier" => "^([a-z0-9]{40})$"], methods: ["PUT", "HEAD"])]
    public function modify(Request $request, Character $character): Response
    {
        $this->denyAccessUnlessGranted('characterModify', $character);

        $character = $this->characterService->modify($request->getContent(), $character);

        return JsonResponse::fromJsonString($this->characterService->serializeJson($character));
    }

    //DELETE
    #[Route('/character/delete/{identifier}', name: 'character_delete', requirements: ["identifier" => "^([a-z0-9]{40})$"], methods: ["DELETE", "HEAD"])]
    public function delete(Character $character): Response
    {
        $this->denyAccessUnlessGranted('characterDelete', $character);

        $response = $this->characterService->delete($character);

        return new JsonResponse(array('delete' => $response));
    }

    /**
     * Return image randomly
     */
    #[Route('/character/images/{number}', name: 'character_images', requirements: ["number" => "^([0-9]{1,2})$"], methods: ["GET", "HEAD"])]
    public function images(int $number): Response
    {
        $this->denyAccessUnlessGranted('characterIndex', null);
        return new JsonResponse($this->characterService->getImages($number));
    }

    #[Route('/character/images/{kind}/{number}', name: 'character_images_kind', requirements: ["kind" => "^(dames|seigneurs|ennemies|ennemis)$", "number" => "^([0-9]{1,2})$"], methods: ["GET", "HEAD"])]
    public function imagesKind(int $number, string $kind): Response
    {
        $this->denyAccessUnlessGranted('characterIndex', null);
        return new JsonResponse($this->characterService->getImages($number, $kind));
    }
}
