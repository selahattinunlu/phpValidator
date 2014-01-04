<?php 

header('Content-type: text/html; charset=utf8');
include_once '../vendor/autoload.php';

$input = $_POST;

$rules = array(
   'username' => 'required|min:3|max:5',
   'email'    => 'required|email',
   'password' => 'required|numeric|confirm',
   'password_confirm' => 'required'
   );

$messages = array(
   'username.required' => 'Kullanıcı adı girmediniz',
   'username.ip'       => 'Bu bir ip değil! -hadi canım',
   'username.url'      => 'Bu bir url değil!',
   'username.age'      => 'Bu bir yaş değil lütfen sayı girin ve 18 den büyük olsun',
   'username.min'      => 'Minimum 3 karakter olmalıdır.',
   'username.max'      => 'Maximum 5 karakterden oluşmalıdır.',
   'email.required'    => 'Email girmediniz.',
   'email.email'       => 'Lütfen geçerli bir email adresi giriniz.',
   'password.required' => 'Parola girmedin',
   'password.numeric'  => 'PArola sayılardan olşmalı!',
   'password.min'      => 'Parolanız minimum 3 karakterden oluşmalıdır.',
   'password.confirm'  => 'Girilen parolalar uyuşmuyor.',
   'password_confirm.required' => 'Parolanızı onaylayın!!'
   );


$validator = new \phpValidator\Validator();

$validator->setSpecialRule('age', function($value) {

   return ($value < 18) ? false : true;

});

/*$validator->setSpecialRule('age', 'ageRule');

function ageRule($value) {

   return ($value < 18) ? false : true;

}*/

$validator->set($input, $rules, $messages);

//var_dump($validator->errors()->get('username'));

if ($validator->fails())
   var_dump($validator->errors()->all());
else
   echo 'Hata Yok!';