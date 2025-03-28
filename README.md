# Projet Ar Façades

## Développeurs
Léo Chappart, Philippe Boudegna et Gabriel Marcel


## Installation
Les différentes étapes pour installer le projet sont les suivantes :
- Exécutez la commande suivante dans votre terminal dans le dossier où vous souhaitez cloner le repo:
```bash  
git clone https://github.com/Leaph-ai/GPLDev_Project1.git 
```
- Ensuite, exécutez la commande :
````bash
composer install
````
- Importez la base de donnée grâce au fichier `ar_façades.sql` que vous trouverez dans le dossier `Includes`.
- Créez un fichier `.env` à la racine puis collez le contenu de `.env.dist` :
````
DB_HOST=  //Le nom de votre host
DB_NAME=  //Le nom de votre base de données
DB_USER=  //Le nom du user  
DB_PASS=  //Le mot de passe
````

Voilà, vous avez installé le projet ! Vous pouvez vous connecter avec le compte admin et le mot de passe admin
