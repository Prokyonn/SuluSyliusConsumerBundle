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

namespace Sulu\Bundle\SyliusConsumerBundle\Exception;

use Symfony\Component\Messenger\Exception\RecoverableMessageHandlingException;

final class ImageDownloadFailedRecoverableException extends RecoverableMessageHandlingException
{
    public function __construct(string $url)
    {
        parent::__construct(\sprintf('Image download from url "%s" failed.', $url));
    }
}
