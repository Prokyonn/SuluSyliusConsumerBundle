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

namespace Sulu\Bundle\SyliusConsumerBundle\Payload;

use Sulu\Bundle\SyliusConsumerBundle\Common\Payload;

class ImagePayload
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $locale;

    /**
     * @var Payload
     */
    private $payload;

    public function __construct(int $id, string $locale, array $payload)
    {
        $this->id = $id;
        $this->locale = $locale;
        $this->payload = new Payload($payload);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getLocale(): string
    {
        return $this->locale;
    }

    public function getType(): string
    {
        return $this->payload->getStringValue('type');
    }

    public function getPath(): string
    {
        return $this->payload->getStringValue('path');
    }

    public function getFilename(): ?string
    {
        return $this->payload->getNullableStringValue('filename');
    }

    public function getCustomData(): Payload
    {
        return new Payload($this->payload->getNullableArrayValue('customData', true) ?? []);
    }

    public function getPayload(): Payload
    {
        return $this->payload;
    }
}
