<?php
declare(strict_types=1);

namespace Qvbilam\Audit\Response;


class Response
{
    public function toArray()
    {
        return json_decode($this->toJson(), true);
    }

    public function toJson(): bool|string
    {
        return json_encode($this);
    }
}