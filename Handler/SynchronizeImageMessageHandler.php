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

namespace Sulu\Bundle\SyliusConsumerBundle\Handler;

use Sulu\Bundle\SyliusConsumerBundle\Adapter\ImageAdapterInterface;
use Sulu\Bundle\SyliusConsumerBundle\Message\SynchronizeImageMessage;
use Sulu\Bundle\SyliusConsumerBundle\Payload\ImagePayload;

class SynchronizeImageMessageHandler
{
    /**
     * @var iterable<ImageAdapterInterface>
     */
    private $mediaAdapters;

    public function __construct(iterable $mediaAdapters)
    {
        $this->mediaAdapters = $mediaAdapters;
    }

    public function __invoke(SynchronizeImageMessage $message): void
    {
        $image = $message->getImage();

        foreach ($this->mediaAdapters as $mediaAdapter) {
            $mediaAdapter->synchronize(new ImagePayload($image['id'], $message->getLocale(), $image));
        }
    }
}
