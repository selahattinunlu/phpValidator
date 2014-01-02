<?php 

class Validator {

   public $input;
   public $rules;
   public $messages;
   public $errors = array();

   public function init($input, $rules, $messages)
   {

      $this->input = $input;

      $this->rules = $rules;

      $this->messages = $messages;

      $this->errors = null;

   }

   public function set($input, $rules, $messages)
   {

      $this->init($input, $rules, $messages);

      foreach ($rules as $ruleKey => $ruleValue):

         $inputKey = $ruleKey;
         $ruleValue .= '|';
         $splitRuleValue = array_filter(explode('|', $ruleValue));

         foreach ($splitRuleValue as $rule)
            if ( ! isset($this->errors[$inputKey]) && ! $this->$rule($inputKey))
               $this->setError($inputKey, $rule);

      endforeach;

   }

   public function setError($inputKey, $errorKey)
   {
      
      $this->errors[$inputKey] = $this->messages[$inputKey . '.' . $errorKey];

   }

   # Rules

   public function email($inputKey)
   {

      return ( ! filter_var($this->input[$inputKey], FILTER_VALIDATE_EMAIL))
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

}