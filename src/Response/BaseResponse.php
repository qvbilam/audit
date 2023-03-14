<?php

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

trait BaseResponse
{
    /**
     * 请求id.
     *
     * @var string
     */
    public $requestId;

    /**
     * 审核内容.
     *
     * @var string
     */
    public $content;

    /**
     * 状态
     *
     * @var string
     */
    public $status;

    /**
     * 描述.
     *
     * @var string
     */
    public $description;

    /**
     * 风险等级.
     *
     * @var string
     */
    public $riskType;

    /**
     * 危险分数: 0~100.
     *
     * @var int
     */
    public $score;

    /**
     * 是否通过.
     *
     * @return bool
     */
    public function isPass()
    {
        return StatusEnum::AUDIT_STATUS_PASS == $this->status;
    }

    /**
     * 是否需要人工审核.
     *
     * @return bool
     */
    public function isReview()
    {
        return StatusEnum::AUDIT_STATUS_REVIEW == $this->status;
    }

    /**
     * 是否拒绝.
     *
     * @return bool
     */
    public function isReject()
    {
        return StatusEnum::AUDIT_STATUS_REJECT == $this->status;
    }

    /**
     * 获取请求id.
     *
     * @return string
     */
    public function getRequestId()
    {
        return $this->requestId;
    }

    /**
     * 设置请求id.
     *
     * @param string $requestId
     *
     * @return BaseResponse
     */
    public function setRequestId($requestId)
    {
        $this->requestId = $requestId;

        return $this;
    }

    /**
     * 获取审核状态
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * 设置审核状态
     *
     * @param string $status
     *
     * @return BaseResponse
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * 获取描述.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * 设置描述.
     *
     * @param string $description
     *
     * @return BaseResponse
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * 获取风险类型.
     *
     * @return string
     */
    public function getRiskType()
    {
        return $this->riskType;
    }

    /**
     * 设置风险类型.
     *
     * @param string $riskType
     *
     * @return BaseResponse
     */
    public function setRiskType($riskType)
    {
        $this->riskType = $riskType;

        return $this;
    }

    /**
     * 获取分数.
     *
     * @return int
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * 设置分数.
     *
     * @param int $score
     *
     * @return BaseResponse
     */
    public function setScore($score)
    {
        $this->score = $score;

        return $this;
    }

    /**
     * 获取审核内容.
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * 设置审核内容.
     *
     * @param string $text
     *
     * @return BaseResponse
     */
    public function setContent($text)
    {
        $this->text = $text;

        return $this;
    }
}
