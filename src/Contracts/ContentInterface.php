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

interface ContentInterface
{
    const TYPE_TEXT = 'text';
    const TYPE_IMAGE = 'image';

    public function getContentType(): string;

    public function getContent(): string;
}