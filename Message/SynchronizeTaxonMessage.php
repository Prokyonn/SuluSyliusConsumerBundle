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

namespace Sulu\Bundle\SyliusConsumerBundle\Message;

class SynchronizeTaxonMessage
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var array
     */
    private $payload;

    /**
     * @var bool
     */
    private $ignoreChildren;

    public function __construct(int $id, array $payload, bool $ignoreChildren = false)
    {
        $this->id = $id;
        $this->payload = $payload;
        $this->ignoreChildren = $ignoreChildren;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getPayload(): array
    {
        return $this->payload;
    }

    public function ignoreChildren(): bool
    {
        return $this->ignoreChildren;
    }
}
