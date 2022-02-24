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

namespace Sulu\Bundle\SyliusConsumerBundle\Entity;

use Sulu\Bundle\MediaBundle\Entity\MediaInterface;

class ImageMediaBridge implements ImageMediaBridgeInterface
{
    /**
     * @var int
     */
    private $imageId;

    /**
     * @var MediaInterface
     */
    private $media;

    public function __construct(int $imageId, MediaInterface $media)
    {
        $this->imageId = $imageId;
        $this->media = $media;
    }

    public function getImageId(): int
    {
        return $this->imageId;
    }

    public function getMedia(): MediaInterface
    {
        return $this->media;
    }
}
