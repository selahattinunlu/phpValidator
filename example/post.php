<?php 

header('Content-type: text/html; charset=utf8');
include_once '../vendor/autoload.php';

$input = $_POST;

$rules = array(
   'username' => 'required|min:5',
   'email'    => 'required|email',
   'password' => 'required|confirm',
   'password_confirm' => 'required',
   'age'      => 'required|between:16,24|numeric',
   'specialRule' => 'special'
   );

$messages = array(
   'username.required' => 'Kullanıcı adı girmediniz',
   'username.min'      => 'Minimum 5 karakter olmalıdır.',
   'email.required'    => 'Email girmediniz.',
   'email.email'       => 'Lütfen geçerli bir email adresi giriniz.',
   'password.required' => 'Parola girmedin',
   'password.confirm'  => 'Girilen parolalar uyuşmuyor.',
   'password_confirm.required' => 'Parolanızı onaylayın!!',
   'age.required'      => 'Yaşınızı belirtmelisiniz.',
   'age.between'       => 'Yaşınız 16 ve 24 arası olmalıdır.',
   'specialRule.special' => 'Girilen değer helloWorld değil!'
   );


$validator = new \phpValidator\Validator();

$validator->setSpecialRule('special', function($value) {

   return ($value != 'helloWorld') ? false : true;

});

$validator->set($input, $rules, $messages);

if ($validator->fails())
   var_dump($validator->errors()->all());