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
     * 数美v2转换类型.(https://help.ishumei.com/docs/tj/text/history/developDoc/).
     */
    public static function SMv2ToType(string $type): string
    {
        switch ($type) {
            case 0:
                return self::NORMAL;
            case 100:
                return self::POLITICS;
            case 200:
                return self::PORN;
            case 210:
                return self::ABUSE;
            case 300:
                return self::AD;
            case 400:
                return self::FLOOD;
            case 500:
                return self::SPAM;
            case 600:
                return self::CONTRABAND;
            default:
                return self::CUSTOMIZE;
        }
    }
}
