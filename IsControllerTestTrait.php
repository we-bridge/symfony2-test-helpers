<?php

namespace AllanSimon\TestHelpers;

trait IsControllerTestTrait
{
    use ClosesConnectionsAfterTestTrait;
    use ReflectsAndCleansPropertiesAfterTestTrait;

    protected $client;
    protected $crawler;

    public function setUp()
    {
        $this->client = $this->getClient();

        $fixtureExecutor = $this->loadFixtures($this->fixturelist);
        $this->em = $fixtureExecutor->getObjectManager();
        $this->fixtures = $fixtureExecutor->getReferenceRepository();
    }

    protected function getClient(){
        return static::createClient();
    }

    protected function openPage($page)
    {
        $this->crawler = $this->client->request('GET', $page);
    }

    protected function assertPageOpenedSuccessfully()
    {
        $this->assertTrue(
            $this->client->getResponse()->isSuccessful(),
            sprintf(
                'Unexpected HTTP status code %d',
                $this->client->getResponse()->getStatusCode()
            )
        );
    }

    protected function assertContainsRecordPropertiesBlock()
    {
        $this->assertEquals(1, $this->crawler->filter('.record_properties')->count());
    }

    protected function getFirstElementByTestName($name)
    {
        return $this->crawler
            ->filter("[data-for-test-name='$name']")
            ->eq(0);
    }

    protected function assertFormRedirect()
    {
        // we check that we got a redirection
        $this->assertEquals(
            302,
            $this->client->getResponse()->getStatusCode(),
            'The page is not successfully redirect.'
        );
    }

    protected function clickFirstLink($name)
    {
        $link = $this->getFirstElementByTestName($name)->link();
        $this->crawler = $this->client->click($link);
    }

    protected function followRedirect()
    {
        $this->crawler = $this->client->followRedirect();
    }
}
