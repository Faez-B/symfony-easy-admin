<?php

namespace App\Tests;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApplicationAvailabilityFunctionalTest extends WebTestCase
{
    /**
     * @dataProvider urlProviderNotLogged
     */
    public function testPageIsSuccessfulNotLogged($url)
    {
        $client = self::createClient();
        $client->request('GET', $url);

        $this->assertResponseIsSuccessful();
    }

    public function urlProviderNotLogged()
    {
        yield ['/login'];
        yield ['/register'];
    }


    /**
     * @dataProvider urlProvider
     */
    public function testPageIsSuccessful($url)
    {
        $client = self::createClient();
        
        $userRepository = static::getContainer()->get(UserRepository::class);
        
        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('admin@admin.com');
        
        // simulate $testUser being logged in
        $client->loginUser($testUser);
        
        $client->request('GET', $url);
        
        $this->assertResponseIsSuccessful();
    }

    public function urlProvider()
    {
        yield ['/'];
        yield ['/admin'];
        yield ['/article/1'];
    }
}