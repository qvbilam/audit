<?php
declare(strict_types=1);

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
     * 是否通过
     * @return bool
     */
    public function isPass(): bool
    {
        return  $this->status == StatusEnum::AUDIT_STATUS_PASS;
    }

    /**
     * 是否需要人工审核
     * @return bool
     */
    public function isReview(): bool
    {
        return $this->status == StatusEnum::AUDIT_STATUS_REVIEW;
    }

    /**
     * 是否拒绝
     * @return bool
     */
    public function isReject(): bool
    {
        return $this->status == StatusEnum::AUDIT_STATUS_REJECT;
    }

    /**
     * 获取请求id
     * @return string
     */
    public function getRequestId(): string
    {
        return $this->requestId;
    }

    /**
     * 设置请求id
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
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * 设置审核状态
     * @param string $status
     * @return TextResponse
     */
    public function setStatus(string $status): static
    {
        $this->status = $status;
        return $this;
    }

    /**
     * 获取描述
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * 设置描述
     * @param string $description
     * @return TextResponse
     */
    public function setDescription(string $description): static
    {
        $this->description = $description;
        return $this;
    }

    /**
     * 获取审核文本
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * 设置审核文本
     * @param string $text
     * @return TextResponse
     */
    public function setText(string $text): static
    {
        $this->text = $text;
        return $this;
    }

    /**
     * 获取风险类型
     * @return string
     */
    public function getRiskType(): string
    {
        return $this->riskType;
    }

    /**
     * 设置风险类型
     * @param string $riskType
     * @return TextResponse
     */
    public function setRiskType(string $riskType): static
    {
        $this->riskType = $riskType;
        return $this;
    }

    /**
     * 获取分数
     * @return int
     */
    public function getScore(): int
    {
        return $this->score;
    }

    /**
     * 设置分数
     * @param int $score
     * @return TextResponse
     */
    public function setScore(int $score): static
    {
        $this->score = $score;
        return $this;
    }
}