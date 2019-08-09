# ENI_Sortir
Un projet Angular/Symfony réalisé dans le cadre de ma formation à l'ENI

Ce projet consiste à réaliser une plateforme web permettant aux stagiaires actifs et anciens stagiaires de la société ENI d'organiser des sorties. La plateforme est une plateforme privée dont l'inscription est gérée par le ou les administrateurs.

## Environnement
 
### Backend
Création d'un webservice avec **Symfony 4.3.3**

### Frontend
Création de la partie front avec **Angular 8.1.2** et **Bootstrap 4.3.1**

### SGBD
Gestion de la base de données avec **PostGre 11.4**

## Dépendances

Commencer par installer toutes les dépendences grâce à Composer et npm : 
* ```composer install``` dans le dossier symfony_backend
* ```npm install``` dans le dossier angular_frontend

## Base de données

Voici le script à exécuter pour :
- Créer la base de donnée
- Créer un rôle correspondant avec des permissions modérées

```sql
-- This should be run as superuser
-- Database creation
CREATE DATABASE sortir WITH ENCODING='UTF-8';
REVOKE CONNECT ON DATABASE sortir FROM PUBLIC;

-- Create user with low permission
CREATE USER eni_user WITH PASSWORD 'weakPassword' NOSUPERUSER INHERIT CREATEDB CREATEROLE NOREPLICATION;
GRANT CONNECT ON DATABASE sortir TO eni_user;

-- We need this for being sure that the procedure will execute correctly
SET TIMEZONE='Europe/Paris';
```

Depuis le dossier symfony_backend :


Générer les tables grâce à Doctrine :
* ```php bin/console doctrine:schema:create```

Vérifier que le mapping s'est fait correctement :
* ```php bin/console doctrine:schema:validate```

Pour finir, génerer un petit jeu de données grâce aux fixtures de Doctrine:
* ```php bin/console doctrine:fixtures:load```

### Procédure stockée

Maintenant que la base de donnée est créée et peuplée avec un jeu de donnée, lancer ce script pour créer la procédure stockée permettant de modifier le statut des sorties en fonction de leur date

__Dans un cadre de production, cette procédure stockée serait à appeler toutes les minutes via pg_cron__ :
* https://github.com/citusdata/pg_cron/

```sql
-- Update the state of a pursuit by current date.
-- Procedure to run every minute with pg_cron :
-- https://github.com/citusdata/pg_cron/
CREATE OR REPLACE PROCEDURE actualizePursuitState()
    LANGUAGE plpgsql
AS
$BODY$
DECLARE cursor_pursuits NO SCROLL CURSOR FOR
    SELECT date_end, date_start, duration
    FROM pursuits p
             INNER JOIN states s on p.states_nb_state = s.nb_state
         FOR UPDATE;
BEGIN
    FOR record_pursuits IN cursor_pursuits LOOP
        -- Could we register ourselves ?
        IF record_pursuits.date_end < NOW() THEN
            UPDATE pursuits SET states_nb_state = subquery.nb_state
            FROM
                (SELECT nb_state FROM states WHERE word = 'Inscriptions clôturées')
                    AS subquery
            WHERE CURRENT OF cursor_pursuits;
        END IF;
        -- Has it started ?
        IF record_pursuits.date_start < NOW() THEN
            UPDATE pursuits SET states_nb_state =
                (SELECT nb_state FROM states WHERE word = 'En Cours')
            WHERE CURRENT of cursor_pursuits;
        END IF;
        -- Is it over ?
        IF (record_pursuits.date_start + (record_pursuits.duration * interval '1 minute')) < now() THEN
            UPDATE pursuits SET states_nb_state =
                (SELECT nb_state FROM states WHERE word = 'Terminé')
            WHERE CURRENT OF cursor_pursuits;
        END IF;
        -- Is it archived ?
        IF (record_pursuits.date_start + interval '1 month' + (record_pursuits.duration * interval '1 minute')) < now() THEN
            UPDATE pursuits SET states_nb_state =
                (SELECT nb_state FROM states WHERE word = 'Archivé')
            WHERE CURRENT OF cursor_pursuits;
        END IF;
        -- For debugging purpose :
        -- RAISE NOTICE 'state_start %', record_pursuits.date_start;
        -- RAISE NOTICE 'state_start+duration %', record_pursuits.date_start + (record_pursuits.duration * interval '1 minute');
        -- RAISE NOTICE 'now %', now();
    END LOOP;
END
$BODY$;
```

### Lancement des serveurs

* Pour le webservice : ```php bin/console server:run``` dans le dossier symfony_backend (s'assurer que le serveur se soit bien lancé sur le port 8000 de localhost)

* Pour Angular : ```ng serve``` dans le dossier angular_frontend 

* Aller à l'adresse localhost:4200 depuis son navigateur

* Se connecter avec le pseudo 'participant' et le mot de passe 'weakPassword'