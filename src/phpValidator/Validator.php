<?php

namespace phpValidator;

class Validator {

   public $input;
   public $rules;
   public $specialRules = array();
   public $messages;
   public $errors = array();

   public $filter = array(
      'ip'    => FILTER_VALIDATE_IP,
      'url'   => FILTER_VALIDATE_URL,
      'email' => FILTER_VALIDATE_EMAIL
      );

   public $regex = array(
      'find'    => array('/:/', '/[0-9]/', '/,/'),
      'replace' => array('', '', '')
      );

   public function set($input, $rules, $messages)
   {

      $this->input    = $input;
      $this->rules    = $rules;
      $this->messages = $messages;
      $this->errors   = null;

      foreach ($rules as $ruleKey => $ruleValue):

         $inputKey = $ruleKey;
         $ruleValue .= '|';
         $splitRuleValue = array_filter(explode('|', $ruleValue));

         foreach ($splitRuleValue as $rule):

            if (preg_match('/:/', $rule))
               $rule = preg_filter($this->regex['find'], $this->regex['replace'], $rule);

            if ( ! isset($this->errors[$inputKey])):

               $method = (isset($this->filter[$rule])) ? 'filterValidate' : $rule;

               $controlType = $this->chooseControlType($method);

               $this->$controlType($method, $inputKey, $rule);

            endif;

         endforeach;

      endforeach;

   }

   public function setSpecialRule($ruleName, $function)
   {
      
      $this->specialRules[$ruleName] = $function;

   }

   public function chooseControlType($method)
   {

      return (method_exists('phpValidator\Validator', $method))
         ? 'control'
         : 'specialControl';
      
   }

   # Controls

   public function control($method, $inputKey, $rule)
   {
      
      if ( ! $this->$method($inputKey, $rule))
         $this->setError($inputKey, $rule);

   }

   public function specialControl($method, $inputKey)
   {
      
      if (is_callable($this->specialRules[$method])):

         if ( ! $this->specialRules[$method]($this->input[$inputKey])):
            $this->setError($inputKey, $method);
         endif;

      else:
        
         if ( ! call_user_func($method, $this->input[$inputKey])):
            $this->setError($inputKey, $method);
         endif;

      endif;

   }

   public function fails()
   {

      return $this->errors;

   }

   # Errors

   public function setError($inputKey, $errorKey)
   {
      
      $this->errors[$inputKey] = $this->messages[$inputKey . '.' . $errorKey];

   }

   public function errors()
   {

      include_once 'Error.php';
      return new \phpValidator\Error($this->errors);

   }

   # Rules
   
   public function filterValidate($inputKey, $rule)
   {
     
      return ( ! filter_var($this->input[$inputKey], $this->filter[$rule]))
         ? false
         : true;

   }

   public function required($inputKey)
   {

      return ($this->input[$inputKey] == '') ? false : true;
         
   }

   public function numeric($inputKey)
   {  

      return ( ! is_numeric($this->input[$inputKey])) ? false : true;

   }

   public function confirm($inputKey)
   {
      
      return ($this->input[$inputKey] != $this->input[$inputKey . '_confirm'])
         ? false
         : true;

   }

   public function min($inputKey)
   {

      $this->rules[$inputKey] .= '|';

      $split = explode('min:', $this->rules[$inputKey]);
      $limit = explode('|', $split[1]);

      return (strlen($this->input[$inputKey]) < $limit[0]) ? false : true;

   }

   public function max($inputKey)
   {

      $this->rules[$inputKey] .= '|';
      
      $split = explode('max:', $this->rules[$inputKey]);
      $limit = explode('|', $split[1]);

      return (strlen($this->input[$inputKey]) > $limit[0]) ? false : true;
   
   }

   public function between($inputKey)
   {

      $this->rules[$inputKey] .= '|';
      
      $split = explode('between:', $this->rules[$inputKey]);
      $limit = explode('|', $split[1]);
      $values = explode(',', $limit[0]);

      return ($this->input[$inputKey] < $values[0] || $this->input[$inputKey] > $values[1]) 
         ? false 
         : true;
   
   }

}