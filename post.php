<?php 

header('Content-type: text/html; charset=utf8');
include_once 'validator.php';

$input = $_POST;

$rules = array(
   'username' => 'required',
   'email'    => 'required|email',
   'password' => 'required|numeric|min:3'
   );

$messages = array(
   'username.required' => 'Kullanıcı adı girmediniz',
   'email.required'    => 'Email girmediniz.',
   'email.email'       => 'Lütfen geçerli bir email adresi giriniz.',
   'password.required' => 'Parola girmedin',
   'password.numeric'  => 'PArola sayılardan olşmalı!',
   'password.min'      => 'Parolanız minimum 3 karakterden oluşmalıdır.'
   );


$validator = new Validator();
$validator->set($input, $rules, $messages);

xdebug_var_dump($validator->errors);