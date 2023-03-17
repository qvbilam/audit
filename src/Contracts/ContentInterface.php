<?php
declare(strict_types=1);
namespace Qvbilam\Audit\Contracts;

interface ContentInterface
{
    const TYPE_TEXT = "text";
    const TYPE_IMAGE = "image";

    public function getContentType(): string;
    public function getContent(): string;
}