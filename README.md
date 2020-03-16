Manajemen Penggiat Budaya
============================

Instalasi:
-------------

### Install Composer

Download composer dan install di sistem operasi yang sesuai, bisa di baca di [getcomposer.org](http://getcomposer.org/doc/00-intro.md#installation-nix).

### Install plugin bila belum ada
~~~
php composer.phar global require "fxp/composer-asset-plugin:^1.2.0"
~~~

Kloning aplikasi dari gitlab:

1. git clone https://sangbima@gitlab.com/sangbima/manajemen-penggiat.git
2. cd manajemen-penggiat
3. composer update
4. Install nodejs di server
5. Install bower
   npm install -g bower
6. Install template
   bower install gentelella --save

7. Arahkan virtualhost ke folder /manahemen-penggiat/web/

~~~
http://namadomain/
~~~

CONFIGURATION
-------------

### Database

Edit file `config/db.php` untuk konfigurasi database, contoh:

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=manajemen',
    'username' => 'root',
    'password' => '1234',
    'charset' => 'utf8',
];
```

MIGRASI
-------
1. Arahkan console ke folder instalasi
2. Jalankan perintah migrate
    ```php
    $./yii migrate/up
    ```
3. Jalankan perintah migrate untuk migrasi rbac
    ```php
    $./yii migrate --migrationPath=@mdm/admin/migrations
    $./yii migrate --migrationPath=@yii/rbac/migrations
    ```