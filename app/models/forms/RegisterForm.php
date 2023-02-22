<?php 

namespace app\models\forms;

use app\core\App;
use app\core\Form;
use app\core\Email;
use app\core\Session;


class RegisterForm extends Form
{
    public function __construct()
    {
        $this->addField('name')->validators(['required', 'min:3', 'max:50']);
        $this->addField('email')->validators(['required', 'email']);
        $this->addField('password')->validators(['required', 'min:6', 'max:50']);
        $this->addField('dttm_created')->default(date('Y-m-d H:i:s'));

        $this->getValuesAndErrorsFromSession();

    }

    public function process($post)
    {
        $this->csrfCheck($post['csrf_token']);
        $this->sanitize($post);
        if ($this->validate() === false) {
            $this->storeErrorsAndFields();
            return false;
        }

        $this->fields['password']['value'] = password_hash($this->fields['password']['value'], PASSWORD_DEFAULT);

        $this->insert('users', $this->fieldsKeysValues());

        return true;
    }


}