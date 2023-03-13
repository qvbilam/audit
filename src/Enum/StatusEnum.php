<?php
declare(strict_types=1);

namespace Qvbilam\Audit\Enum;


class StatusEnum
{
    const AUDIT_STATUS_REJECT = -1;
    const AUDIT_STATUS_REVIEW = 0;
    const AUDIT_STATUS_PASS = 1;

    static public function SMv2ToStatus(string $status): int
    {
        return match ($status) {
            "REJECT" => self::AUDIT_STATUS_REJECT,
            "REVIEW" => self::AUDIT_STATUS_REVIEW,
            default => self::AUDIT_STATUS_PASS,
        };
    }
}