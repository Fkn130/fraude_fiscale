# Liste des problèmes du projet

## Résumé

Le dépôt contient un petit site PHP/MySQL pour la connexion à des événements de jeux vidéo. Plusieurs fonctionnalités centrales sont incomplètes ou incohérentes : la base SQL utilise des noms de colonnes différents selon les fichiers, le script de connexion utilise une API PDO inexistante alors que le reste utilise mysqli, l'inscription aux événements n'est pas implémentée et les espaces client/admin ne sont pas entièrement sécurisés. La priorité la plus haute est la suppression immédiate du secret de base de données commité dans le dépôt.

## Liste des problèmes, du plus au moins important

### 1. Secret de base de données visible dans le dépôt

**Fichier concerné :** `script/bdd.php`

Le fichier contient directement l'hôte, le nom d'utilisateur et le mot de passe de la base de données :

```php
$password = 'Lghnvbn148';
```

Ces identifiants sont donc accessibles à toute personne ayant accès au dépôt ou à son historique Git. Ils doivent être changés chez l'hébergeur, retirés du code, puis déplacés dans des variables d'environnement. Il faut aussi vérifier si ce mot de passe apparaît dans l'historique Git et éventuellement purger celui-ci.

### 2. Script de connexion incohérent et susceptible de provoquer une erreur fatale

**Fichier concerné :** `script/login.php`

- `bdd.php` crée uniquement `$mysqli` avec MySQLi.
- `login.php` utilise ensuite `$pdo`, qui n'est jamais créé, dans `SELECT id FROM Admin WHERE id = :id`.
- `$user` n'est jamais initialisé, puis le script lit `$user['id']`, et commence par `var_dump($user)`, ce qui expose un état interne.
- `PDO::prepare()` est utilisé avec une connexion inexistante alors que les requêtes de connexion utilisent MySQLi.
- `session_start()` n'est appelé qu'après avoir lu des données de formulaire et avant la redirection réussie. Les pages incluses démarrent parfois la session elles-mêmes, mais le script ne doit pas dépendre de cette situation.
- L'existence d'un utilisateur doit être déterminée avant de lire son identifiant ou de décider qu'il est administrateur.
- Les variables `$_POST['connect']`, `$_POST['email']` et `$_POST['password']` sont lues sans validation ni valeurs par défaut.

Résultat : l'utilisateur peut rencontrer une erreur PHP ou une session incorrecte avant même que l'authentification ne fonctionne.

### 3. Incohérence majeure dans les noms de colonnes de la base

**Fichiers concernés :** `scrip.sql`, `ajout_donner.sql`, `script/table_event.php`, `site/login/index.php`

Le schéma crée la clé primaire `Evenement.id`, mais les scripts utilisent `Evenement.id_evenement` :

- `scrip.sql` : `PRIMARY KEY(id)` pour `Evenement`
- `ajout_donner.sql` : colonnes insérées `id_evenement`
- `ajout_donner.sql` : insertions dans `sincire` avec `id_evenement`
- `table_event.php` : `SELECT id_evenement`
- `index.php` : lit `$row["id_evenement"]`

Le fichier `table_event.php` est donc incompatible avec le schéma déclaré. La clé primaire devrait être choisie une fois puis utilisée partout.

Il existe également une incohérence entre le nom réel de la table `sinscire` dans le schéma et son utilisation dans les données ajoutées : les deux fichiers utilisent `sinscire`, tandis que les formulaires ne prévoient pas encore son remplissage.

### 4. Inscription aux événements non implémentée

**Fichier concerné :** `site/login/traitement_inscription.php`

Ce fichier est complètement vide. Pourtant :

- la page d'accueil affiche un formulaire contenant l'identifiant d'un événement ;
- le formulaire pointe vers ce script ;
- aucun code ne vérifie si l'utilisateur est connecté ;
- aucune ligne n'est insérée dans la table d'inscription ;
- aucun contrôle de places disponibles ou de doublons n'est effectué ;
- aucune valeur de redirection ou de retour utilisateur n'est produite.

