<?php

namespace App\Modules\Documentation;

use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\ExceptionInterface;
use Respect\Validation\Exceptions\ValidationException;
use Respect\Validation\Exceptions\NestedValidationException;

use App\Traits\CoreTrait;

class Validation
{
    use CoreTrait;

    public function validator($rule, $method, $body)
    {
        try {

            // Init
            $v = v::create();

            // Rules
            switch ($rule)
            {
                // form test
                case 'formTest':

                    if ($method == 'POST') {
                        $v->key('numeric',  v::notEmpty()   ->numeric()     ->setName('szám mező'));
                        $v->key('email',    v::notEmpty()   ->email()       ->setName('email cím'));
                        $v->key('select1',  v::notEmpty()                   ->setName('legördülő mező'));
                    }

                break;

            }

            return $v->assert($body);

        } catch(NestedValidationException $exception) {
            
            $exception->setParam('translator', 'gettext');
            $errors = $exception->findMessages(array_keys($body));

            return array_filter($errors);
        }
    }
}
