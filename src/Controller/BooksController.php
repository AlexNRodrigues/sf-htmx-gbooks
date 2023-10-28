<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class BooksController extends AbstractController
{
    public function __construct(
        private HttpClientInterface $client,
    ) {
    }

    #[Route('/books/search', name: 'app_books')]
    public function search(Request $request): Response
    {
        $query = $request->query->get('q');

        $response = $this->client->request('GET', 'https://www.googleapis.com/books/v1/volumes?q='.$query.'&langRestrict=ptorderBy=relevance&key=< add API key >');
        $content = $response->getContent();

        $content = json_decode($content);

        return $this->render('books/search.html.twig', [
            'content' => $content->items
        ]);
    }
}
