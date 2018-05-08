<?php

namespace AppBundle\Service;

use AppBundle\Entity\Tvshow;
use AppBundle\Entity\User;
use AppBundle\Form\TvshowType;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TvshowService
{
    /** @var EntityManager */
    protected $em;

    /** @var FormFactory */
    protected $formFactory;

    /** @var AuthService  */
    private $authService;

    /** @var PaginatorService  */
    private $paginator;

    /**
     * TvshowService constructor.
     * @param EntityManager $em
     * @param FormFactory $formFactory
     * @param AuthService $authService
     */
    public function __construct(EntityManager $em, FormFactory $formFactory, AuthService $authService, PaginatorService $paginator)
    {
        $this->em = $em;
        $this->formFactory = $formFactory;
        $this->authService = $authService;
        $this->paginator = $paginator;
    }

    /**
     * @param Request $request
     * @param Tvshow|null $tvshow
     * @return Tvshow
     */
    public function getTvshow(Request $request, Tvshow $tvshow = null)
    {
        if (!$tvshow) {
            throw new NotFoundHttpException('Resource not found');
        }

        $user = $this->authService->isAuthenticated($request, ['ROLE_USER']);
        $this->authService->isOwnerOfEntity($user, $tvshow->getUserId());

        return $tvshow;
    }

    /**
     * @param Request $request
     * @return Tvshow|\Symfony\Component\Form\FormInterface
     */
    public function postTvshow(Request $request)
    {
        $user = $this->authService->isAuthenticated($request, ['ROLE_USER']);

        $tvShow = new Tvshow();
        $form = $this->formFactory->create(TvshowType::class, $tvShow);

        $request->request->set("userId",$user['id']);

        $form->submit($request->request->all());

        if ($form->isSubmitted() && $form->isValid()) {
            $tvShowData = $form->getData();
            $em = $this->em;
            $em->persist($tvShowData);
            $em->flush();

            return $tvShow;
        }

        return $form;
    }

    /**
     * @param Request $request
     * @param Tvshow|null $tvshow
     * @return Tvshow|\Symfony\Component\Form\FormInterface
     */
    public function putTvshow(Request $request, Tvshow $tvshow = null)
    {
        if (!$tvshow) {
            throw new NotFoundHttpException('Resource not found');
        }

        $request->setMethod('PATCH');
        $user = $this->authService->isAuthenticated($request, ['ROLE_USER']);
        $this->authService->isOwnerOfEntity($user, $tvshow->getUserId());

        $form = $this->formFactory->create(TvshowType::class, $tvshow, ['method' => $request->getMethod()]);

        // don't overwrite user_id
        if (!in_array('ROLE_ADMIN', $user['roles'])) {
            $request->request->set("userId", $user['id']);
        } else {
            $request->request->set("userId", $tvshow->getUserId());
        }

        $form->submit($request->request->all(), false);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->em;
            $em->flush();

            return $tvshow;
        }

        return $form;
    }

    /**
     * @param Request $request
     * @param Tvshow|null $tvshow
     * @return bool
     */
    public function deleteTvshow(Request $request, Tvshow $tvshow = null)
    {
        if (!$tvshow) {
            throw new NotFoundHttpException('Resource not found');
        }

        $user = $this->authService->isAuthenticated($request, ['ROLE_USER']);
        $this->authService->isOwnerOfEntity($user, $tvshow->getUserId());

        $em = $this->em;
        $em->remove($tvshow);
        $em->flush();

        return true;
    }

    public function getTvshowsByUserId(Request $request, $id)
    {
        if (!$id) {
            throw new NotFoundHttpException('Resource not found');
        }

        $user = $this->authService->isAuthenticated($request, ['ROLE_USER']);
        $this->authService->isOwnerOfEntity($user, (int) $id);

        $query = $this->em->getRepository(Tvshow::class)->findTvshowsByUserId($id);

        return $this->paginator->setPaginationData($request, $query);
    }
}
