<!-- PROJECT LOGO -->
<br />
<div align="center">
  <a href="https://github.com/BDoryan/dodocms-mvc">
    <img src="https://i.ibb.co/tzw8HHt/Microsoft-Fluentui-Emoji-3d-Dodo-3d-1024-2.png" alt="Logo" width="80" height="80">
  </a>

<h3 align="center"><strong>DodoCMS</strong></h3>

  <p align="center">
    La facilité de développer des solutions avec une gestion de contenu simplifiée.
    <br />
    <a href="https://github.com/BDoryan/dodocms-mvc">Visiter le projet</a>
    ·
    <a href="https://github.com/BDoryan/dodocms-mvc/issues">Je rencontre un problème</a>
    ·
    <a href="https://github.com/BDoryan/dodocms-mvc/issues">Laisser une proposition</a>
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
4. [Fonctionnalités en tant qu'administrateur](#fonctionnalités-de-développeur)
    1. [Création de page](#create-a-block)
    2. [Composer une page](#créer-une-page)
    3. [Gestion des utilisateurs](#gestion-des-utilisateurs)
    4. [Gestion des blocs](#gestion-des-blocs)
5. [Gestion des pages](#gestion-des-pages)
6. [Fonctionnalités en tant que développeur](#fonctionnalités-de-développeur)
    1. [Routage](#routage)
    2. [Modèle](#modèle)
    3. [Vue](#vue)
    4. [Contrôleur](#contrôleur)
    5. [Création d'un bloc](#création-d'un-bloc)

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

<span id="prérequis"></span>

### Prérequis

- Serveur web sous <strong>Apache</strong>
- <strong>PHP</strong> 7.4 ou supérieur avec ses extensions <strong>php-curl, php-xml, php-zip, php-json, php-pdo,
  php-pdo_mysql</strong>
- <strong>MariaDB</strong> 10.5 ou supérieur
- <strong>Composer</strong>
- <strong>npm</strong> (Si vous souhaitez faire des modifications avec TailwindCSS)

<span id="installation"></span>

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

<span id="installation-avec-l'interface-graphique"></span>

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

<span id="configuration-approfondie"></span>

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

<span id="mettre-en-place-le-système"></span>

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

<span id="fonctionnalités-de-développeur"></span>

## Fonctionnalités en tant qu'administrateur

<span id="create-a-block"></span>

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

<span id="créer-une-page"></span>

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

<span id="gestion-des-utilisateurs"></span>

### Gestion des utilisateurs

Si vous travaillez à plusieurs sur le site internet ou si vous souhaitez donner des accès à des personnes extérieures,
vous pouvez gérer les utilisateurs dans l'interface d'admin istration. Vous avez la possibilité de créer des comptes
utilisateurs.

> Important : la création d'un compte donne plein accès à l'interface d'administration. Il est donc important de ne
> donner des accès qu'aux personnes de confiance. Bien évidemment, je travaille activement sur la mise en place d'un
> système de gestion des permissions pour limiter l'accès à certaines fonctionnalités.

<img src="https://dl.dropboxusercontent.com/scl/fi/m4eyakcmyqk02v30dliv1/Screenshot-at-19-47-25.png?rlkey=4nhzgu32jtje19lxfofw2wj88" />

<span id="gestion-des-blocs"></span>

## Fonctionnalités en tant que développeur

<span id="routage"></span>

### Routage

Le routage est une fonctionnalité qui permettre de gérer les différentes routes de votre site internet. Cela permet de
rediriger les utilisateurs vers la bonne page en fonction de l'URL demandée.

> Note : Le routage pour les pages est nativement géré par le CMS. Vous n'avez pas besoin de vous en occuper. Cependant,
> si vous souhaitez ajouter des routes personnalisées, vous pouvez le faire en intégrant du code dans le fichier
> `index.php` à la racine du site.

```php
// Simple route sans paramètre dans l'URL
Application::get()->getRouter()->get("/helloworld/", function () {
    echo "Hello world";
});
```

<img src="https://dl.dropboxusercontent.com/scl/fi/3t5uy4641dbbbgpobu7b2/Screenshot-at-20-11-58.png?rlkey=fzq1k8r4man224o6s1zy3mu64">

```php
// Route avec paramètre dans l'URL
Application::get()->getRouter()->get("/helloworld/{dodo}", function (array $parameters) {
    echo "Hello world " . $parameters['dodo'];
});
```

<img src="https://dl.dropboxusercontent.com/scl/fi/x7egzz5u14hy1h33wifum/Screenshot-at-20-11-26.png?rlkey=j8f8hyn5uxzvjwg539jwinzag">

<span id="modèle"></span>

### Gestionnaire de base de données

#### MLD (Modèle Logique de Données)

<img src="https://dl.dropboxusercontent.com/scl/fi/a76c961y9lwd09mgvvphq/Screenshot-at-23-57-43.png?rlkey=4i9etgbzkpalqvx56weoknork" />

#### Modèle

Les modèles sont des classes qui permettent de gérer les données de votre site internet. Ils sont utilisés pour
interagir avec la base de donnée et récupérer des informations.

> Note : Les modèles sont des classes qui doivent hériter de la classe `Model` pour pouvoir être utilisés.

#### Création d'un modèle

Pour créer un modèle, vous devez aller dans la section `Gestion des tables` de l'interface d'administration et cliquer
sur le bouton
"Créer une table". Vous aurez alors un formulaire vous permettant de créer une table. Vous devrez renseigner les
attributs de la table (nom, type, taille, clé primaire, auto-incrément, etc.).

<img src="https://dl.dropboxusercontent.com/scl/fi/spkqyr4gms3mbmrk1ywt9/Screenshot-at-19-45-24.png?rlkey=hzqxerzu6gebatzwuyidgsr78" />

##### Exemple d'un modèle

*UserModel.php*

```php
class UserModel extends Model
{
    
    const TABLE_NAME = "users";
    
    private string $username;
    private string $email;

    public function __construct(string $username, string $email) {
        $this->username = $username;
        $this->email = $email;
    }
    
    /**
     * @return string
     */
     public  function getUsername(): string
    {
        return $this->username;
    }
    
    /**
     * @param string $username
     */
     public  function setUsername(string $username):void 
    {
        $this->username = $username;
    }
    
    /**
     * @return string
     */
     public  function getEmail(): string
    {
        return $this->email;
    }
    
    /**
     * @param string $email
     */
     public  function setEmail(string $email):void 
    {
        $this->email = $email;
    }
    
    /**
     * Return all fields of the model
     *
     * @return array
     */
    public function getFields(): array
    {
        $fields = parent::getFields();
        $fields["username"] = [
            "size" => "tw-w-5/12",
            "field" => Text::create()
                ->name("username")
                ->label(__('admin.panel.users.username'))
                ->value($this->getUsername() ?? "")
                ->validator()
                ->required(),
        ];
        $fields["email"] = [
            "size" => "tw-w-7/12",
            "field" => Text::create()
                ->type('email')
                ->validator()
                ->name("email")
                ->label(__('admin.panel.users.email'))
                ->value($this->getEmail() ?? "")
                ->required(),
        ];
        return $fields;
    }
    
    public static function findAll(string $columns = '*', array $conditions = [], $orderBy = ''): ?array
    {
        return (new UserModel())->getAll($columns, $conditions, $orderBy);
    }
}
```

<span id="vue"></span>

### Vue

Les vues permettent de gérer l'affichage du DOM de votre site internet. Elles sont utilisées pour afficher les
informations récupérées par les modèles.

Les vues sont des fichiers `.php` qui contiennent du code HTML et PHP. Elles peuvent être incluses dans d'autres vues
pour faciliter la réutilisation du code.

> ⚠ Attention, il est important de ne pas mettre de logique métier dans les vues. Les vues doivent uniquement servir à
> l'affichage des données.

#### Création d'une vue

Pour créer une vue, vous devez créer un fichier `.php` dans le dossier de votre choix (par exemple `views/`).

Pour appeler une vue, vous pouvez utiliser la fonction `fetch` qui permet de récupérer le contenu de la vue ou
sinon vous pouvez simplement faire appel à la fonction `view` qui permet de rendre la vue (fait un echo).

*Exemple d'une vue*

```php
$router = Application::get()->getRouter();

// Création de votre route avec méthod GET site.fr/ma-route
$router->get('/ma-route', function () {
    // Si la route est appelé ce code sera éxécuté

    // Chemin de ma vue à partir de la racine du projet (site)
    $vue = Application::get()->toRoot('/mon-dossier-avec-mes-vues/ma-vue.php');

    // Vous avez aussi la possibilité de récupérer le contenu de la vue
    $vue_html = fetch($vue, [
        'example' => 'My example'
    ]);

    // Vous pouvez aussi la rendre en fessant un simple echo
    echo $vue_html;
});
```

<span id="contrôleur"></span>

### Contrôleur

Les contrôleurs sont des classes qui permettent de gérer la logique métier de votre site internet. Ils sont utilisés
pour
gérer les actions de l'utilisateur et interagir avec les modèles. Les contrôleurs sont appelés par les routes.

> Note : Les contrôleurs sont des classes qui doivent hériter de la classe `Controller` pour pouvoir être utilisés.

#### Création d'un contrôleur

Pour créer un contrôleur, vous devez créer une classe qui hérite de la classe `Controller` et qui contient des méthodes
qui correspondent aux actions de la classe.

*Exemple d'un contrôleur*

```php
class UserController extends SectionController
{
    public function index()
    {
        // Code pour afficher la liste des utilisateurs
    }
}
```

<span id="création-d-un-bloc"></span>

#### Création d'un bloc

Un bloc est un élément visuel qui peut être ajouté à une page. Il est composé de plusieurs éléments (textes, images,
vidéos, etc.) qui peuvent être personnalisés par l'administrateur. Les blocs sont créés par les développeurs et peuvent
être ajoutés à une page.

Pour créer un bloc, vous devez créer un fichier `.php` dans le dossier `blocks/` de votre thème. Ce fichier doit
contenir
du code HTML et PHP qui permet d'afficher le bloc. Une fois que vous avez créé le fichier,
vous devez créer le bloc depuis l'interface d'administration dans la section "Blocs".

<img src="https://dl.dropboxusercontent.com/scl/fi/6xzs8i8nx5nhvo2lhytcl/Screenshot-at-20-40-33.png?rlkey=wlzlw2xs11upjkyyo4y4o9msc" />

*Exemple d'un bloc*

```php
<div class="d-flex flex-column text-center">
    <div>
        <h2 editable="title">À propos</h2>
        <p editable="subtitle" class="text-center text-light">Apprenez-en un peu plus sur moi.</p>
    </div>
    <div class="separator"></div>
</div>
```

> Lorsque vous rédigez un bloc, vous pouvez ajouter des attributs `editable` aux éléments HTML pour permettre à
> l'administrateur de personnaliser le contenu du bloc.

*Exemple d'un bloc avec des éléments éditables*

```php 
<div class="col-12 col-lg-5">
    <div class="row gy-2">
        <?php
        /** @var SkillModel $skill */
        foreach ($skills ?? [] as $skill) {
            ?>
            <div entity-id="<?= $skill->getId() ?>"
                 class="col-12 mb-3">
                <h4 class="lh-1 text-start mb-2 d-flex gap-2 roboto-regular" style="text-transform: none">
                    <i class="<?= $skill->getIcon() ?>"></i>
                    <span editable-model="name"><?= $skill->getName() ?></span>
                </h4>
                <div class="bg-white progress" role="progressbar"
                     aria-valuenow="<?= $skill->getProgression() ?>"
                     aria-valuemin="0" aria-valuemax="100">
                    <div class="progress-bar" style="width: <?= $skill->getProgression() ?>%;"></div>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</div>
```

> Lorsque vous rédigez un bloc avec des éléments éditables, vous pouvez ajouter des attributs `editable-model`
> avec le nom de l'attribut du modèle associé à l'élément HTML. En suite, vous pouvez ajouter un attribut `entity-id`
> pour permettre au CMS de savoir quel élément est modifié.

#### Passer des données à un bloc

La mise en place de contrôleurs va vous permettre de gérer le traitement de vos données et l’affichage de vos vues.
Prenez en compte que lorsque vous allez créer un bloc, vous avez la possibilité de lui attribuer ses contrôleurs soit en
vous basant sur de l'identifiant du bloc, l’identifiant du bloc affiche dans la page (la structure) et enfin par
l’identifiant de la page.

Les classes des contrôleurs : `BlockController`, `StructureController` et `PageController`.

*Exemple d’un contrôleur pour un bloc spécifique*

```php
<?php
class FeaturesController extends BlockController
{
    public function __construct()
    {
        parent::__construct(14); // Identifiant du bloc
    }


    public function data(): array
    {
        return [
            'features' => FeaturesModel::findAll('*', ['active' => 1])
        ];
    }
}

ControllerManager::registerController(new FeaturesController());
```

> ⚠ Faites attention à bien enregistrer votre contrôleur dans le `ControllerManager` pour qu’il soit pris en compte.

