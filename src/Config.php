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

namespace Qvbilam\Audit;

class Config
{
    /**
     * @var config
     */
    protected $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * 获取配置.
     *
     * @param mixed|null $default
     *
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        $config = $this->config;
        if (isset($config[$key])) {
            return $config[$key];
        }

        if (false === strpos($key, '.')) {
            return $default;
        }

        foreach (explode('.', $key) as $item) {
            if (!is_array($config) || !array_key_exists($item, $config)) {
                return $default;
            }
            $config = $config[$item];
        }

        return $config;
    }
}
