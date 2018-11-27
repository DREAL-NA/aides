
# DREAL - Des dispositifs pour les territoires de la Nouvelle-Aquitaine  

Une base de données sur les aides aux territoires ouverte à tous  

## Commencer  

Ces instructions vous fourniront une copie du projet opérationnel sur votre ordinateur local à des fins de développement et de test. Voir la partie déploiement pour des notes sur la façon de déployer le projet sur un système actif.  

### Pré-requis  

- Composer
- NPM / Yarn

- Dépendances Laravel ([https://laravel.com/docs/5.7/installation](https://laravel.com/docs/5.7/installation))
```
PHP >= 7.1.3  
OpenSSL PHP Extension  
PDO PHP Extension  
Mbstring PHP Extension  
Tokenizer PHP Extension  
XML PHP Extension  
Ctype PHP Extension  
JSON PHP Extension
```  

- Dépendance DomPDF ([https://github.com/dompdf/dompdf](https://github.com/dompdf/dompdf))
```
PHP version 5.4.0 or higher
DOM extension
GD extension
MBString extension
php-font-lib
php-svg-lib
```

- Dépendances PhpSpreadsheet ([https://phpspreadsheet.readthedocs.io/en/develop/#software-requirements](https://phpspreadsheet.readthedocs.io/en/develop/#software-requirements))
```
PHP version 5.6 or newer
PHP extension php_zip enabled
PHP extension php_xml enabled
PHP extension php_gd2 enabled (if not compiled in)
```

- Dépendances Laravel Backup ([https://docs.spatie.be/laravel-backup/v5/requirements](https://docs.spatie.be/laravel-backup/v5/requirements))

- Dépendances Laravel Medialibrary ([https://docs.spatie.be/laravel-medialibrary/v7/requirements#requirements](https://docs.spatie.be/laravel-medialibrary/v7/requirements#requirements))


### Installation

Cloner le dépôt distant

```  
git clone URL_DU_DEPOT_DISTANT
```  

Créer une base de données de dev et de test

```
echo "create database dreal" | mysql -u <USERNAME> -p
echo "create database dreal_test" | mysql -u <USERNAME> -p
```

Copier le fichier d'environnement `.env.example` et renseigner au minium les vairables suivantes dans le fichier `.env` afin de pouvoir développer en local :

- APP_URL
- APP_DOMAIN
- DB_DATABASE
- DB_USERNAME
- DB_PASSWORD

```
cd /le/chemin/du/projet
cp .env.example .env
```

Installer les dépendances, générer une clé d'application et migrer la base de données

```
composer install
php artisan key:generate
php artisan migrate
php artisan scout:import
```

Vous pouvez lancer les différents seeder, par example pour créer un utilisateur :
```
php artisan db:seed
```

Cela va créer un utilisateur `john@example.com` avec comme mot de passe `password`.

Vous êtes maintenant prêt à travailler !

### Lancer le server

```
php artisan serve
```

### Backoffice

Pour se connecter au backoffice, l'url par défaut est `bko.<APP_DOMAIN>`. Pensez donc à bien reseigner `APP_DOMAIN` dans le fichier `.env`.
L'authentification est email/password.
Si vous n'arrivez pas à vous connecter, utilisez la fonction de mot de passe oublié, il faut donc penser à paramétrer la partie mail dans le `.env`.
Pour cela il faut créer un compte sur [https://mailtrap.io](https://mailtrap.io).
Ensuite il faut se rendre sur Mailtrap et cliquer sur la boite de démo créee par défaut afin d'accéder à ses éléments de configuration.

### Compiler les assets
Laravel Mix est utilisé pour compiler les assets.

Se référer à la documentation pour plus de détail.

[https://laravel.com/docs/5.7/mix](https://laravel.com/docs/5.7/mix)

## Tests

```sh
./vendor/bin/phpunit
```

## Déploiement

Le script utilisé actuellement lors du déploiement est le suivant :

Pour effectuer les backups du site (avec un service configuré préalablement) ou envoyer la newsletter toutes les semaines, il vous faut le task scheduler lancé [https://laravel.com/docs/master/scheduling#introduction](https://laravel.com/docs/master/scheduling#introduction).
Voir les tâches lancées dans App\Console\Kernel.php.

```sh
cd /le/chemin/du/projet
git pull origin master
composer install --no-interaction --prefer-dist --optimize-autoloader
echo "" | sudo -S service php7.2-fpm reload

if [ -f artisan ]
then
    php artisan migrate --force
fi
```

## Built With  

* [Laravel](https://laravel.com/docs/5.7/) - The web framework used
* [NPM](https://www.npmjs.com/) - Dependency Management
