<?php

namespace App\Client;

use App\Domain\Model\JpgStoreBikeSale;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class JpgStoreClient
{
    private const DEFAULT_PARAMS = [
        'policyIds' => '902eaf4440531a68e8a00345f3c7455ad2c8c8f3bbd59355fa14b9aa',
        'saleType' => 'buy-now',
        'sortBy' => 'price-low-to-high',
        'traits' => 'e30=',
        'listingTypes' => 'ALL_LISTINGS',
        'nameQuery' => 'cycl',
        'verified' => 'default',
        'onlyMainBundleAsset' => 'false',
        'size' => '20',
    ];

    public function __construct(
        private HttpClientInterface $client,
        private string $searchUrl,
    ) {
    }

    /**
     * @return JpgStoreBikeSale[]
     */
    public function getSales(): iterable
    {
        $pagination = null;

        do {
            $params = self::DEFAULT_PARAMS;
            if (null !== $pagination) {
                $params['pagination'] = $pagination;
            }
            $url = $this->searchUrl.'?'.http_build_query($params);

            $response = $this->client->request('GET', $url, [
                'headers' => [
                    'X-jpgstore-csrf-protection' => '1',
                ],
            ]);
            $responseArray = $response->toArray();

            foreach ($responseArray['tokens'] as $token) {
                yield new JpgStoreBikeSale(
                    $token['asset_num'],
                    $token['asset_id'],
                    $token['listing_lovelace'],
                );
            }

            $pagination = base64_encode(json_encode($responseArray['pagination']));
        } while (array_key_exists('lastHitSort', $responseArray['pagination']));
    }
}
