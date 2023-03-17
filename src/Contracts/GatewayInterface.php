<?php

declare(strict_types=1);

/*
 * This file is part of the qvbilam/audit
 *
 * (c) qvbilam <qvbilam@163.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Qvbilam\Audit\Contracts;

use Qvbilam\Audit\Response\Response;

interface GatewayInterface
{
    public function getName(): string;

    public function text(ContentInterface $content): Response;

    public function image(ContentInterface $content): Response;
}
