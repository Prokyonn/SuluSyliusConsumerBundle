<?php

declare(strict_types=1);

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\SyliusConsumerBundle\Service;

use Sulu\Bundle\SyliusConsumerBundle\Exception\ImageDownloadFailedRecoverableException;
use Sulu\Bundle\SyliusConsumerBundle\Payload\ImagePayload;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class SyliusImageDownloader implements SyliusImageDownloaderInterface
{
    /**
     * @var string
     */
    private $syliusBaseUrl;

    /**
     * @var HttpClientInterface
     */
    private $httpClient;

    public function __construct(HttpClientInterface $httpClient, string $syliusBaseUrl)
    {
        $this->syliusBaseUrl = $syliusBaseUrl;
        $this->httpClient = $httpClient;
    }

    public function downloadImage(ImagePayload $payload): UploadedFile
    {
        $url =
            rtrim($this->syliusBaseUrl, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR .
            'media' . DIRECTORY_SEPARATOR . 'image' . DIRECTORY_SEPARATOR . $payload->getPath();
        $urlParts = pathinfo($url);
        $filename = $urlParts['filename'] . '.' . ($urlParts['extension'] ?? '');
        $imagePath = sys_get_temp_dir() . DIRECTORY_SEPARATOR . $filename;

        $response = $this->httpClient->request('GET', $url);
        if (Response::HTTP_OK !== $response->getStatusCode()) {
            throw new ImageDownloadFailedRecoverableException($url);
        }
        $fileHandler = fopen($imagePath, 'wb');
        foreach ($this->httpClient->stream($response) as $chunk) {
            fwrite($fileHandler, $chunk->getContent());
        }

        return new UploadedFile($imagePath, $filename);
    }
}
