<?php

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

    /**
     * @param string $status
     *
     * @return int
     */
    public static function SMv2ToStatus($status)
    {
        switch ($status) {
            case 'REJECT':
                return self::AUDIT_STATUS_REJECT;
            case 'REVIEW':
                return self::AUDIT_STATUS_REVIEW;
            default:
                return self::AUDIT_STATUS_PASS;
        }
    }
}
