<?php

namespace phpValidator;

class Error {

   public $errors;

   public function __construct($errors)
   {
      
      $this->errors = $errors;

   }

   public function all()
   {
      
      return $this->errors;

   }

   public function get($inputKey)
   {
      
      return $this->errors[$inputKey];

   }

   public function first()
   {
      
      if ($this->errors):
      
         $errorValues = array_values($this->errors);
         return $errorValues[0];

      endif;

   }

}