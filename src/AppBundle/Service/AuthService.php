<?php

namespace AppBundle\Service;

use Lexik\Bundle\JWTAuthenticationBundle\TokenExtractor\AuthorizationHeaderTokenExtractor;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class AuthService
{
    /**
     * @param Request $request
     * @param array $rolesArray
     * @return array|bool
     */
    public function isAuthenticated(Request $request, $rolesArray = array())
    {
        $token = $this->tokenInfo($request);

        if (!$token || empty($token)) {
            throw new AccessDeniedHttpException('Access Denied');
        }

        $this->hasRoles($token['roles'], $rolesArray);

        return $token;
    }

    /**
     * @param $user
     * @param $entityUserId
     * @return bool
     */
    public function isOwnerOfEntity($user, $entityUserId)
    {
        if ($user['id'] === $entityUserId || $this->hasRoles($user['roles'], ['ROLE_ADMIN'])) {
            return true;
        } else {
            throw new AccessDeniedHttpException('Access Denied');
        }
    }

    /**
     * @param $request
     * @return array|bool
     */
    public function tokenInfo($request)
    {
        global $kernel;

        $extractor = new AuthorizationHeaderTokenExtractor('Bearer', 'Authorization');
        $token = $extractor->extract($request);

        if($token && $token !='' && !empty($token)) {
            $user = $kernel->getContainer()->get('lexik_jwt_authentication.encoder')->decode($token);
            return $user;
        }

        return false;
    }


    public function hasRoles(array $tokenRoles, array $rolesArray)
    {
        $count = array_intersect($tokenRoles, $rolesArray);

        if (count($count) < 1) {
            throw new AccessDeniedHttpException('Access Denied');
        }

        return true;
    }

}