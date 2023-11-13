<?php

namespace App\Client;

use App\Domain\Model\W3RideBike;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class W3RideClient
{
    private const URL = 'https://w3ride.io/api/score-checker/check';

    public function __construct(
        private HttpClientInterface $client,
    ) {
    }

    public function getBike(int $id): W3RideBike
    {
        $response = $this->client->request('POST', self::URL, [
            'body' => [
                'bikeNumber' => $id,
            ],
        ]);

        $data = $response->toArray();

        return new W3RideBike(
            $data['Bike'],
            $data['Rarirty'],
            $data['ImageUrl'],
        );
    }
}
