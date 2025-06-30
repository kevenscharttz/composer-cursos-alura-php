<?php

namespace Alura\BuscadorDeCursos;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Symfony\Component\DomCrawler\Crawler;

class Buscador
{
    private $httpClient;
    private $crawler;

    public function __construct(ClientInterface $httpClient, Crawler $crawler)
    {
        $this -> httpClient = $httpClient;
        $this -> crawler = $crawler;
    }
    public function buscar(string $url)
    {

        $response = $this -> httpClient->request("GET", $url);

        $html = $response->getBody();

        $this->crawler -> addHtmlContent($html);
        $elementosCursos = $this->crawler->filter('.card-curso__nome');
        $cursos = [];

        foreach ($elementosCursos as $elementoCurso) {
            $cursos[] = $elementoCurso -> textContent;
        }

        return $cursos;
    }
}
