<?php

namespace app\controllers;

use app\core\View;
use app\core\Router;
use app\models\Person;

class PersonController
{
    public static function index() : string
    {
        if (Person::isEmptyDb() === true) {
            return View::render('person/dbempty', $data=[]);
        }
        $data['qs'] = qs(); unset($data['qs']['page']);
        $data['persons'] = Person::getList();
        $data['states'] = Person::getStates();

        return View::render('person/index', $data);
    }

}