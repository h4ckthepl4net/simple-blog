<?php

namespace ReactBlog\Backend\helpers;

class Validator
{
    public array $constraints = [];
    public array $data = [];

    public function __construct($constraints, $data)
    {
        $this->constraints = $constraints;
        $this->data = $data;
    }

    public function validate(): bool {
        $keys = array_keys($this->constraints);
        $keyCount = count($keys);
        for ($i = 0; $i < $keyCount; $i++) {
            $key = $keys[$i];
            $constraint = $this->constraints[$key];
            $value = $this->data[$key] ?? null;
            $constraint->check($value);
        }
        return true;
    }


}