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

namespace Qvbilam\Audit\Response;

use Qvbilam\Audit\Enum\StatusEnum;

class TextResponse extends Response
{
    public string $requestId; // 请求id
    public string $status; // 状态
    public string $description; // 描述
    public string $text; // 审核文本
    public string $riskType; // 风险类型
    public int $score; // 危险分数:0~100

    /**
     * 是否通过.
     */
    public function isPass(): bool
    {
        return StatusEnum::AUDIT_STATUS_PASS == $this->status;
    }

    /**
     * 是否需要人工审核.
     */
    public function isReview(): bool
    {
        return StatusEnum::AUDIT_STATUS_REVIEW == $this->status;
    }

    /**
     * 是否拒绝.
     */
    public function isReject(): bool
    {
        return StatusEnum::AUDIT_STATUS_REJECT == $this->status;
    }

    /**
     * 获取请求id.
     */
    public function getRequestId(): string
    {
        return $this->requestId;
    }

    /**
     * 设置请求id.
     *
     * @param string $requestId
     * @return TextResponse
     */
    public function setRequestId(string $requestId): static
    {
        $this->requestId = $requestId;

        return $this;
    }

    /**
     * 获取审核状态
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * 设置审核状态
     *
     * @param string $status
     * @return TextResponse
     */
    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    /**
     * 获取描述.
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * 设置描述.
     *
     * @param string $description
     * @return TextResponse
     */
    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * 获取审核文本.
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * 设置审核文本.
     *
     * @param string $text
     * @return TextResponse
     */
    public function setText(string $text): static
    {
        $this->text = $text;

        return $this;
    }

    /**
     * 获取风险类型.
     */
    public function getRiskType(): string
    {
        return $this->riskType;
    }

    /**
     * 设置风险类型.
     *
     * @param string $riskType
     * @return TextResponse
     */
    public function setRiskType(string $riskType): static
    {
        $this->riskType = $riskType;

        return $this;
    }

    /**
     * 获取分数.
     */
    public function getScore(): int
    {
        return $this->score;
    }

    /**
     * 设置分数.
     *
     * @param int $score
     * @return TextResponse
     */
    public function setScore(int $score): static
    {
        $this->score = $score;

        return $this;
    }
}
