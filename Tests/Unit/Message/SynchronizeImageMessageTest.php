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

namespace Sulu\Bundle\SyliusConsumerBundle\Tests\Unit\Message;

use PHPUnit\Framework\TestCase;
use Sulu\Bundle\SyliusConsumerBundle\Message\SynchronizeImageMessage;

class SynchronizeImageMessageTest extends TestCase
{
    public function testGetPayload(): void
    {
        $message = new SynchronizeImageMessage(['id' => 1, 'name' => []], 'en');

        $this->assertEquals(['id' => 1, 'name' => []], $message->getImage());
    }

    public function testGetLocale(): void
    {
        $message = new SynchronizeImageMessage(['id' => 1, 'name' => []], 'en');

        $this->assertEquals('en', $message->getLocale());
    }
}
