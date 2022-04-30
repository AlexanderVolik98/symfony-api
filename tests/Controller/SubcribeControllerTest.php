<?php

namespace App\Tests\Controller;

use App\Tests\AbstractControllerTest;
use Symfony\Component\HttpFoundation\Response;

class SubcribeControllerTest extends AbstractControllerTest
{
//    public function testAction(): void
//    {
//        $content = json_encode(['email' => 'test@gtesft.com', 'agreed' => true]);
//
//        $this->client->request('POST', '/api/v1/book/subscribe', [], [], [], $content);
//
//        $this->assertResponseIsSuccessful();
//    }

    public function testActionNotAgreed(): void
    {
        $content = json_encode(['email' => 'test@gffdstesft.com']);

        $this->client->request('POST', '/api/v1/book/subscribe', [], [], [], $content);

        $responseContent = json_decode($this->client->getResponse()->getContent());

        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
        $this->assertJsonDocumentMatches($responseContent, [
            '$.message' => 'validation failed',
            '$.details.violations' => self::countOf(1),
            '$.details.violations[0].field' => 'agreed',
        ]);
    }
}
