<?php

namespace App\Client;

use App\Domain\Model\W3RideBike;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class W3RideClient
{
    public function __construct(
        private HttpClientInterface $client,
        private string $scoreUrl,
    ) {
    }

    public function getBike(int $id): W3RideBike
    {
        $response = $this->client->request('POST', $this->scoreUrl, [
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
