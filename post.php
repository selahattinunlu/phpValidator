<?php 

header('Content-type: text/html; charset=utf8');
include_once 'validator.php';

$input = $_POST;

$rules = array(
   'username' => 'required|ip',
   'email'    => 'required|email',
   'password' => 'required|numeric|confirm',
   'password_confirm' => 'required'
   );

$messages = array(
   'username.required' => 'Kullanıcı adı girmediniz',
   'username.ip'       => 'Bu bir ip değil! -hadi canım',
   'username.url'      => 'Bu bir url değil!',
   'username.min'      => 'Minimum 3 karakter olmalıdır.',
   'email.required'    => 'Email girmediniz.',
   'email.email'       => 'Lütfen geçerli bir email adresi giriniz.',
   'password.required' => 'Parola girmedin',
   'password.numeric'  => 'PArola sayılardan olşmalı!',
   'password.min'      => 'Parolanız minimum 3 karakterden oluşmalıdır.',
   'password.confirm'  => 'Girilen parolalar uyuşmuyor.',
   'password_confirm.required' => 'Parolanızı onaylayın!!'
   );


$validator = new Validator();
$validator->set($input, $rules, $messages);

var_dump($validator->errors);