La fonctionnalité visible du formulaire ne fonctionne donc pas.

### 5. Création de compte incorrecte et sécurité insuffisante

**Fichier concerné :** `script/login.php`

- La création de compte ne vérifie pas réellement si l'e-mail existe déjà : `if ('adress_mail' == $email)` compare une constante textuelle à l'e-mail. Ce test est presque toujours faux.
- La requête d'unicité vérifie uniquement `count(*)`, mais ne récupère pas et ne valide pas clairement le résultat.
- L'insertion n'insère que l'e-mail et le mot de passe, sans nom, prénom ou identifiant alors que ces colonnes appartiennent à la table `Utilisateurs` mais ne sont pas déclarées comme optionnelles.
- Le mot de passe est traité avec `SHA(?)`, souvent en SHA-1 dans MySQL. Il ne s'agit pas d'un stockage moderne et sécurisé.
- Il n'y a ni `password_hash()`, ni `password_verify()`, ni sel unique géré par PHP.
- Le script ne valide ni format d'e-mail, ni longueur, ni complexité du mot de passe.
- La branche ne ferme pas proprement son exécution après les redirections.

### 6. Contrôles d'accès admin absents ou incohérents

**Fichiers concernés :** `script/login.php`, `site/login/admin.php`, `element/nav.php`

`login.php` essaie de remplir `$_SESSION['is_admin']`, mais utilise une requête PDO qui échouera. De plus, `admin.php` ne vérifie pas côté serveur que l'utilisateur est administrateur : toute personne pouvant ouvrir directement cette URL peut exécuter son affichage.

La navigation affiche un lien admin uniquement selon la session, mais il faut également sécuriser la page elle-même. Aucun contrôle ne doit reposer uniquement sur l'interface.

### 7. La session est mal ordonnée et la gestion de déconnexion est incomplète

**Fichiers concernés :** `script/login.php`, `element/nav.php`, `site/login/espace_client.php`

- Plusieurs fichiers démarrent la session à des moments différents.
- `login.php` devrait démarrer la session au tout début du traitement.
- La navigation propose `deconnexion.php`, mais ce fichier n'existe pas dans le dépôt.
- `espace_client.php` vérifie l'identifiant de session, mais ne bloque pas la page avec une redirection claire lorsque l'utilisateur n'est pas connecté.
- Certaines branches peuvent produire du HTML avant un appel à `header()`, ce qui empêche les redirections.

### 8. L'espace client affiche des données inexistantes

**Fichier concerné :** `site/login/espace_client.php`

La page référence `$reservations`, mais aucun script ne construit cette variable ni ne lance la requête correspondante. Le bloc affichera donc régulièrement « aucune réservation » alors qu'il a seulement échoué à charger les données, ou une variable non définie pourra produire un avertissement PHP.

Il manque une jointure entre l'utilisateur connecté, la table `sinscire` et les événements, avec la gestion des erreurs SQL.

### 9. Les données SQL sont très probablement incohérentes avec le schéma

**Fichiers concernés :** `ajout_donner.sql`, `scrip.sql`

- Les huit premières lignes insèrent des utilisateurs avec des valeurs vides. Comme `id` est une clé primaire entière, `''` peut être converti en `0`, provoquant des doublons et plusieurs échecs d'insertion.
- Les mots de passe contenus dans les données sont des chaînes en clair : `mdp123`, `emma456`, etc.
- Le jeu de données insère des utilisateurs après une première liste déjà invalide.
- `Spectacteur.inscription` utilise des chaînes `Oui/Non` au lieu d'une valeur booléenne ou d'une relation plus normalisée.
- `Admin` duplique les droits sous forme de trois colonnes `VARCHAR`.
- `Evenement` expose `id` pour l'événement et `id_1` pour l'administrateur, ce qui rend les requêtes plus difficiles à lire que des noms explicites.
- Les données insérées dans `ajout_donner.sql` ne seront pas exécutables comme prévu si les noms de colonnes ne correspondent pas exactement au schéma.

### 10. Détection de résultats SQL insuffisante et erreurs masquées

