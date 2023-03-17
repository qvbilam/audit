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

use Qvbilam\Audit\Contracts\ContentInterface;

class Content implements ContentInterface
{
    protected $content;
    protected $contentType;

    public function getContentType(): string
    {
        return $this->contentType;
    }

    public function setContentType($contentType): ContentInterface
    {
        $this->contentType = $contentType;

        return $this;
    }

    public function setContentTypeText(): ContentInterface
    {
        $this->setContentType(self::TYPE_TEXT);

        return $this;
    }

    public function setContentTypeImage(): ContentInterface
    {
        $this->setContentType(self::TYPE_IMAGE);

        return $this;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent($content): ContentInterface
    {
        $this->content = $content;

        return $this;
    }
}
