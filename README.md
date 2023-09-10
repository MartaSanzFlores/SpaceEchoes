
# 🚀 SpaceEchoes Backend Symfony 🚀

Bienvenue dans le dépôt Symfony de SpaceEchoes! Ce dépôt contient le code backend pour l'application web SpaceEchoes, qui se concentre sur la présentation d'articles et d'images liés à l'astronomie et au cosmos.

L'application web a été conçue et développée en un mois par une équipe composée de quatre développeurs, dont deux développeurs front-end et deux développeurs back-end. Elle est actuellement en cours de développement pour l'ajout de nouvelles fonctionnalités ainsi que pour l'amélioration du code et du design.

## Présentation du Projet

SpaceEchoes est une application web qui vise à offrir aux utilisateurs une plateforme pour explorer et apprendre divers sujets liés à l'astronomie. Elle comprend deux sections principales :

1. **Section des Articles :** Cette section présente une collection d'articles liés à l'astronomie. Chaque article fournit des informations détaillées sur un sujet spécifique, et les utilisateurs peuvent naviguer à travers les articles pour en apprendre davantage sur le cosmos. Les utilisateurs peuvent également poster des commentaires sur chaque article pour les partager avec d'autres, ainsi que signaler les commentaires qu'ils estiment inappropriés. Ces commentaires seront ensuite évalués par l'administrateur dans le back-office de l'application.

2. **Galerie d'Images :** "La galerie d'images présente une variété d'images captivantes liées à l'espace et à l'astronomie. Les utilisateurs peuvent parcourir ces images, les visualiser en détail et apprécier la beauté du cosmos. Les utilisateurs peuvent également "liker" ces images pour exprimer leur appréciation.

## Technologies Utilisées

- Symfony : Le backend de l'application est construit en utilisant le framework Symfony, qui offre une base solide pour créer des applications web puissantes.
- Doctrine : L'ORM (Object-Relational Mapping) Doctrine est utilisé pour gérer les interactions avec la base de données et fournir une manière intuitive de travailler avec les entités de la base de données.
- Points d'API : Le backend expose des points d'API que l'application frontend React consomme pour récupérer les données.
- Twig : Est le moteur de templating de Symfony, fournissant une syntaxe simple pour créer des vues HTML. Il est utilisé dans la conception visuelle du back-office de notre application.
- Bootstrap : Bootstrap est un framework CSS et JavaScript populaire qui est utilisé pour la création d'interfaces web élégantes et réactives. Il  Est utilisé pour le style du back-office de lnotre application.
- MySQL : La base de données MySQL est utilisée pour stocker et gérer les données de l'application. Elle offre une solution fiable et performante pour la persistance des données.

## Instructions d'Installation

1. Clonez ce dépôt sur votre machine locale.
2. Accédez au répertoire du projet en utilisant le terminal.
3. Exécutez `composer install` pour installer les dépendances requises.
4. Creez un fichier `.env.local` et configurez les paramètres de votre base de données, en vous basant dans le fichier d'exemmple `.env`.
5. Exécutez `php bin/console doctrine:database:create` pour créer la base de données.
6. Exécutez `php bin/console doctrine:migrations:migrate` pour appliquer les migrations de la base de données.
7. Démarrez le serveur de développement Symfony avec `php -S 0.0.0.0:xxxx` (xxxx=port).

## Contact

Si vous avez des questions, des suggestions ou des retours, n'hésitez pas à contacter les développeurs du projet :

- Amel Belkacem : amel.belkacem.pro@gmail.com
- Marta Sanz : martasf22@gmail.com

Nous espérons que vous apprécierez explorer le cosmos à travers SpaceEchoes !

