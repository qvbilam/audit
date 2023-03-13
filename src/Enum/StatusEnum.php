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

namespace Qvbilam\Audit\Enum;

class StatusEnum
{
    const AUDIT_STATUS_REJECT = -1;
    const AUDIT_STATUS_REVIEW = 0;
    const AUDIT_STATUS_PASS = 1;

    public static function SMv2ToStatus(string $status): int
    {
        return match ($status) {
            'REJECT' => self::AUDIT_STATUS_REJECT,
            'REVIEW' => self::AUDIT_STATUS_REVIEW,
            default => self::AUDIT_STATUS_PASS,
        };
    }
}
