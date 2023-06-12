<?php

namespace App\Classes;

class Validator
{
    private $errors = [];
    private $request;
    
    public function __construct($request)
    {
        $this->request = $request;
    }
    public function validate($array)
    {
        foreach($array as $field=>$rules){
            if(in_array('optional',$rules) and !$this->request->{$field}->isFile())
                continue;
            foreach($rules as $rule){
                if($rule == 'optional') continue;
                if(str_contains($rule,':')){
                    $rule  = explode(':',$rule);
                    $ruleName = $rule[0];
                    $ruleValue = $rule[1];

                    if($error = $this->{$ruleName}($field,$ruleValue))
                    {
                        $this->errors[$field]= $error;
                        break;
                    }
                }else
                {
                    if($error = $this->{$rule}($field))
                    {
                        $this->errors[$field]= $error;
                        break;
                    }
                }
            }
        }
        return $this;
    }
    public function hasError()
    {
        return count($this->errors) ? true : false;
    }
    public function getErrors()
    {
        return $this->errors;
    }

    private function required($field)
    {
        if(is_null($this->request->get($field)))
            return "please fill $field";
        if(empty($this->request->get($field)))
            return "please fill $field";

        return false;
    }
    private function email($field)
    {
        if(!filter_var($this->request->{$field},FILTER_VALIDATE_EMAIL))
            return "`$field` is not valid";
        return false;
    }
    private function min($field,$value)
    {
        if(strlen($this->request->get($field))<$value)
            return "`$field` chars length is less than `$value`";

        return false;

    }
    private function max($field,$value)
    {
        if(strlen($this->request->get($field))>$value)
            return "`$field` chars length is more than `$value`";
        return false;

    }
    private function in($field,$items)
    {
        $items = explode(',',$items);

        if(!in_array($this->request->{$field},$items))
            return "selected $field is invalid";
        return false;
    }

    private function size($field,$len)
    {
        if($this->request->{$field}->getSize()> $len)
            return "$field is too large to upload.it must be smaller than $len";

        return false;
    }

    private function type($field,$types)
    {
        $types = explode(',',$types);
        if(!in_array($this->request->{$field}->getExtension(),$types))
            return "'$field' format is invalid.";
        return false;

    }
    private function file($field)
    {
        if(!$this->request->{$field} instanceof Upload)
           return "'$field' is not a file!";

        return false;
    }
}