<?php

namespace App\Service;

class StatusService
{
    public const STATUS_NULL = 100;
    public const STATUS_Success = 101;
    public const STATUS_ERROR = 102;

    private int $statusCode = self::STATUS_NULL;
    private ?string $statusTitle = null;
    private string $statusText = '';

    public static array $statusTitles = [
        100 => null,
        101 => 'Success',
        102 => 'Error'
    ];

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @param int $statusCode
     */
    public function setStatusCode(int $statusCode): void
    {
        $this->statusCode = $statusCode;
    }

    /**
     * @return string
     */
    public function getStatusTitle(): string
    {
        return $this->statusTitles;
    }

    /**
     * @param string $statusTitle
     */
    public function setStatusTitle(string $statusTitle): void
    {
        $this->statusTitle = $statusTitle;
    }

    /**
     * @return string
     */
    public function getStatusText(): string
    {
        return $this->statusText;
    }

    /**
     * @param string $statusText
     */
    public function setStatusText(string $statusText): void
    {
        $this->statusText = $statusText;
    }
}
