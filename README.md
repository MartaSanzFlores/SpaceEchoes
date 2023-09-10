
# 🚀 SpaceEchoes Backend Symfony 🚀

Bienvenue dans le dépôt Symfony de SpaceEchoes! Ce dépôt contient le code backend pour l'application web SpaceEchoes, qui se concentre sur la présentation d'articles et d'images liés à l'astronomie et au cosmos.

## Présentation du Projet

SpaceEchoes est une application web qui vise à offrir aux utilisateurs une plateforme pour explorer et apprendre divers sujets liés à l'astronomie. Elle comprend deux sections principales :

1. **Section des Articles :** Cette section présente une collection d'articles liés à l'astronomie. Chaque article fournit des informations détaillées sur un sujet spécifique, et les utilisateurs peuvent naviguer à travers les articles pour en apprendre davantage sur le cosmos.

2. **Galerie d'Images :** La galerie d'images présente une variété d'images captivantes liées à l'espace et à l'astronomie. Les utilisateurs peuvent parcourir ces images, les visualiser en détail et apprécier la beauté du cosmos.

## Technologies Utilisées

- Symfony : Le backend de l'application est construit en utilisant le framework Symfony, qui offre une base solide pour créer des applications web puissantes.
- Doctrine : L'ORM (Object-Relational Mapping) Doctrine est utilisé pour gérer les interactions avec la base de données et fournir une manière intuitive de travailler avec les entités de la base de données.
- Points d'API : Le backend expose des points d'API que l'application frontend React consommera pour récupérer les données.
- Twig : Est le moteur de templating de Symfony, fournissant une syntaxe simple pour créer des vues HTML. Il sera utilisé dans la conception  visuel du backoffice de notre application.

## Instructions d'Installation

1. Clonez ce dépôt sur votre machine locale.
2. Accédez au répertoire du projet en utilisant le terminal.
3. Exécutez `composer install` pour installer les dépendances requises.
4. Configurez les paramètres de votre base de données dans le fichier `.env`.
5. Exécutez `php bin/console doctrine:database:create` pour créer la base de données.
6. Exécutez `php bin/console doctrine:migrations:migrate` pour appliquer les migrations de la base de données.
7. Démarrez le serveur de développement Symfony avec `php -S 0.0.0.0:xxxx` (xxxx=port).

## Contact

Si vous avez des questions, des suggestions ou des retours, n'hésitez pas à contacter les développeurs du projet :

- Amel Belkacem : amel.belkacem.pro@gmail.com
- Marta Sanz : marta.sanz@example.com

Nous espérons que vous apprécierez explorer le cosmos à travers SpaceEchoes !

