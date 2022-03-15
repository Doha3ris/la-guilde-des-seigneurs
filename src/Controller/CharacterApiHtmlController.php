<?php

namespace App\Controller;

use App\Form\CharacterApiHtmlType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;


#[Route('/character/api-html')]
class CharacterApiHtmlController extends AbstractController
{
    private HttpClientInterface $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    #[Route('/', name: 'character_api_html_index', methods: ["GET"])]
    public function index(): Response
    {
        $response = $this->client->request('GET', 'https://api.la-guilde-des-seigneurs.com/character/index');
        return $this->render('character_api_html/index.html.twig', [
            'characters' => $response->toArray()
        ]);
    }

    #[Route('/intelligence/{intelligence}', name: 'character_api_html_intelligence_index', requirements: ["intelligence" => "^([0-9]{1,3})$"], methods: ["GET"])]
    public function intelligenceLevel(int $level): Response
    {
        $response = $this->client->request('GET', 'https://api.la-guilde-des-seigneurs.com/character/intelligence/' . $level);
        return $this->render('character_api_html/index.html.twig', [
            'characters' => $response->toArray()
        ]);
    }

    #[Route('/new', name: 'character_api_html_new', methods: ["GET", "POST"])]
    public function new(Request $request): Response
    {
        $character = array();
        $form = $this->createForm(CharacterApiHtmlType::class, $character);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $response = $this->client->request(
                'POST',
                'https://api.la-guilde-des-seigneurs.com/character/create',
                ['json' => $request->request->all()['character_api_html'],
                ]);

            return $this->redirectToRoute('character_api_html_show', array(
                'identifier' => $response->toArray()['identifier'],
            ));
        }

        return $this->renderForm('character_api_html/new.html.twig', [
            'character' => $character,
            'form' => $form,
        ]);
    }

    #[Route('/{identifier}', name: 'character_api_html_show', methods: ["GET"])]
    public function show(string $identifier): Response
    {
        $response = $this->client->request('GET', 'https://api.la-guilde-des-seigneurs.com/character/display/' . $identifier);
        return $this->render('character_api_html/show.html.twig', [
            'character' => $response->toArray(),
        ]);
    }

    #[Route('/{identifier}/edit', name: 'character_api_html_edit', methods: ["GET", "POST"])]
    public function edit(Request $request, string $identifier): Response
    {

        $response = $this->client->request('GET', 'https://api.la-guilde-des-seigneurs.com/character/display/' . $identifier);
        $character = $response->toArray();

        $form = $this->createForm(CharacterApiHtmlType::class, $character);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->client->request('PUT', 'https://api.la-guilde-des-seigneurs.com/character/modify/' . $identifier,
                [
                    'json' => $request->request->all()['character_api_html'],
                ]);

            return $this->redirectToRoute('character_api_html_show',
                array('identifier' => $identifier));
        }

        return $this->renderForm('character_api_html/edit.html.twig',
            ['character' => $character, 'form' => $form,]);

    }

    #[Route('/{identifier}', name: 'character_api_html_delete', methods: ["POST"])]
    public function delete(Request $request, string $identifier): Response
    {
        if ($this->isCsrfTokenValid('delete' . $identifier, $request->request->get('_token'))) {
            $this->client->request('DELETE', 'https://api.la-guilde-des-seigneurs.com/character/delete/' . $identifier,);
        }

        return $this->redirectToRoute('character_api_html_index', [], Response::HTTP_SEE_OTHER);
    }
}