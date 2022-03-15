<?php

namespace App\Controller;

use App\Entity\Character;
use App\Service\Character\CharacterService;
use App\Service\Character\CharacterServiceInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;

class CharacterController extends AbstractController
{
    public function __construct(private CharacterServiceInterface $characterService)
    {
    }

    //INDEX

    /**
     *  Redirects to index Route
     * @OA\Response(response=302,description="Redirect")
     * @OA\Tag(name="Character")
     */
    #[Route('/character', name: 'character_redirect_index', methods: ["GET", "HEAD"])]
    public function redirectIndex(): Response
    {
        return $this->redirectToRoute('character_index');
    }

    //INDEX

    /**
     *  Displays available Characters
     * @OA\Response(response=200,description="Success",
     *      @OA\Schema(type="array",
     *          @OA\Items(ref=@Model(type=Character::class))
     *      )
     *  )
     * @OA\Response(response=403,description="Access denied")
     * @OA\Tag(name="Character")
     */
    #[Route('/character/index', name: 'character_index', methods: ["GET", "HEAD"])]
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('characterIndex', null);

        $characters = $this->characterService->getAll();

        return JsonResponse::fromJsonString($this->characterService->serializeJson($characters));
    }

    //INDEX

    /**
     *  Displays available Characters listed by intelligence given in url parameter
     * @OA\Response(response=200,description="Success",
     *      @OA\Schema(type="array",
     *          @OA\Items(ref=@Model(type=Character::class))
     *      )
     *  )
     * @OA\Response(response=403,description="Access denied")
     * @OA\Tag(name="Character")
     */
    #[Route('/character/index/intelligence/{intelligence}', name: 'character_intelligence_index', methods: ["GET"])]
    public function intelligenceIndex(CharacterService $characterService, int $intelligence): Response
    {
        $this->denyAccessUnlessGranted('characterIndex', null);
        $charactersByIntelligence = $characterService->getCharactersByIntelligence($intelligence);
        return JsonResponse::fromJsonString($this->characterService->serializeJson($charactersByIntelligence));

    }

    // DISPLAY

    /**
     *  Displays the Character
     * @OA\Parameter(name="identifier",in="path",description="identifier for the Character",required=true)
     * @OA\Response(response=200,description="Success",@Model(type=Character::class))
     * @OA\Response(response=403,description="Access denied")
     * @OA\Response(response=404,description="Not Found")
     * @OA\Tag(name="Character")
     */
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

    //CREATE

    /**
     *  Creates the Character
     * @OA\Response(response=200,description="Success",@Model(type=Character::class))
     * @OA\Response(response=403,description="Access denied")
     * @OA\RequestBody(request="Character",description="Data for the Character",required=true,
     *      @OA\MediaType(mediaType="application/json",
     *      @OA\Schema(ref="#/components/schemas/Character")
     *      )
     *  )
     * @OA\Tag(name="Character")
     */
    #[Route('/character/create', name: 'character_create', methods: ["POST", "HEAD"])]
    public function create(Request $request): Response
    {
        $this->denyAccessUnlessGranted('characterCreate', null);

        $character = $this->characterService->create($request->getContent());

        return JsonResponse::fromJsonString($this->characterService->serializeJson($character));
    }

    //MODIFY

    /**
     *  Modifies the Character
     * @OA\Response(response=200,description="Success",@Model(type=Character::class))
     * @OA\Response(response=403,description="Access denied",)
     * @OA\Parameter(name="identifier",in="path",description="identifier for the Character",required=true)
     * @OA\RequestBody(request="Character",description="Data for the Character",required=true,
     *      @OA\MediaType(mediaType="application/json",
     *          @OA\Schema(ref="#/components/schemas/Character")
     *      )
     *  )
     * @OA\Tag(name="Character")
     */
    #[Route('/character/modify/{identifier}', name: 'character_modify', requirements: ["identifier" => "^([a-z0-9]{40})$"], methods: ["PUT", "HEAD"])]
    public function modify(Request $request, Character $character): Response
    {
        $this->denyAccessUnlessGranted('characterModify', $character);

        $character = $this->characterService->modify($request->getContent(), $character);

        return JsonResponse::fromJsonString($this->characterService->serializeJson($character));
    }

    //DELETE

    /**
     *  Deletes the Character
     * @OA\Response(response=200,description="Success",
     *      @OA\Schema(
     *          @OA\Property(property="delete", type="boolean")
     *      )
     *  )
     * @OA\Response(response=403,description="Access denied")*
     * @OA\Parameter(name="identifier",in="path",description="identifier for the Character",required=true)
     * @OA\Tag(name="Character")
     */
    #[Route('/character/delete/{identifier}', name: 'character_delete', requirements: ["identifier" => "^([a-z0-9]{40})$"], methods: ["DELETE", "HEAD"])]
    public function delete(Character $character): Response
    {
        $this->denyAccessUnlessGranted('characterDelete', $character);

        $response = $this->characterService->delete($character);

        return new JsonResponse(array('delete' => $response));
    }

    // IMAGE

    /**
     *  Displays random images
     * @OA\Parameter(name="number",in="path",description="number of images",required=true)
     * @OA\Response(response=200,description="Success",@Model(type=Character::class))
     * @OA\Response(response=403,description="Access denied")
     * @OA\Response(response=404,description="Not Found")
     * @OA\Tag(name="Character")
     */
    #[Route('/character/images/{number}', name: 'character_images', requirements: ["number" => "^([0-9]{1,2})$"], methods: ["GET", "HEAD"])]
    public function images(int $number): Response
    {
        $this->denyAccessUnlessGranted('characterIndex', null);
        return new JsonResponse($this->characterService->getImages($number));
    }

    // IMAGE

    /**
     *  Displays random images by kind
     * @OA\Parameter(name="kind",in="path",description="kind of character",required=true)
     * @OA\Parameter(name="number",in="path",description="number of images",required=true)
     * @OA\Response(response=200,description="Success",@Model(type=Character::class))
     * @OA\Response(response=403,description="Access denied")
     * @OA\Response(response=404,description="Not Found")
     * @OA\Tag(name="Character")
     */
    #[Route('/character/images/{kind}/{number}', name: 'character_images_kind', requirements: ["kind" => "^(dames|seigneurs|ennemies|ennemis)$", "number" => "^([0-9]{1,2})$"], methods: ["GET", "HEAD"])]
    public function imagesKind(int $number, string $kind): Response
    {
        $this->denyAccessUnlessGranted('characterIndex', null);
        return new JsonResponse($this->characterService->getImages($number, $kind));
    }
}