**Fichiers concernés :** `script/table_event.php`, `site/login/admin.php`

- `mysqli_query()` n'est pas vérifié avant `mysqli_fetch_all()` dans `table_event.php`.
- Une requête peut échouer silencieusement et produire une erreur PHP.
- `admin.php` vérifie `$resultat`, ce qui est mieux, mais n'affiche aucun message d'erreur utile.
- Le script ne centralise ni logage, ni affichage d'erreurs SQL.

Cela rend les problèmes de schéma difficiles à diagnostiquer.

### 11. Problème JavaScript dès que le bouton de thème est absent

**Fichier concerné :** `js/script.js`

`themeToggle` est récupéré directement avec `getElementById()`, puis `.addEventListener()` est appelé. Sur une page sans cet élément, `themeToggle` vaut `null` et JavaScript peut s'arrêter avec :

```text
Cannot read properties of null
```

Le script doit vérifier que l'élément existe. Par ailleurs, le thème choisi n'est ni enregistré dans `localStorage` ni restauré au chargement.

### 12. CSS incomplet et variable CSS non définie

**Fichier concerné :** `css/style.css`

Plusieurs sélecteurs utilisent `var(--hover)` alors que `--hover` n'est pas déclaré dans `:root` ni dans `[data-theme="dark"]`.

Cela concerne notamment `.btn-theme:hover` et `.day:hover`. Le navigateur utilisera donc une valeur invalide pour ces états. Une couleur de survol explicite devrait remplacer cette variable ou être définie.

### 13. Structure HTML invalide dans la navigation

**Fichier concerné :** `element/nav.php`

- Les balises `<a>` ne sont pas toutes entourées de balises `<li>`, tandis que `<li>` est présent pour certains liens de déconnexion.
- `</li>` peut être fermé sans `<li>` ouvrant pour les liens Accueil, Connexion et Espace client.
- Les liens relatifs sont dépendants de l'URL courante et peuvent casser selon la page appelante.

Cette structure doit être corrigée pour obtenir une navigation valide et accessible.

### 14. Scripts frontend mal inclus

**Fichiers concernés :** `element/footer.php`, toutes les pages PHP

`footer.php` contient l'inclusion du JavaScript, mais aucune page du dépôt ne semble l'inclure. Le bouton de thème peut donc ne pas avoir de JavaScript chargé, selon la page réellement exécutée.

Le script est lié avec un chemin relatif depuis `../../js/script.js`, qui peut être moins robuste qu'une base de chemin issue du dossier du projet.

### 15. Encodage HTML et langues incohérents

**Fichier concerné :** `element/header.php`

Le document déclare `lang="en"` alors que l'interface est en français. Cette déclaration doit être cohérente avec le contenu. L'ajout de `footer.php` devrait aussi être systématique, mais cela dépasse l'affichage principal.

### 16. Mauvaise utilisation de l'escape HTML dans les écrans administrateur

**Fichiers concernés :** `site/login/admin.php`, `site/login/espace_client.php`, `site/login/index.php`

Les noms et dates sont affichés directement dans `admin.php`, sans échappement HTML. Les données étant stockées en base, elles devraient toujours passer par `htmlspecialchars()` avant affichage pour éviter une injection XHTML/HTML si une valeur contient des balises.

### 17. Code mort, fichiers temporaires et hygiène du dépôt

**Fichiers concernés :** logs `log/2026-11-13fraude.log`, `script/2026-11-13fraude.log`

- Deux fichiers de log identiques ou proches sont présents dans des emplacements différents.
- Les fichiers de log sont committés, alors qu'ils peuvent être réécrits à chaque action.
- Le dépôt ne contient pas de `.gitignore` évident pour exclure les logs et les fichiers sensibles.
- `script/2026-11-13fraude.log` semble déplacé dans le mauvais dossier.

Il faut ajouter une exclusion pour `*.log`, choisir un seul emplacement pour les logs et supprimer les historiques déjà committés.

### 18. Documentation presque vide

**Fichier concerné :** `README.md`

