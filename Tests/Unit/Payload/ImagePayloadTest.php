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

namespace Sulu\Bundle\SyliusConsumerBundle\Tests\Unit\Payload;

use PHPUnit\Framework\TestCase;
use Sulu\Bundle\SyliusConsumerBundle\Common\Payload;
use Sulu\Bundle\SyliusConsumerBundle\Payload\ImagePayload;
use Sulu\Bundle\SyliusConsumerBundle\Tests\MockSyliusData;

class ImagePayloadTest extends TestCase
{
    public function testGetId(): void
    {
        $entity = new ImagePayload(1, 'en', MockSyliusData::PRODUCT['images'][0]);

        $this->assertEquals(1, $entity->getId());
    }

    public function testGetLocale(): void
    {
        $entity = new ImagePayload(1, 'en', MockSyliusData::PRODUCT['images'][0]);

        $this->assertEquals('en', $entity->getLocale());
    }

    public function testGetType(): void
    {
        $entity = new ImagePayload(1, 'en', MockSyliusData::PRODUCT['images'][0]);

        $this->assertEquals('main', $entity->getType());
    }

    public function testGetPath(): void
    {
        $entity = new ImagePayload(1, 'en', MockSyliusData::PRODUCT['images'][0]);

        $this->assertEquals('23/d6/bab23ff05421d888c688112110c5.jpg', $entity->getPath());
    }

    public function testGetFilename(): void
    {
        $entity = new ImagePayload(1, 'en', MockSyliusData::PRODUCT['images'][0]);

        $this->assertEquals('Test123', $entity->getFilename());
    }

    public function testGetCustomData(): void
    {
        $entity = new ImagePayload(1, 'en', MockSyliusData::PRODUCT['images'][0]);

        $customData = $entity->getCustomData();
        $this->assertInstanceOf(Payload::class, $customData);
        $this->assertSame(['test' => 1], $customData->getData());
    }
}
