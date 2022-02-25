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

use Sulu\Bundle\SyliusConsumerBundle\Payload\ImagePayload;
use Symfony\Component\HttpFoundation\File\UploadedFile;

interface SyliusImageDownloaderInterface
{
    public function downloadImage(ImagePayload $payload): UploadedFile;
}
