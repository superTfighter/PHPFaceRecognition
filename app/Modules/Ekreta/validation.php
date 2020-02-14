<?php

namespace App\Modules\HelloWorld;

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
            switch ($rule) {
                    // Test rule
                case 'test':

                    if ($method == 'POST') {
                        $v->key('input3', v::stringType()->length(1, 2), true);
                        $v->key('input2', v::noWhitespace()->notEmpty()->stringType()->length(1, 2));
                    }

                    break;

                    // test2 rule
                case 'test2':

                    $v->key('input3', v::stringType()->length(1, 2), true);
                    $v->key('input2', v::noWhitespace()->notEmpty()->stringType()->length(1, 2));

                    break;
            }

            return $v->assert($body);
        } catch (NestedValidationException $exception) {

            $exception->setParam('translator', 'gettext');
            $errors = $exception->findMessages(array_keys($body));

            return array_filter($errors);
        }
    }
}
