# DREAL - Des aides pour les territoires de la Nouvelle-Aquitaine

Une base de données ouverte sur les aides aux territoires de la région Nouvelle-Aquitaine.

## Commencer

Ces instructions vous fourniront une copie du projet opérationnel sur votre ordinateur local à des fins de développement et de test. Voir la partie déploiement pour des notes sur la façon de déployer le projet sur un système actif.

### Pré-requis

Il est nécessaire d'installer les outils suivants afin de pouvoir faire tourner l'application en local :
- Composer
- NPM / Yarn

### Installation

Cloner le dépôt distant

```
git clone git@github.com:DREAL-NA/aides.git
```

Créer une base de données de dev et de test

```
echo "create database dreal" | mysql -u <USERNAME> -p
echo "create database dreal_test" | mysql -u <USERNAME> -p
```

Copier le fichier d'environnement `.env.example`, le dupliquer en un `.env` et renseigner au minimum les vairables suivantes dans le fichier `.env` afin de pouvoir développer en local :

- `APP_URL`
- `APP_DOMAIN`
- `DB_DATABASE`
- `DB_USERNAME`
- `DB_PASSWORD`
- `MAILCHIMP_APIKEY`

```
cd /le/chemin/du/projet
cp .env.example .env
nano .env
```

Installer les dépendances, générer une clé d'application et migrer la base de données

```
composer install
php artisan key:generate
php artisan migrate
```

Il est conseillé pour utiliser la fonctionnalité de recherche de créer et utiliser un compte [Alogolia](https://www.algolia.com/).
Pour cela, dans le .env, il faut renseigner les 2 clés qui sont actuellement commentées, ALGOLIA_APP_ID et ALGOLIA_SECRET, disponibles après la création d'un projet sur Algolia.
Il suffit ensuite de lancer la commande `php artisan scout:import` pour importer les données dans Algolia.
À noter également : une tâche permettant de réimporter les données est lancée toute les nuits dans le scheduler.

Vous pouvez lancer les différents seeder, par example pour créer un utilisateur :

```
php artisan db:seed
```

Cela va créer un utilisateur `john@example.com` avec comme mot de passe `password`.


Pour peupler la base de données avec les lieux:
```bash
mysql -u {USERNAME} -p {DATABASE} < ./resources/data/import-nouvelleaquitaine.sql
```

Vous êtes maintenant prêt·e à travailler !

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

[Laravel Mix](https://laravel.com/docs/5.7/mix) est utilisé pour compiler les assets.
Webpack est utilisé pour compiler les assets.
Regarder les commandes disponibles dans le `package.json`.

## Tests

```sh
./vendor/bin/phpunit
```

## Déploiement

Le script utilisé actuellement lors du déploiement est le suivant :

Pour effectuer les backups du site (avec un service configuré préalablement) ou envoyer la newsletter toutes les semaines, il vous faut lancer le [task scheduler de Laravel](https://laravel.com/docs/master/scheduling#introduction).
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

## Pile logicielle

* [Laravel](https://laravel.com/docs/5.7/) - The web framework used
* [NPM](https://www.npmjs.com/) - Dependency Management

## Licence

Ce code est fourni sous une licence libre [AGPL v3](https://choosealicense.com/licenses/agpl-3.0/), ce qui signifie que vous êtes libre de réutiliser, distribuer et modifier ce code source dans la mesure où vous attribuez son origine à la DREAL Nouvelle-Aquitaine et rendez vos propres modifications accessibles et réutilisables par d'autres. L'usage de _pull requests_ vers ce dépôt pour partager vos modifications est fortement encouragé.

Les données hébergées par cette application sont mises à disposition sous Licence Ouverte, et sont accessibles directement sur le site [aides-developpementdurable-nouvelleaquitaine.fr](http://aides-developpementdurable-nouvelleaquitaine.fr).
