phpValidator
============

Php için oluşturulmuş form doğrulama sınıfı.

### Composer İle Kurulum

composer.json dosyasında, require içerisine şu satırı ekleyin:

```
"selahattinunlu/php-validator": "dev-master"
```

Yani son hali şu şekilde olmalıdır:

```
{
    "require": {
        "selahattinunlu/php-validator": "dev-master"
    },
    "minimum-stability": "dev"

}
```

Ardından terminale, daha önce kurulum yapmadıysanız ```composer install``` kurulum yaptıysanız ```composer update``` komutunu girin.

Böylece gerekli dosyalar projenize dahil edilecektir.

[Composer hakkında daha detaylı bilgi için tıklayın.](http://getcomposer.org)

### Kullanımı

HTML Form
```html
<form method="POST" action="post.php">
   <input type="text" name="username" placeholder="Username" />
   <input type="text" name="email" placeholder="Email" />
   <input type="text" name="age" placeholder="Age" />
   <input type="password" name="password" placeholder="Password" />
   <input type="password" name="password_confirm" placeholder="Password Confirm" />
   <button type="submit">Gönder</button>
</form>
```

post.php
```php
$validator = new \phpValidator\Validator();

$validator->set($input, array(
   'username' => 'required|min:5|max:10',
   'email'    => 'required|email',
   'age'      => 'required|between:18,30',
   'password' => 'required|confirm',
   'password_confirm' => 'required'
   ), array(
   'username.required'  => 'Kullanıcı adı girmedin!',
   'username.min'       => 'Kullanıcı adı minimum 5 karakterden oluşmalıdır.',
   'username.max'       => 'Kullanıcı adı maximum 10 karakterden oluşmalıdır.',
   'email.required'     => 'Email girmedin',
   'email.email'        => 'Lütfen geçerli bir email adresi giriniz.',
   'age.between'        => 'Yaşınız 18 ile 30 arasında olmalıdır',
   'password.confirm'   => 'Girilen parolalar eşleşmiyor!'
   ));

if ($validator->fails())
   var_dump($validator->errors()->all());
```

### Tanımlı Kurallar
* required : doldurulması zorunlu
* email    : email formatı
* url      : adres formatı (http://www.adres.com)
* ip       : ip kontrolü
* numeric  : sayısal değer kontrolü
* min      : girilen değerin minimum kaç karakter olacağını kontrol eder
* max      : girilen değerin maximum kaç karakter olacağını kontrol eder
* between  : girilen değerin hangi sayılar arası olacagını kontrol eder
* confirm  : iki değerin eşleşip eşleşmediğini kontrol eder.

### Hata Varlığını Kontrol Etmek
Tanımlanan kuralların aksi bir durum gerçekleştiğinde bunu yakalamk için ```fails()``` methodu kullanılır.

```php
if ($validator->fails())
    return 'hata var!';
else
    return 'hata yok!';
```

### Hata Mesajları 

* Hata mesajlarının hepsine ulaşmak için 

```php
$validator->errors()->all();
```

* Oluşan hata mesajlarından ilkine ulaşmak için

```php
$validator->errors()->first();
```

* Belli bir hata mesajına ulaşmak için

```php
$validator->errors()->get('username');
```

### Özel Kural Tanımlamak

Bunun için ``` setRule($kuralAdi, $fonksiyon) ``` methodu kullanılır

Örnek:

```php
$validator->setRule('sehir', function($value) {
    return ($value != 'istanbul') ? false : true;
});
```

Sonucun false olarak dönmesiyle, tanımladığınız mesaj hata mesajlarına eklenir.

```php

$validator = new \phpValidator\Validator();

$validator->setRule('ozelKuralAdi', function($value) {
    return ($value != 'istanbul') ? false : true;
});

$validator->set($input, array(
    'input' => 'ozelKuralAdi'
), array(
    'input.ozelKuralAdi' => 'Kuralınızın hata mesajı!'
));

if ($validator->fails())
    die(json_encode(array('error' => $validator->errors()->first())));
```

#### Dilerseniz özel kuralı şu şekilde tanımlayabilirsiniz:

```php
function fonksiyonAdi ($value) {
    return ($value != 'istanbul') ? false : true;
}

$validator->setRule('ozelKuralAdi', 'fonksiyonAdi');
```
