<?php

declare(strict_types=1);

class ApiTest extends \PHPUnit\Framework\TestCase
{
    private \GuzzleHttp\Client $guzzle;
    private \app\DB $db;

    protected function setUp(): void
    {
        $this->guzzle = new \GuzzleHttp\Client(['base_uri' => 'http://localhost']);
        $this->db = new \app\DB();

        parent::setUp();
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function appIsRunning(): void
    {
        $response = $this->guzzle->get('/healthz');

        $this->assertEquals(200, $response->getStatusCode());
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function searchReturnsExpectedResults(): void
    {
        $id = $this->db->insertFile('searchtest.txt', null, false);

        $response = $this->guzzle->get('/search/searchtest');

        $this->assertEquals(200, $response->getStatusCode());
        $body = $response->getBody()->getContents();
        $this->assertStringContainsString('searchtest.txt', $body);

        $this->db->deleteFile($id);
    }
}
