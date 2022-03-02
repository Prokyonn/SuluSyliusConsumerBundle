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

namespace Sulu\Bundle\SyliusConsumerBundle\Tests\Functional\Mocks;

use Sulu\Bundle\SyliusConsumerBundle\Payload\ImagePayload;
use Sulu\Bundle\SyliusConsumerBundle\Service\SyliusImageDownloaderInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class SyliusImageDownloader implements SyliusImageDownloaderInterface
{
    /**
     * @var SyliusImageDownloaderInterface|null
     */
    private $mock;

    public function getMock(): SyliusImageDownloaderInterface
    {
        if (!$this->mock) {
            throw new \RuntimeException('The mock needs to be set on the container to be used');
        }

        return $this->mock;
    }

    public function setMock(SyliusImageDownloaderInterface $mock): self
    {
        $this->mock = $mock;

        return $this;
    }

    public function downloadImage(ImagePayload $payload): UploadedFile
    {
        return $this->mock->downloadImage($payload);
    }
}
