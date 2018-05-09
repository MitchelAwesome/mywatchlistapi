<?php

namespace AppBundle\Service;


use Symfony\Component\DependencyInjection\ContainerInterface;

class TmdbService
{
    /** @var ContainerInterface  */
    private $container;
    private $guzzle;

    public function __construct(ContainerInterface $container)
    {
        /** @var container */
        $this->container = $container;
        $this->guzzle = $this->container->get('guzzle.client.tmdb_api');
    }

    public function search($query = null)
    {
        $client = $this->guzzle;
        $resp = $client->get('/3/search/tv', [
            'query' => array_merge(
                $client->getConfig()['query'],
                ['query' => $query]
            )
        ]);

        return $resp->getBody()->getContents();
    }

    public function random() {

        $client = $this->guzzle;
        $resp = $client->get('/3/discover/tv',  [
            'query' => array_merge(
                $client->getConfig()['query'],
                [
                    'sort_by' => 'popularity.desc',
                    'vote_average.gte' => 8,
                    'page' => rand(1,150),
                    'total_results' => 1,
                    'include_null_first_air_dates' => 'false'
                ]
            )
        ]);

        return $resp->getBody()->getContents();
    }

    public function getShowByid($id)
    {
        $client = $this->guzzle;
        $resp = $client->get('/3/tv/'.$id, [
            'query' => array_merge(
                $client->getConfig()['query'],
                ['language' => 'en-US']
            )
        ]);

        return $resp->getBody()->getContents();
    }

}