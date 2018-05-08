<?php
/**
 * Created by PhpStorm.
 * User: mitchelaustin
 * Date: 07/05/2018
 * Time: 04:03
 */

namespace AppBundle\Service;


use Symfony\Component\HttpFoundation\Request;

class PaginatorService
{
    /**
     * @param $query
     * @return array
     */
    public function setPaginationData(Request $request, $query)
    {
        global $kernel;

        $paginator = $kernel->getContainer()->get('knp_paginator');

        

        $results = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1)/*page number*/,
            $request->query->getInt('limit', 20) /*page number*/
        );

        $data = array(
            'meta' => $results->getPaginationData(),
            'data' => $results->getItems()
        );

        return $data;
    }

}