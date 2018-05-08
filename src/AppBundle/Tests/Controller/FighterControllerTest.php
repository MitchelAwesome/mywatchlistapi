<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FighterControllerTest extends WebTestCase
{
    public function testCget()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/cget');
    }

}
