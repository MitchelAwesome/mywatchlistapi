<?php

namespace AppBundle\Service;

use Lexik\Bundle\JWTAuthenticationBundle\TokenExtractor\AuthorizationHeaderTokenExtractor;

class jwtService
{

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
}