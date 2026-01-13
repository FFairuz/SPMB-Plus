<?php

namespace App\DTOs;

/**
 * Base DTO Class
 * 
 * Base class untuk Data Transfer Objects
 */
abstract class BaseDTO
{
    /**
     * Convert DTO to array
     * 
     * @return array
     */
    public function toArray(): array
    {
        $result = [];
        
        foreach (get_object_vars($this) as $key => $value) {
            if ($value !== null) {
                $result[$key] = $value;
            }
        }

        return $result;
    }

    /**
     * Create DTO from array
     * 
     * @param array $data Input data
     * @return static
     */
    public static function fromArray(array $data): self
    {
        $dto = new static();
        
        foreach ($data as $key => $value) {
            if (property_exists($dto, $key)) {
                $dto->$key = $value;
            }
        }

        return $dto;
    }

    /**
     * Validate DTO data
     * 
     * @return array Empty array if valid, array of errors if invalid
     */
    abstract public function validate(): array;
}
