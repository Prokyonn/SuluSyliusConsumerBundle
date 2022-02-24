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

interface ImageMediaBridgeInterface
{
    public function getImageId(): int;

    public function getMedia(): MediaInterface;
}
