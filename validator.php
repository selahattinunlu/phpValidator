<?php 

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

      return (method_exists('Validator', $method))
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
            return $this->setError($inputKey, $method);
         endif;

      else:
        
         if ( ! call_user_func($method, $this->input[$inputKey])):
            return $this->setError($inputKey, $method);
         endif;

      endif;

   }

   public function setError($inputKey, $errorKey)
   {
      
      $this->errors[$inputKey] = $this->messages[$inputKey . '.' . $errorKey];

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

   public function min($value = '')
   {

      # code...
      
   }

   public function max($value = '')
   {

      # code...
   
   }

   public function beetween($value = '')
   {

      # code...
   
   }

}