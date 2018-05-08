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
 * @RouteResource("search")
 */
class TmdbController extends FOSRestController
{
    public function getAction(Request $request)
    {
        $query = $request->query->get('query');

        if ($query || !empty($query)) {
            $resp = $this->get('tmdb_service')->search($query);
        } else {
            $resp = $this->get('tmdb_service')->random();
        }

        $response = new \Symfony\Component\HttpFoundation\Response($resp);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }


}
