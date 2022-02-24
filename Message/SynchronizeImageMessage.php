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

class SynchronizeImageMessage
{
    /**
     * @var array
     */
    private $image;

    /**
     * @var string
     */
    private $locale;

    public function __construct(array $image, string $locale)
    {
        $this->image = $image;
        $this->locale = $locale;
    }

    public function getImage(): array
    {
        return $this->image;
    }

    public function getLocale(): string
    {
        return $this->locale;
    }
}
