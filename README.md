# symfony-wishlist
This is a simple CRUD application to understand some basics concepts of symfony.

The tutorial series on Symfony done by Brad Traversy @ Traversy Media (https://youtu.be/t5ZedKnWX9E) was used as guidance along with the documentation (https://symfony.com/doc/current/index.html)

## To get started

#### Install dependencies `composer install`

#### Edit the env file and add DB params (DB name has been set as 'symfonyWishList')

#### Create DB by executing `php bin/console doctrine:database:create`

#### Create schema `php bin/console doctrine:migrations:diff`

#### Run migration `php bin/console doctrine:migrations:migrate`

#### Test application in http://localhost/symfony_demo_wishlist/public/ or relavant location
