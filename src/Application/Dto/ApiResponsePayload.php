<?php
declare(strict_types=1);

namespace App\Application\Dto;
use JsonSerializable;

class ApiResponsePayload implements JsonSerializable
{

    /**
     * @var bool
     */
    private $status;

    /**
     * @var array|null
     */
    private $data;

    /**
     * @var int
     */
    private $errorMsg;

    /**
     * @var array|null
     */
    private $errors;


    /**
     * ApiResponsePayload constructor.
     * @param bool $isOk
     * @param array $data
     * @param int $errorMsg
     * @param array|null $errors
     */
    public function __construct(bool $isOk, int $errorMsg = 0, ?array $errors  = null, ?array $data  = null)
    {
        $this->status = $isOk;
        $this->data = $data;
        $this->errors = $errors;
        $this->errorMsg = $errorMsg;
    }


    /**
     * @return bool
     */
    public function getStatus(): bool
    {
        return $this->status;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @return array|null
     */
    public function getErrors(): ?array
    {
        return $this->errors;
    }

    /**
     * @return int|null
     */
    public function getErrorMsg(): ?int
    {
        return $this->errorMsg;
    }



    public function jsonSerialize()
    {
        return [
            'status' => intval($this->status),
            'payload' => $this->data,
            'error' => [
                'code' => intval($this->errorMsg),
                'errors' => $this->errors,
            ],
        ];
    }


}

