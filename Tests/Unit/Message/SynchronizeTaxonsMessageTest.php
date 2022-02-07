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
use Sulu\Bundle\SyliusConsumerBundle\Message\SynchronizeTaxonsMessage;

class SynchronizeTaxonsMessageTest extends TestCase
{
    public function testGetPayload(): void
    {
        $message = new SynchronizeTaxonsMessage(['id' => 1, 'name' => []]);

        $this->assertEquals(['id' => 1, 'name' => []], $message->getTaxons());
    }
}
