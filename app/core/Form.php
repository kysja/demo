<?php 

namespace app\core;

class Form extends DbModel
{
    public array $fields = []; // [key => ['label' => label, 'validators' => ['required', 'min:3', 'max:50'], 'value' => value, errors => ['error1', 'error2'] ]

    protected function addField($key, $label=null)
    {
        $this->fields[$key] = [ 'label' => $label ?? ucfirst($key), 'validators' => [] ];

        return $this;
    }

    protected function default($value)
    {
        $key = array_key_last($this->fields);
        $this->fields[$key]['value'] = $value;

        return $this;
    }

    protected function validators($validators)
    {
        $key = array_key_last($this->fields);
        $this->fields[$key]['validators'] = $validators;

        return $this;
    }

    protected function sanitize($post)
    {
        foreach (array_keys($this->fields) as $key) {
            if (isset($post[$key]))
                $this->fields[$key]['value'] = htmlspecialchars(stripslashes(trim($post[$key]))) ?? null;
        }

        return true;
    }

    protected function validate()
    {
        $validation = new FormValidation();

        $isValid = true;
        foreach ($this->fields as $key => $field) {
            foreach ($field['validators'] as $validator) {
                $result = $validation->validate($this->fields[$key]['value'], $validator);
                if ($result !== true) {
                    $isValid = false;
                    $this->fields[$key]['errors'][] = $result;
                }
            }
        }

        return $isValid ? true : false;
    }

    protected function storeErrorsAndFields() 
    {
        $fieldsStore = array_map(function($f) { return ['value'=>$f['value'], 'errors'=>$f['errors']]; }, $this->fields);
        Session::set('formStored', $fieldsStore);
    }

    protected function prepareEmailBody()
    {
        $body = '';
        foreach ($this->fields as $key => $field) {
            $body .= '<p>' . $field['label'] . ':<br>' . nl2br($field['value']) . '</p>';
        }
        return $body;
    }

    protected function getValuesAndErrorsFromSession()
    {
        $formStored = Session::get('formStored');
        if ($formStored) {
            foreach (array_keys($this->fields) as $key) {
                $this->fields[$key]['value'] = $formStored[$key]['value'] ?? null;
                if (isset($formStored[$key]['errors'])) 
                    $this->fields[$key]['errors'] = implode("<br>", $formStored[$key]['errors']) ?? null;
            }
            Session::delete('formStored');
        }
    }

    public function csrfField()
    {
        $token = Session::get('csrf_token');
        if (!$token) {
            $token = base64_encode(random_bytes(32));
            Session::set('csrf_token', $token);
        }
        
        return '<input type="hidden" name="csrf_token" value="'.$token.'">';   
    }

    protected function csrfCheck($token)
    {
        if (!hash_equals(Session::get('csrf_token'), $token)) exit;
    }

    public function fieldsKeysValues()
    {
        return array_combine(array_keys($this->fields), array_column($this->fields, 'value'));
    }



}