<!-- PROJECT LOGO -->
<br />
<div align="center">
  <a href="https://github.com/BDoryan/dodocms-mvc">
    <img src="https://i.ibb.co/tzw8HHt/Microsoft-Fluentui-Emoji-3d-Dodo-3d-1024-2.png" alt="Logo" width="80" height="80">
  </a>

<h3 align="center"><strong>DodoCMS</strong></h3>

  <p align="center">
    The ease of developing solutions with simplified content management.
    <br />
    <a href="https://github.com/BDoryan/dodocms-mvc">Visit the project</a>
    ·
    <a href="https://github.com/BDoryan/dodocms-mvc/issues">I have an issue</a>
    ·
    <a href="https://github.com/BDoryan/dodocms-mvc/issues">Make a suggestion</a>
  </p>
</div>

# Technical Documentation

## Table of Contents

1. [Introduction](#introduction)
2. [Technologies](#technologies)
3. [Setting up the system](#setting-up-the-system)
    1. [Prerequisites](#prerequisites)
    2. [Installation](#installation)
    3. [Installation with the graphical interface](#installation-with-the-graphical-interface)
    4. [Advanced configuration](#advanced-configuration)
    5. [Keeping the system up to date](#keeping-the-system-up-to-date)
4. [Features as an administrator](#features-as-an-administrator)
    1. [Page creation](#create-a-block)
    2. [Composing a page](#composing-a-page)
    3. [User management](#user-management)
    4. [Block management](#block-management)
5. [Page management](#page-management)
6. [Features as a developer](#features-as-a-developer)
    1. [Routing](#routing)
    2. [Model](#model)
    3. [View](#view)
    4. [Controller](#controller)
    5. [Creating a block](#creating-a-block)

## Introduction

<div id="introduction">
Welcome to the technical documentation of the DodoCMS project. The purpose of this document is to guide you as much as possible in using this CMS.

It is important to know that this document is intended for both administrators and developers. Indeed, sometimes I will go into detail in the explanations, the idea is to be as clear as possible. If the code means nothing to you or is of no interest, do not dwell on it.

### Project context (fictional)

This project was carried out to meet the needs of a web agency. The goal was to address the main issue of creating websites simply and more quickly while making content editing easy for their clients.

The web agency chose to develop their own CMS to be the owner but also to develop a tool that speaks to web developers. Indeed, before being a simple CMS, this tool is also a framework bringing together different tools for designing a website.
CMS: Content Management System
Framework: A code base, a structure, a toolbox
</div>

## Technologies

<div id="technologies">
The choice of technologies used for this project was carefully considered. Indeed, it was important to choose modern technologies to meet the needs of the web agency.

### List of technologies used

- HTML, CSS & JS: These languages are essential when it comes to designing websites.
- jQuery: I decided to use this library to facilitate DOM manipulation.
- PHP (7.4 >= 8.4): I decided to use this language for the backend, as it remains the most widely used today.
- Vue.js: Drawing on my experience with technologies such as React.js and Next.js, I considered it essential to facilitate the integration of dynamic elements in JavaScript, hence my choice of Vue.js.
- TailwindCSS: My goal was to regain the development speed of a graphical framework to quickly create a visual interface, even if it is not the current priority.
- FontAwesome: To create a minimally pleasant visual (in my eyes), I wanted to implement icons so that it speaks more to the user.
- MariaDB: Relational database

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

## Setting up the system

<span id="prerequisites"></span>

### Prerequisites

- Web server running **Apache**
- **PHP** 7.4 or higher with extensions **php-curl, php-xml, php-zip, php-json, php-pdo, php-pdo_mysql**
- **MariaDB** 10.5 or higher
- **Composer**
- **npm** (If you want to make changes with TailwindCSS)

<span id="installation"></span>

### Installation

1. Download the project from GitHub
2. Extract the file in your web server directory
3. Copy the `.htaccess` file from GitHub to the root of your web server (if it is not already present after extraction)
4. Install PHP dependencies with Composer `composer install`
5. Now, you can access your website and you should see an installation form

> Warning, file and folder permissions must be correctly configured to avoid any problems during installation.

> Note: If you have problems during installation, do not hesitate to open an issue on the GitHub project.

<span id="installation-with-the-graphical-interface"></span>

### Installation with the graphical interface

#### 1. Database creation

During this step, you will need to provide your database connection information. It is preferable that the database does not already exist to avoid any problems.
<br>
<br>
<img width="500" src="https://dl.dropboxusercontent.com/scl/fi/m8mqb7t178lv747ulc2g6/Screenshot-at-00-27-21.png?rlkey=0s4e17oqqd6lcsp9d5kuh9xei"/>

#### 2. Administrator account creation

Once the database is created, you will need to provide the login information for your administrator account in order to access the administration interface.
<br>
<br>
<img width="500" src="https://dl.dropboxusercontent.com/scl/fi/vmzwuo6ceyhdlbopm70md/Screenshot-at-00-28-59.png?rlkey=jso5mpoyvlj8pv7bhxbq68i7r"/>

#### 3. Installation complete

Once you have provided all the information, you should see a confirmation message indicating that the installation is complete. But before you can access the administration interface, you will need to delete the `install` folder at the root of your website.

<span id="advanced-configuration"></span>

### Advanced configuration

If you want to configure the CMS in more detail, you can modify the `config/application.json` file from the root of the site. This file contains all the CMS configuration information.

You can modify the following information:

- `password_policy`: Regular expression for password policy (default: minimum 8 characters, 1 letter, 1 number and 1 special character)
- `jwt`: JWT (Json Web Token) configuration for authentication (secret key and expiration)
- `image_quality`: Quality of images during optimization (default: 80)
- `admin_path`: Path to access the administration interface (default: `admin123`)
- `mysql`: MySQL database configuration (host, user, database, password)
- `modules`: Module configuration (currently disabled by default)
- `theme`: Theme used by the CMS (refers to the folder in `/themes/default/`)

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

<span id="setting-up-the-system"></span>

## Keeping the system up to date

The update system is not yet finalized, but you still have the possibility to update the CMS.

> ⚠ Warning, you should know that during the update all files in the `/core` folder will be deleted and replaced by the new version of the system. **This means that if you have made changes in this folder, they will be lost.**

> Tip: Before updating the CMS, make sure you have a backup of your files and your database to avoid unpleasant surprises.

Of course, I am actively working on setting up a more secure and simpler update system to avoid all these manipulations.
The goal is to make the administrator experience as pleasant as possible.

<img src="https://dl.dropboxusercontent.com/scl/fi/dus2225kx7no31td3oboe/Screenshot-at-00-55-30.png?rlkey=wmm2e21oezpq68j7k0zscjdtr" />

<span id="features-as-an-administrator"></span>

## Features as an administrator

<span id="create-a-block"></span>

### Page creation

Page creation is an essential feature for a CMS. It allows you to compose a page from predefined blocks. These blocks are visuals developed by a developer and can be customized by the administrator.

To create a page, simply go to the administration interface in the "Pages" section and you will have a form allowing you to create a new page. The creation of this page is done in several steps:

- Page name
- SEO title (page title tag)
- SEO description (page meta description tag)
- SEO keywords (page meta keywords tag)
- Page icon (favicon)
- Page route (path after the domain name)

Once you have provided this information, you will have a blank page ready to be composed with blocks using live-edit.

<img src="https://dl.dropboxusercontent.com/scl/fi/x238usmd9e7upsvzlqphj/Screenshot-at-19-10-13.png?rlkey=vrmqv1lnqxsk7hd3vku15gkv9" />

<span id="composing-a-page"></span>

### Composing a page

Page composition is done using blocks that you can add, modify, and delete. These blocks are visual elements that can be customized only if the developer has planned for it.

When you are on a page, you have the possibility to click on the "+" button to add a block to the page. You will then have a list of available blocks that you can add to the page. Once you have added a block, you can customize the texts and media inside it.

> 💾 Note: You should know that your content modifications are not saved automatically. You must click the "Save" button to save your changes. **Except for block movements**, modifications are instantly saved.

> ⚠ Warning: If you delete a block, you will lose all the modifications you have made inside it. It is therefore important to be careful before deleting a block.

*Live-edit example*
<img src="https://dl.dropboxusercontent.com/scl/fi/g9sebyrjayw2bvj138c6x/Screenshot-at-19-11-48.png?rlkey=zobgn65r4avzgkl8frcisvn8j">

*Example of editing text contained in a block*
<img src="https://github.com/BDoryan/dodocms-mvc/blob/master/docs/live-edit-example.gif?raw=true">

Are you curious to know how to create a block? Go to the section [Creating a block](#creating-a-block).

<span id="user-management"></span>

### User management

If you work with several people on the website or if you want to give access to external people, you can manage users in the administration interface. You have the possibility to create user accounts.

> Important: creating an account gives full access to the administration interface. It is therefore important to only give access to trusted people. Of course, I am actively working on setting up a permission management system to limit access to certain features.

<img src="https://dl.dropboxusercontent.com/scl/fi/m4eyakcmyqk02v30dliv1/Screenshot-at-19-47-25.png?rlkey=4nhzgu32jtje19lxfofw2wj88" />

<span id="block-management"></span>

## Features as a developer

<span id="routing"></span>

### Routing

Routing is a feature that allows you to manage the different routes of your website. This allows you to redirect users to the correct page based on the requested URL.

> Note: Routing for pages is natively managed by the CMS. You do not need to worry about it. However, if you want to add custom routes, you can do so by integrating code into the `index.php` file at the root of the site.

```php
// Simple route without parameter in the URL
Application::get()->getRouter()->get("/helloworld/", function () {
    echo "Hello world";
});
```

<img src="https://dl.dropboxusercontent.com/scl/fi/3t5uy4641dbbbgpobu7b2/Screenshot-at-20-11-58.png?rlkey=fzq1k8r4man224o6s1zy3mu64">

```php
// Route with parameter in the URL
Application::get()->getRouter()->get("/helloworld/{dodo}", function (array $parameters) {
    echo "Hello world " . $parameters['dodo'];
});
```

<img src="https://dl.dropboxusercontent.com/scl/fi/x7egzz5u14hy1h33wifum/Screenshot-at-20-11-26.png?rlkey=j8f8hyn5uxzvjwg539jwinzag">

<span id="model"></span>

### Database manager

#### LDM (Logical Data Model)

<img src="https://dl.dropboxusercontent.com/scl/fi/a76c961y9lwd09mgvvphq/Screenshot-at-23-57-43.png?rlkey=4i9etgbzkpalqvx56weoknork" />

#### Model

Models are classes that allow you to manage the data of your website. They are used to interact with the database and retrieve information.

> Note: Models are classes that must inherit from the `Model` class to be used.

#### Creating a model

To create a model, you must go to the `Table Management` section of the administration interface and click on the "Create a table" button. You will then have a form allowing you to create a table. You will need to provide the table attributes (name, type, size, primary key, auto-increment, etc.).

<img src="https://dl.dropboxusercontent.com/scl/fi/spkqyr4gms3mbmrk1ywt9/Screenshot-at-19-45-24.png?rlkey=hzqxerzu6gebatzwuyidgsr78" />

##### Example of a model

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

<span id="view"></span>

### View

Views allow you to manage the display of the DOM of your website. They are used to display the information retrieved by the models.

Views are `.php` files that contain HTML and PHP code. They can be included in other views to facilitate code reuse.

> ⚠ Warning, it is important not to put business logic in the views. Views should only be used to display data.

#### Creating a view

To create a view, you must create a `.php` file in the folder of your choice (for example `views/`).

To call a view, you can use the `fetch` function which allows you to retrieve the content of the view or you can simply call the `view` function which allows you to render the view (does an echo).

*Example of a view*

```php
$router = Application::get()->getRouter();

// Create your route with GET method site.fr/my-route
$router->get('/my-route', function () {
    // If the route is called, this code will be executed

    // Path to my view from the project root (site)
    $view = Application::get()->toRoot('/my-folder-with-my-views/my-view.php');

    // You also have the possibility to retrieve the content of the view
    $view_html = fetch($view, [
        'example' => 'My example'
    ]);

    // You can also render it by doing a simple echo
    echo $view_html;
});
```

<span id="controller"></span>

### Controller

Controllers are classes that allow you to manage the business logic of your website. They are used to manage user actions and interact with models. Controllers are called by routes.

> Note: Controllers are classes that must inherit from the `Controller` class to be used.

#### Creating a controller

To create a controller, you must create a class that inherits from the `Controller` class and contains methods that correspond to the class actions.

*Example of a controller*

```php
class UserController extends SectionController
{
    public function index()
    {
        // Code to display the list of users
    }
}
```

<span id="creating-a-block"></span>

#### Creating a block

A block is a visual element that can be added to a page. It is composed of several elements (texts, images, videos, etc.) that can be customized by the administrator. Blocks are created by developers and can be added to a page.

To create a block, you must create a `.php` file in the `blocks/` folder of your theme. This file must contain HTML and PHP code that allows you to display the block. Once you have created the file, you must create the block from the administration interface in the "Blocks" section.

<img src="https://dl.dropboxusercontent.com/scl/fi/6xzs8i8nx5nhvo2lhytcl/Screenshot-at-20-40-33.png?rlkey=wlzlw2xs11upjkyyo4y4o9msc" />

*Example of a block*

```php
<div class="d-flex flex-column text-center">
    <div>
        <h2 editable="title">About</h2>
        <p editable="subtitle" class="text-center text-light">Learn a little more about me.</p>
    </div>
    <div class="separator"></div>
</div>
```

> When writing a block, you can add `editable` attributes to HTML elements to allow the administrator to customize the content of the block.

*Example of a block with editable elements*

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

> When writing a block with editable elements, you can add `editable-model` attributes with the name of the associated model attribute to the HTML element. Then, you can add an `entity-id` attribute to allow the CMS to know which element is being modified.

#### Passing data to a block

Setting up controllers will allow you to manage the processing of your data and the display of your views. Keep in mind that when you create a block, you have the possibility to assign its controllers either based on the block identifier, the block identifier displayed on the page (the structure), or the page identifier.

Controller classes: `BlockController`, `StructureController` and `PageController`.

*Example of a controller for a specific block*

```php
<?php
class FeaturesController extends BlockController
{
    public function __construct()
    {
        parent::__construct(14); // Block identifier
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

> ⚠ Be careful to register your controller in the `ControllerManager` so that it is taken into account.
