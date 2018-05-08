<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Fighter;
use AppBundle\Entity\Tvshow;
use AppBundle\Entity\User;
use AppBundle\Service\AuthService;
use AppBundle\Service\PaginatorService;
use AppBundle\Service\TvshowService;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerBuilder;
use Lexik\Bundle\JWTAuthenticationBundle\TokenExtractor\AuthorizationHeaderTokenExtractor;
use Symfony\Component\HttpFoundation\Request;

/**
 * @package AppBundle\Controller
 * @RouteResource("users")
 */
class UserController extends FOSRestController implements ClassResourceInterface
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getTvshowsAction(Request $request, $id)
    {
        $data = $this->get('tvshow_service')->getTvshowsByUserId($request, $id);

        $serializer = SerializerBuilder::create()->build();
        $results = $serializer->serialize($data, 'json', SerializationContext::create()
            ->setGroups(['default','ROLE_ADMIN'])
            ->enableMaxDepthChecks());

        $response = new \Symfony\Component\HttpFoundation\Response($results);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}

