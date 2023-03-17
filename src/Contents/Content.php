<?php
declare(strict_types=1);

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
     * @return string The content type of the response.
     */
    public function getContentType(): string
    {
        return $this->contentType;
    }


    /**
     * > Sets the content type of the response
     *
     * @param string contentType The content type of the response.
     *
     * @return ContentInterface The object itself.
     */
    public function setContentType(string $contentType): ContentInterface
    {
        $this->contentType = $contentType;
        return $this;
    }


    /**
     * Set the content type to text.
     *
     * @return ContentInterface The object itself.
     */
    public function setContentTypeText(): ContentInterface
    {
        $this->setContentType(self::TYPE_TEXT);
        return $this;
    }


    /**
     * Set the content type to image.
     *
     * @return ContentInterface The object itself.
     */
    public function setContentTypeImage(): ContentInterface
    {
        $this->setContentType(self::TYPE_IMAGE);
        return $this;
    }


    /**
     * > This function returns the content of the article
     *
     * @return string The content of the article.
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * > Sets the content of the page
     *
     * @param string content The content of the page.
     *
     * @return ContentInterface The object itself.
     */
    public function setContent($content): ContentInterface
    {
        $this->content = $content;
        return $this;
    }
}