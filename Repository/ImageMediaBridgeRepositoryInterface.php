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

namespace Sulu\Bundle\SyliusConsumerBundle\Repository;

use Sulu\Bundle\MediaBundle\Entity\MediaInterface;
use Sulu\Bundle\SyliusConsumerBundle\Entity\ImageMediaBridgeInterface;

interface ImageMediaBridgeRepositoryInterface
{
    public function create(int $imageId, MediaInterface $media): ImageMediaBridgeInterface;

    public function add(ImageMediaBridgeInterface $bridge): void;

    public function findById(int $imageId): ?ImageMediaBridgeInterface;

    public function removeById(int $imageId): void;
}
