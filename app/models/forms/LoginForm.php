<?php 

namespace app\models\forms;

use app\core\App;
use app\core\Form;
use app\core\Email;
use app\core\Session;


class LoginForm extends Form
{
    public function __construct()
    {
        $this->addField('login')->validators(['required']);
        $this->addField('password')->validators(['required']);

        $this->getValuesAndErrorsFromSession();

    }


}