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

class RiskEnum
{
    const NORMAL = 'normal'; // 正常
    const SPAM = 'spam'; // 垃圾内容
    const POLITICS = 'politics'; // 敏感内容
    const ABUSE = 'abuse'; // 辱骂内容
    const TERRORISM = 'terrorism'; // 暴恐内容
    const PORN = 'porn'; // 鉴黄内容
    const FLOOD = 'flood'; // 灌水内容
    const CONTRABAND = 'contraband'; // 违禁内容
    const AD = 'ad'; // 广告内容
    const CUSTOMIZE = 'customize'; // 自定义

    /**
     * https://help.ishumei.com/docs/tj/text/history/developDoc/
     * 数美v2转换类型.
     */
    public static function SMv2ToType(string $type): string
    {
        return match ((int) $type) {
            0 => self::NORMAL,
            100 => self::POLITICS,
            200 => self::PORN,
            210 => self::ABUSE,
            300 => self::AD,
            400 => self::FLOOD,
            500 => self::SPAM,
            600 => self::CONTRABAND,
            default => self::CUSTOMIZE,
        };
    }
}
