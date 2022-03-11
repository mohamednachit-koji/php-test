# supervision-brs

supervision-brs est une application qui permet la communication avec les bornes, en plus d'offrir une interface admin pour consulter les données.

<img src="https://gyazo.com/eb5c5741b6a9a16c692170a41a49c858.png" width="48">


## Installation
1. Clonez le projet: `git clone git@github.com:BorneRecharge/supervision-brs.git`
2. Créez un fichier .env dans la racine du projet avec les variables d'environnements (vous pouvez vous baser sur .env.example)
3. Lancez la commande `composer install`
4. Lancez la commande `composer start`
5. L'interface admin est accessible depuis `localhost:8080`

## Key libraries
- Slim framework: Micro framework 
- PHP-DI: dependency injection
- Twig: template engine
- PDO: database access

## Vocabulaire
**Borne(Station)**: Machine qui envoit des données à supervision-brs en continu
**Badge(Tag)**: Contrat qui permet d'identifier le détenteur de la borne
**Charge(Transaction)**: L'action de charger d'une voiture, commence par le chargement et se termine par le dépot 
(ChargeStart => Deposit)
**Supervision**: L'interface admin

## Fonctionnalités
### 1. Communication avec les bornes
Une borne envoit deux types de données: les reports et les commands
Les bornes utilisent deux endpoints pour envoyer leur données: .../report.php et .../command.php
##### 1.a Traitement des *reports*
Un report est un évenement qui a eu lieu au côté de la borne. Ca peut être un événement de début de charge, fin de charge, une alerte d'erreur etc...
Chaque borne envoit en continu une liste de report pour informer supervision-brs des événements qui sont passés.
Un report est un évenement identifié par le format suivant `<code> <timestamp> <data>`
La requête HTTP est un GET vers l'endpoint de report. Elle contient l'id de la borne en query params et la liste des reports en body

Exemple:
```
GET /webapp/services/record/report.php?id=736
101 1317704931 000000000000 20
300 1270161125 0102023
200 1270161125 000000000234 3000 400
```
##### 1.b Traitement des *commands*
Une *command* est une action à executer par la borne. Ca peut être la mise à jour de son heure, mise à jour de son firmware...
Une borne envoit une requête HTTP GET avec son identifiant via l'endpoint de /command, et attend en réponse une liste de commandes

### 2. Interface web de supervision
- Authentification JWT
- Liste des bornes
- Liste des tags
- Liste des utilisateurs
- Liste des transactions
- Détails des bornes
- Détails des utilisateurs
- Détails transactions
- Détails des tags
