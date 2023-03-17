<?php
declare(strict_types=1);

namespace Qvbilam\Audit\Contracts;

use Qvbilam\Audit\Response\Response;

interface GatewayInterface
{
    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @param ContentInterface $content
     * @return Response
     */
    public function text(ContentInterface $content) : Response;

    /**
     * @param ContentInterface $content
     * @return Response
     */
    public function image(ContentInterface $content): Response;
}