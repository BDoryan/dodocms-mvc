<!-- PROJECT LOGO -->
<br />
<div align="center">
  <a href="https://github.com/othneildrew/Best-README-Template">
    <img src="https://i.ibb.co/tzw8HHt/Microsoft-Fluentui-Emoji-3d-Dodo-3d-1024-2.png" alt="Logo" width="80" height="80">
  </a>

<h3 align="center"><strong>DodoCMS</strong></h3>

  <p align="center">
    La facilité de développer des solutions avec une gestion de contenu simplifié.
    <br />
    <a href="https://github.com/othneildrew/Best-README-Template">Visiter le projet</a>
    ·
    <a href="https://github.com/othneildrew/Best-README-Template/issues">Je rencontre un problème</a>
    ·
    <a href="https://github.com/othneildrew/Best-README-Template/issues">Laisser une proposition</a>
  </p>
</div>

# Documentation technique

## Sommaire

1. [Introduction](#introduction)
2. [Technologies](#technologies)
3. [Mettre en place le système](#mettre-en-place-le-système)
    1. [Prérequis](#prérequis)
    2. [Installation](#installation)
    3. [Installation avec l'interface graphique](#installation-avec-l'interface-graphique)
    4. [Configuration approfondie](#configuration-approfondie)
    5. [Maintenir le système à jour](#maintenir-le-système-à-jour)
    6. [Fonctionnalités](#fonctionnalités)
4. [Fonctionnalités de développeur](#fonctionnalités-de-développeur)
    1. [Routage](#routage)
    2. [Modèle](#modèle)
    3. [Vue](#vue)
    4. [Contrôleur](#contrôleur)

## Introduction

<div id="introduction">
Bienvenue sur la documentation technique du projet DodoCMS. L’intérêt de ce document, c'est de vous accompagner au
maximum dans l’utilisation de ce CMS.

Il est important de savoir que ce document s’adresse autant aux administrateurs, mais aussi aux développeurs. En effet,
par moment il se peut que je rentre en détails dans les explications, l’idée est d’être le plus clair possible. Si le
code ne vous dit rien ou n’a aucun intérêt pour vous, ne vous attardez pas dessus.

### Contexte de ce projet (fictif)

Ce projet a été réalisé afin de répondre à la demande d’une agence web. Le but étant de répondre à la principale
problématique qui était de créer des sites simplement et plus rapidement tout en rendant accessible l’édition du contenu
facile pour leur clientèle.

L’agence web a fait le choix de développer leur propre CMS pour en être le propriétaire mais aussi de développer un
outil qui parle aux développeurs web. En effet, avant d’être un simple CMS cet outil est aussi un framework regroupant
différents outils pour la conception d’un site internet.
CMS : Système de gestion de contenu
Framework : Une base de code, une structure, une boîte à outil
</div>

## Technologies

<div id="technologies">
Le choix des technologies utilisées pour ce projet a été mûrement réfléchi. En effet, il était important de choisir des 
technologies modernes pour répondre à la demande de l’agence web. 

### Liste des technologies utilisées

- HTML, CSS & JS : Ces langages sont incontournables lorsqu'il s'agit de concevoir des sites internet.
- jQuery : J'ai décidé d'utiliser cette librairie pour faciliter la manipulation du DOM.
- PHP (7.4 >= 8.4) : J'ai décidé d'utiliser ce langage pour le back-end, car il demeure aujourd'hui le plus largement
  utilisé.
- Vue.js : Fort de mon expérience avec des technologies telles que React.js et Next.js, j'ai jugé essentiel de faciliter
  l'intégration des éléments dynamiques en JavaScript, d'où mon choix de Vue.js.
- TailwindCSS : Mon objectif était de retrouver la rapidité de développement d'un framework graphique pour créer
  rapidement une interface visuelle, même si ce n'est pas la priorité actuelle.
- FontAwesome : Réaliser un visuel un minimum agréable (à mes yeux) j'ai voulu mettre en place des icons pour que cela
  parle plus à l'utilisateur.
- MariaDB : Base de données relationnelle

<br>
<img style="padding-left: 10px; width: 70px; height: 60px;" src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/61/HTML5_logo_and_wordmark.svg/1200px-HTML5_logo_and_wordmark.svg.png">
<img style="padding-left: 10px; width: 70px; height: 60px;" src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/62/CSS3_logo.svg/800px-CSS3_logo.svg.png">
<img style="padding-left: 10px; width: 60px; height: 60px;" src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/99/Unofficial_JavaScript_logo_2.svg/1200px-Unofficial_JavaScript_logo_2.svg.png">
<img style="padding-left: 10px; width: 60px; height: 60px;" src="https://jf-blog.fr/wp-content/uploads/2015/09/jquery.gif">
<img style="padding-left: 10px; width: 60px; height: 60px;" src="https://asset.brandfetch.io/idDdcAzL5L/ido5lPeazF.png">
<img style="padding-left: 10px; width: 120px; height: 40px;" src="https://www.coqpit.fr/wp-content/uploads/2019/05/vuejs-wide.png">
<img style="padding-left: 10px; width: 70px; height: 70px; filter: invert(100%);" src="https://cdn.iconscout.com/icon/free/png-256/free-tailwind-css-5285308-4406745.png?f=webp">
<img style="width: 70px; height: 70px; object-fit: contain; object-position: center; filter: invert(100%)" src="https://d1.awsstatic.com/logos/partners/MariaDB_Logo.d8a208f0a889a8f0f0551b8391a065ea79c54f3a.png">
</div>

## Mettre en place le système

### Prérequis

- Serveur web sous <strong>Apache</strong>
- <strong>PHP</strong> 7.4 ou supérieur avec ses extensions <strong>php-curl, php-xml, php-zip, php-json, php-pdo,
  php-pdo_mysql</strong>
- <strong>MariaDB</strong> 10.5 ou supérieur
- <strong>Composer</strong>
- <strong>npm</strong> (Si vous souhaitez faire des modifications avec TailwindCSS)

### Installation

1. Télécharger le projet sur GitHub
2. Décompresser le fichier dans le répertoire de votre serveur web
3. Copier le fichier `.htaccess` de GitHub à la racine de votre serveur web (si celui-ci n'est pas déjà présent après la
   décompression)
4. Installer les dépendances PHP avec Composer `composer install`
5. Désormais, vous pouvez accéder à votre site internet et vous devriez voir un formulaire d'installation

> Attention, les droits sur les fichiers et dossiers doivent être correctement configurés pour éviter tout problème lors
> de
> l'installation.

> Note : Si vous avez des problèmes lors de l'installation, n'hésitez pas à ouvrir une issue sur le projet GitHub.

### Installation avec l'interface graphique

#### 1. Création de la base de donnée

Lors de cette étape, vous devrez renseigner les informations de connexion à votre base de donnée. Il est préférable que
la base de donnée ne soit pas déjà existante pour éviter tout problème.
<br>
<br>
<img width="500" src="https://dl.dropboxusercontent.com/scl/fi/m8mqb7t178lv747ulc2g6/Screenshot-at-00-27-21.png?rlkey=0s4e17oqqd6lcsp9d5kuh9xei"/>

#### 2. Création du compte administrateur

Une fois la base de donnée créée, vous devrez renseigner les informations de connexion de votre compte administrateur
afin de pouvoir accéder à l'interface d'administration.
<br>
<br>
<img width="500" src="https://dl.dropboxusercontent.com/scl/fi/vmzwuo6ceyhdlbopm70md/Screenshot-at-00-28-59.png?rlkey=jso5mpoyvlj8pv7bhxbq68i7r"/>

#### 3. Installation terminée

Une fois que vous avez renseigné toutes les informations, vous devriez voir un message de confirmation vous indiquant
que l'installation est terminée. Mais avant de pouvoir accéder à l'interface d'administration, vous devrez supprimer le
dossier `install` à la racine de votre site internet.

### Configuration approfondie

Si vous souhaitez configurer plus en détail le CMS, vous pouvez modifier le fichier `config/application.json` en partant
de la racine du site. Ce fichier contient toutes les informations de configuration du CMS.

Vous pouvez modifier les informations suivantes :

- `password_policy` : Expression régulière pour la politique de mot de passe (par défaut : 8 caractères minimum, 1
  lettre, 1 chiffre et 1 caractère spécial)
- `jwt` : Configuration du JWT (Json Web Token) pour l'authentification (clé secrète et expiration)
- `image_quality` : Qualité des images lors de leur optimisation (par défaut : 80)
- `admin_path` : Chemin d'accès à l'interface d'administration (par défaut : `admin123`)
- `mysql` : Configuration de la base de donnée MySQL (hôte, utilisateur, base de donnée, mot de passe)
- `modules` : Configuration des modules (actuellement désactivé par défaut)
- `theme` : Thème utilisé par le CMS (fait référence au dossier dans `/themes/default/`)

```json
{
  "password_policy": "^(?=.*[A-Za-z])(?=.*\\d)(?=.*[@$!%*#?&])[A-Za-z\\d@$!%*#?&]{8,}$",
  "jwt": {
    "secret": "",
    "expiresIn": 14400
  },
  "image_quality": 80,
  "admin_path": "admin123",
  "mysql": {
    "hostname": "localhost",
    "username": "root",
    "database": "dodocms_installation_test",
    "password": "p@$$w0rd"
  },
  "modules": {
    "enabled": false
  },
  "theme": "default"
}
```

## Maintenir le système à jour

Le système de mise à jour n'est pas encore abouti, mais vous avez tout de même la possibilité de mettre à jour le CMS.

> ⚠ Attention, vous devez savoir que lors de la mise à jour la totalité des fichiers dans le dossier `/core` seront
> supprimé et remplacer par la nouvelle version du système. <strong>Cela signifie que si vous avez apporté des
> modifications dans
> ce dossier, elles seront perdues.</strong>

> Conseil, avant de mettre à jour le CMS, assurez-vous d'avoir une sauvegarde de vos fichiers et de votre base de donnée
> afin d'éviter les mauvaises surprises.

Bien entendu, je travaille activement sur la mise en place d'un système de mise à jour plus sécurisé et plus simple afin
d'éviter toutes ces manipulations.
Le but étant de rendre l'expérience administrateur la plus agréable possible.

<img src="https://dl.dropboxusercontent.com/scl/fi/dus2225kx7no31td3oboe/Screenshot-at-00-55-30.png?rlkey=wmm2e21oezpq68j7k0zscjdtr" />

## Fonctionnalités en tant qu'administrateur

### Création de page

La création de page est une fonctionnalité essentielle pour un CMS. Elle permet de composer une page à partir de blocs
prédéfinis. Ces blocs sont des visuels développés par un développeur et qui peuvent être personnalisés par
l'administrateur.

Pour créer une page, il vous suffit de vous rendre dans l'interface d'administration dans la section "Pages" et vous
aurez
un formulaire vous permettant de créer une nouvelle page. La création de cette page se fait en plusieurs étapes :

- Nom de la page
- Titre SEO (balise title de la page)
- Description SEO (balise meta description de la page)
- Mots-clés SEO (balise meta keywords de la page)
- Icône de la page (favicon)
- Route de la page (chemin après le nom de domaine)

Une fois que vous avez renseigné ces informations, vous aurez une page vierge prête à être composée avec des blocs grâce
au live-edit.

<img src="https://dl.dropboxusercontent.com/scl/fi/x238usmd9e7upsvzlqphj/Screenshot-at-19-10-13.png?rlkey=vrmqv1lnqxsk7hd3vku15gkv9" />

### Composer une page

La composition des pages ce fait à partir de blocs que vous pouvez ajouter, modifier et supprimer. Ces blocs sont des
éléments visuels qui peuvent être personnalisés uniquement si le développeur l'a prévu.

Lorsque vous êtes sur une page, vous avez la possibilité de cliquer sur le bouton "+" pour ajouter un bloc
à la page. Vous aurez alors une liste de blocs disponibles que vous pourrez ajouter à la page.
Quand vous aurez ajouté un bloc, vous pourrez le personnaliser les textes et médias à l'intérieur de celui-ci.

> 💾 Note : Vous devez savoir que vous, modifications de contenu ne sont pas sauvegardées automatiquement. Vous devez
> cliquer sur le bouton "Enregistrer" pour sauvegarder vos modifications. **Sauf pour les déplacements de bloc**, les
> modifications sont instantanément enregistré.

> ⚠ Attention, si vous supprimez un bloc, vous perdrez toutes les modifications que vous avez apportées à l'intérieur de
> celui-ci. Il est donc important de faire attention avant de supprimer un bloc.

*Exemple du live-edit*
<img src="https://dl.dropboxusercontent.com/scl/fi/g9sebyrjayw2bvj138c6x/Screenshot-at-19-11-48.png?rlkey=zobgn65r4avzgkl8frcisvn8j">

*Exemple de l'édition d'un texte contenu dans un blocs*
<img src="https://github.com/BDoryan/dodocms-mvc/blob/master/docs/live-edit-example.gif?raw=true">

Vous êtes curieux de savoir comment créer un bloc ? Rendez-vous à la section [Création d'un bloc](#create-a-block).

### Gestion des utilisateurs

Si vous travaillez à plusieurs sur le site internet ou si vous souhaitez donner des accès à des personnes extérieures,
vous pouvez gérer les utilisateurs dans l'interface d'admin istration. Vous avez la possibilité de créer des comptes
utilisateurs.

> Important : la création d'un compte donne plein accès à l'interface d'administration. Il est donc important de ne
> donner des accès qu'aux personnes de confiance. Bien évidemment, je travaille activement sur la mise en place d'un
> système de gestion des permissions pour limiter l'accès à certaines fonctionnalités.

<img src="https://dl.dropboxusercontent.com/scl/fi/m4eyakcmyqk02v30dliv1/Screenshot-at-19-47-25.png?rlkey=4nhzgu32jtje19lxfofw2wj88" />

## Fonctionnalités en tant que développeur

### Routage

### Modèle

### Gestionnaire de base de données

### Vue

### Contrôleur

## Création de bloc 