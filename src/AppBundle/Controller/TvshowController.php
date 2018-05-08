<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Tvshow;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;


/**
 * @package AppBundle\Controller
 * @View(serializerGroups={"default"})
 * @RouteResource("tvshows")
 */
class TvshowController extends FOSRestController
{
    /**
     * @param Request $request
     * @param Tvshow|null $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getAction(Request $request, Tvshow $id = null)
    {
        $tvShowService = $this->get('tvshow_service')->getTvshow($request, $id);

        $view = $this->view($tvShowService, 200);
        return $this->handleView($view);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function postAction(Request $request)
    {
        $tvShowService = $this->get('tvshow_service')->postTvshow($request);

        $view = $this->view($tvShowService, 201);
        return $this->handleView($view);
    }

    /**
     * @param Request $request
     * @param Tvshow $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function putAction(Request $request, Tvshow $id = null)
    {
        $tvShowService = $this->get('tvshow_service')->putTvshow($request, $id);

        $view = $this->view($tvShowService,200);
        return $this->handleView($view);
    }

    /**
     * @param Request $request
     * @param Tvshow $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction(Request $request, Tvshow $id = null)
    {
        $tvShowService = $this->get('tvshow_service')->deleteTvshow($request, $id);
        $view = $this->view($tvShowService,204);
        return $this->handleView($view);
    }
}