Le README indique seulement le contexte BTS et « projet hébergement jeux vidéos ». Il ne décrit ni :

- les prérequis PHP/MySQL ;
- les étapes d'installation ;
- la création de la base ;
- les chemins d'accès ;
- les identifiants de test ;
- les variables d'environnement ;
- les fonctionnalités disponibles ;
- les limitations actuelles.

### 19. Noms de fichiers ambigus ou fautifs

**Fichiers concernés :** `scrip.sql`, `scrip.sql`, `ajout_donner.sql`

- `scrip.sql` serait plus clair sous un nom tel que `schema.sql`.
- `ajout_donner.sql` contient une faute d'orthographe (`donner` au lieu de `données`) et mélange schéma de jeu de données.
- Les tables `sinscire` et `Spectacteur` contiennent des fautes ou des noms peu parlants.

Ces noms peuvent être conservés temporairement, mais des fichiers de migration avec des noms normalisés seraient plus clairs.

---

## Explication de chaque fichier

| Fichier | Rôle |
|---|---|
| `README.md` | Présentation minimale du projet. |
| `Liste_pb.md` | Rapport des problèmes et descriptions du dépôt. |
| `ajout_donner.sql` | Contient des premiers essais d'insertions puis un jeu de données d'utilisateurs, administrateurs, spectateurs, événements et inscriptions. |
| `scrip.sql` | Définit les tables `Utilisateurs`, `Spectacteur`, `Admin`, `Evenement` et `sinscire`. |
| `script/bdd.php` | Ouvre la connexion MySQLi avec l'hôte, la base, l'utilisateur et le mot de passe. |
| `script/login.php` | Tente de gérer la connexion, la création de compte et la détection du rôle administrateur. |
| `script/table_event.php` | Interroge la base pour récupérer les événements visibles sur la page d'accueil. |
| `log/log.php` | Fournit une classe `Logger` pour écrire des logs datés dans le dossier `log`. |
| `log/2026-11-13fraude.log` | Exemple de fichier de log contenant des connexions réussies. |
| `script/2026-11-13fraude.log` | Copie ou ancien emplacement d'un fichier de log placé dans le dossier des scripts. |
| `site/login/index.php` | Affiche la liste des événements et un bouton d'inscription pour chacun. |
| `site/login/page_connexion.php` | Affiche le formulaire de connexion et de création de compte. |
| `site/login/traitement_inscription.php` | Page prévue pour traiter l'inscription à un événement ; actuellement vide. |
| `site/login/espace_client.php` | Affiche l'espace utilisateur et devrait récupérer les réservations du client. |
| `site/login/admin.php` | Affiche une liste brute des événements destinée à la gestion administrateur. |
| `element/header.php` | Produit le doctype, les métadonnées et la feuille de style. |
| `element/nav.php` | Produit la navigation, le bouton de thème et les liens selon l'état de la session. |
| `element/footer.php` | Contient l'inclusion du fichier JavaScript principal. |
| `js/script.js` | Gère le basculement clair/sombre du bouton `themeToggle`. |
| `css/style.css` | Définit les variables de thème, la mise en page, les tableaux, les boutons et le responsive mobile. |
| `images/logo.png` | Contient l'image du logo. Son utilisation dans le code HTML n'a pas été trouvée. |

## Priorités de correction recommandées

1. Rotation des identifiants de base, retrait du mot de passe du dépôt et séparation des configurations locales.
2. Harmonisation complète du schéma : clés primaires, noms de colonnes et relation inscription/spectateur/événement.
3. Réécriture de `script/login.php` avec mysqli ou PDO de façon cohérente, session sécurisée, données préparées et mots de passe modernes.
4. Implémentation de `traitement_inscription.php` avec contrôles de connexion, places, doublons et droits.
5. Chargement des réservations dans `espace_client.php`.
6. Protection côté serveur de `admin.php` et suppression de `deconnexion.php` ou création de cette page.
7. Correction du HTML, du JavaScript, du CSS, des chemins d'inclusion et de la documentation.
