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

namespace Qvbilam\Audit\Contents;

use Qvbilam\Audit\Contracts\ContentInterface;

abstract class Content implements ContentInterface
{
    /**
     * @var string
     */
    protected $content;

    /**
     * @var string
     */
    protected $contentType;

    /**
     * It returns the content type of the response.
     *
     * @return string the content type of the response
     */
    public function getContentType(): string
    {
        return $this->contentType;
    }

    /**
     * > Sets the content type of the response.
     *
     * @param string contentType The content type of the response
     *
     * @return ContentInterface the object itself
     */
    public function setContentType(string $contentType): ContentInterface
    {
        $this->contentType = $contentType;

        return $this;
    }

    /**
     * Set the content type to text.
     *
     * @return ContentInterface the object itself
     */
    public function setContentTypeText(): ContentInterface
    {
        $this->setContentType(self::TYPE_TEXT);

        return $this;
    }

    /**
     * Set the content type to image.
     *
     * @return ContentInterface the object itself
     */
    public function setContentTypeImage(): ContentInterface
    {
        $this->setContentType(self::TYPE_IMAGE);

        return $this;
    }

    /**
     * > This function returns the content of the article.
     *
     * @return string the content of the article
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * > Sets the content of the page.
     *
     * @param string content The content of the page
     *
     * @return ContentInterface the object itself
     */
    public function setContent($content): ContentInterface
    {
        $this->content = $content;

        return $this;
    }
}
