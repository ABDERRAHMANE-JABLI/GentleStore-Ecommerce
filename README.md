# abderrahmane_jabli@um5.ac.ma

## Créer votre projet avec CLI Symfony
`symfony new your_project_directory --version="6.3.*" --webapp`

## Configuration de la base de données
### Les informations de connexion à la base de données sont stockées sous forme de variable d'environnement appelée DATABASE_URL. A l’intérieur du fichier .env :
`DATABASE_URL="mysql://root:@127.0.0.1:3306/gentleStoreDB?serverVersion=10.4.25-MariaDB&charset=utf8mb4"`

## Génération de la base de données :
`symfony console doctrine:database:create`

## Migrations : création des tables/schéma de base de données
`symfony console make:migration`
`symfony console doctrine:migrations:migrate`

## Lancer l’application en arriere plan:
`symfony server:start -d`




