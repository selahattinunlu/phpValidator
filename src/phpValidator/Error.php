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
      
      return $this->errors[0];

   }

}