<?php
declare(strict_types=1);

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
     * 获取配置
     * @param string $key
     * @param mixed|null $default
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        $config = $this->config;
        if (isset($config[$key])){
            return $config[$key];
        }

        if (strpos($key, ".") === false){
            return $default;
        }

        foreach (explode('.', $key) as $item){
            if (!is_array($config) || !array_key_exists($item, $config)){
                return $default;
            }
            $config = $config[$item];
        }
        return $config;
    }
}