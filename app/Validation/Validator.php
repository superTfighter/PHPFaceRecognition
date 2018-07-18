<?php

namespace App\Validation;

use App\Traits\CoreTrait;

use Violin\Violin;

class Validator extends Violin
{
    use CoreTrait;

    public function __construct($container)
    {
        // Query and Body variables
        $this->getQueryParams = $container->get('request')->getQueryParams();
        $this->getParsedBody = $container->get('request')->getParsedBody();

        // Custom validators    
        $this->addFieldMessages([
            'fields' => [
                'commaSeparated' => 'fields format is not valid (comma separated)'
            ],
        ]);

        /// Not valid parameter
        $this->addRuleMessage('notValidParameter', '{field} is not valid');
        $this->addRule('notValidParameter', function($value, $input, $args) {
            return false;
        });

        /// User defined json check
        $this->addRuleMessage('json', '{field} is not valid json');
        $this->addRule('json', function($value, $input, $args) {
            json_decode($value);
            return (json_last_error() == JSON_ERROR_NONE);
        });

        /// User defined string check
        $this->addRuleMessage('string', '{field} is not string');
        $this->addRule('string', function($value, $input, $args) {
            ///return is_string($value);
            return (is_string($value) && ($value == strip_tags($value))); // if string and not contains html character
        });

        /// Enum 
        $this->addRuleMessage('enum', '{field} is not valid enum');
        $this->addRule('enum', function($value, $input, $args) {

            if ($value)
            {
                foreach ($args as &$item) {
                    $item = str_replace('<SP>', ' ', $item);  // <SP> convert space
                    $item = str_replace('<PR>', '(', $item);  // <PR> convert "("
                    $item = str_replace('</PR>', ')', $item); // </PR> convert ")"
                }
            }

            return $value?in_array($value, $args):true;
        });

        /// Embed
        $this->addRuleMessage('embed', '{field} is not valid embed');
        $this->addRule('embed', function($value, $input, $args) {

            $value = array_filter(explode(",", $value));

            return (bool) !array_diff($value, $args);
        });


        /// Json data validation
        $this->addRuleMessage('jsonProvisionData', '{field} is not valid element in json');
        $this->addRule('jsonProvisionData', function($value, $input, $args) {

            if ($value)
            {
                $elements = json_decode($value, true);

                // Valid keys
                $validKeys = ['name',
                              'job',
                              'section',
                              'location',
                              'entry_date'];

                // Need all key match
                if ($this->array_keys_exist($elements, $validKeys) == false)
                {
                    return false;
                }

                return true;
            }

            return false;
        });


    }

    public function array_keys_exist(array $array, $keys)
    {
        $count = 0;

        if ( ! is_array( $keys ) )
        {
            $keys = func_get_args();
            array_shift( $keys );
        }

        foreach ( $keys as $key )
        {
            if ( isset( $array[$key] ) || $this->array_key_exists( $key, $array ) )
            {
                $count ++;
            }
        }

        return count( $keys ) === $count;
    }


    public function error()
    {
        $messages = array();
        
        $keys   = $this->errors()->keys();
        $errors = $this->errors()->all();

        if (count($keys) == count($errors)) {
            $messages = array_combine($keys, $errors);
        } else {
            $messages = $this->errors()->all();
        }

        return array('error' => array('message' => $messages ));
    }

    // QUERY filters
    public function queryParamsValidator($route)
    {
        $queryFilterParams = array();
        $queryParams = $this->getQueryParams;

        /// Default valid filters
        if (isset($queryParams['test']) && !is_null($queryParams['test'])) {
            $queryFilterParams['test'] = [$queryParams['test'], 'commaSeparated']; }

        switch ($route) 
        {
            // User validation rules
            case 'test':

                if (isset($queryParams['test2']) && !is_null($queryParams['test2'])) {
                    $queryFilterParams['test2'] = [$queryParams['test2'], 'enum(name)']; }

                break;
        }

        /// If parameter is not defined validator
        if ($queryParams)
        {
            foreach ($queryParams as $key => $value) 
            {
                if (!array_key_exists($key, $queryFilterParams)) {
                    $queryFilterParams[$key] = [$queryParams[$key], 'notValidParameter'];
                }
            }
        }

        return $queryFilterParams;
    }

    // POST, PUT formData parameters
    public function bodyParamsValidator($method, $route, $args = array(), $unset = array())
    {
        $bodyFilterParams = array();
        $bodyParams = $this->getParsedBody;

        if ($args) {
            $bodyParams += $args;
        }

        if ($unset) {
            foreach ($unset as $key) {
                unset($bodyParams[$key]);
            }
        }

        switch ($route) {
            case 'test':

            if ($method == 'POST') {
                $bodyFilterParams['eppn'] = [$bodyParams['eppn'], 'required|min(3)|max(128)|email'];
            }

            if ($method == 'PUT') {
                /// PUT OPTIONAL
                if (isset($bodyParams['eppn']) && !is_null($bodyParams['eppn'])) {
                    $bodyFilterParams['eppn'] = [$bodyParams['eppn'], 'min(3)|max(128)|email']; }
            }

                break;
        }

        /// If parameter is not defined validator
        foreach ($bodyParams as $key => $value) 
        {
            if (!array_key_exists($key, $bodyFilterParams)) {
                $bodyFilterParams[$key] = [$bodyParams[$key], 'notValidParameter'];
            }
        }

        return $bodyFilterParams;
    }

    public function validate_commaSeparated($value, $input, $args)
    {
        return (bool) !preg_match('~^([a-z0-9]+,)+$~i', $value);
    }

}
