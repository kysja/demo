<?php 

namespace app\core;

class FormValidation
{
    public $isValid = true;

    public function validate($value, $rule)
    {
        $rule = explode(':', $rule);
        $method = $rule[0];
        $param = $rule[1] ?? null;
        return $this->$method($value, $param);
    }

    protected function required($value)
    {
        if (empty($value)) {
            return 'This field is required';
        }
        return true;
    }

    protected function email($value)
    {
        if (!empty($value) && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return 'This field must be a valid email';
        }
        return true;
    }

    protected function min($value, $param)
    {
        if (strlen($value) < $param) {
            return 'This field must be at least ' . $param . ' characters';
        }
        return true;
    }

    protected function max($value, $param)
    {
        if (strlen($value) > $param) {
            return 'This field must be at least ' . $param . ' characters';
        }
        return true;
    }

}

