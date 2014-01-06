phpValidator
============

Php için oluşturulmuş form doğrulama sınıfı.

### Composer İle Kurulum

composer.json dosyasında, require içerisine 

```
"selahattinunlu/php-validator": "dev-master"
```
satırını eklemelisiniz.

Yani son hali şu şekilde olmalıdır:

```
{
    "require": {
        "selahattinunlu/php-validator": "dev-master"
    },
    "minimum-stability": "dev"

}
```

Ardından terminale ```composer install``` komutunu girin.

Böylece gerekli dosyalar projenize dahil edilecektir.

Son olarak projenizin kök klasörü içerisinde otomatik oluşturulan vendor klasöründeki autoload.php 'yi projenize include etmelisiniz. Daha önce composer kullanmadıysanız [buradan](http://getcomposer.org) composer kullanımı hakkında detaylı bilgiye ulaşabilirsiniz.

### phpValidator Kullanımı
