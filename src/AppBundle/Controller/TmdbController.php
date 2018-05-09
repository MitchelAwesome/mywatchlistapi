<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\Annotations\RouteResource;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @package AppBundle\Controller
 * @View(serializerGroups={"default"})
 * @RouteResource("search", pluralize=false)
 */
class TmdbController extends FOSRestController
{
    public function cgetAction(Request $request)
    {
        $query = $request->query->get('query');
        $guzzle = $this->get('tmdb_service');

        if ($query || !empty($query)) {
            $resp = $guzzle->search($query);
        } else {
            $resp = $guzzle->random();
        }

        $response = new \Symfony\Component\HttpFoundation\Response($resp);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function getAction($id = null) {
        $guzzle = $this->get('tmdb_service');
        $resp = $guzzle->getShowByid($id);
        $response = new \Symfony\Component\HttpFoundation\Response($resp);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

}
