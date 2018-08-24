<?php

namespace Kolah\GraphQL\Client;

use Http\Client\HttpClient;
use Http\Message\MessageFactory;
use Kolah\GraphQL\Client\Exception\GraphQLErrorException;
use Kolah\GraphQL\Client\Exception\HttpTransportException;

abstract class GraphQLService
{
    /** @var string */
    protected $url;

    /** @var HttpClient */
    protected $client;

    /** @var MessageFactory */
    protected $messageFactory;

    public function __construct(HttpClient $client, MessageFactory $messageFactory, string $url)
    {
        $this->url = $url;
        $this->client = $client;
        $this->messageFactory = $messageFactory;
    }

    protected function send(string $query)
    {
        $body = ['query' => $query];

        $encodedBody = json_encode($body);

        $request = $this->messageFactory->createRequest('POST', $this->url, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($encodedBody)
        ], $encodedBody);

        $response = $this->client->sendRequest($request);
        if ($response->getStatusCode() >= 400) {
            throw HttpTransportException::forStatusCode($response->getStatusCode(), $response->getReasonPhrase());
        }

        $result = json_decode((string)$response->getBody(), true);

        if (array_key_exists('errors', $result)) {
            throw new GraphQLErrorException($result['errors'], $result['data']);
        }

        return $result['data'];
    }
}
