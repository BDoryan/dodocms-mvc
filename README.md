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
    <a href="https://github.com/BDoryan/dodocms-mvc/issues">Report an issue</a>
    ·
    <a href="https://github.com/BDoryan/dodocms-mvc/issues">Submit a suggestion</a>
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
4. [Administrator features](#developer-features)
    1. [Page creation](#create-a-block)
    2. [Composing a page](#create-a-page)
    3. [User management](#user-management)
    4. [Block management](#block-management)
5. [Page management](#page-management)
6. [Developer features](#developer-features)
    1. [Routing](#routing)
    2. [Model](#model)
    3. [View](#view)
    4. [Controller](#controller)
    5. [Block creation](#block-creation)

## Introduction

<div id="introduction">
Welcome to the technical documentation of the DodoCMS project. The purpose of this document is to guide you as much as possible in using this CMS.

It is important to note that this document is intended for both administrators and developers. At times, explanations may go into detail in order to be as clear as possible. If the code is not relevant to you, feel free to skip those parts.

### Project context (fictional)

This project was created to meet the needs of a web agency. The goal was to address their main challenge: creating websites more easily and quickly while making content editing accessible for their clients.

The agency chose to develop its own CMS to retain ownership and to build a tool tailored to web developers. In fact, beyond being just a CMS, this tool is also a framework that brings together various tools for building websites.  
CMS: Content Management System  
Framework: A code base, a structure, a toolbox  
</div>

## Technologies

<div id="technologies">
The choice of technologies used for this project was carefully considered. It was important to select modern technologies to meet the agency’s requirements.

### List of technologies used

- HTML, CSS & JS: Essential languages for building websites.
- jQuery: Used to simplify DOM manipulation.
- PHP (7.4 >= 8.4): Chosen for the backend as it remains widely used today.
- Vue.js: Based on experience with React.js and Next.js, it was important to simplify the integration of dynamic JavaScript elements.
- TailwindCSS: Enables faster UI development.
- FontAwesome: Used to enhance visual appeal with icons.
- MariaDB: Relational database
</div>

## Setting up the system

### Prerequisites

- Web server running <strong>Apache</strong>
- <strong>PHP</strong> 7.4 or higher with extensions <strong>php-curl, php-xml, php-zip, php-json, php-pdo, php-pdo_mysql</strong>
- <strong>MariaDB</strong> 10.5 or higher
- <strong>Composer</strong>
- <strong>npm</strong> (if you want to modify TailwindCSS)

### Installation

1. Download the project from GitHub  
2. Extract the files into your web server directory  
3. Copy the `.htaccess` file from GitHub to the root of your web server (if not already present)  
4. Install PHP dependencies with Composer `composer install`  
5. You can now access your website and should see an installation form  

> Warning: file and folder permissions must be properly configured to avoid issues during installation.  

> Note: If you encounter issues, feel free to open an issue on the GitHub project.  

### Installation with the graphical interface

#### 1. Database creation

At this step, you must provide your database connection details. It is recommended that the database does not already exist to avoid issues.

#### 2. Administrator account creation

Once the database is created, you must enter the credentials for your administrator account to access the admin interface.

#### 3. Installation completed

After completing all steps, you should see a confirmation message. Before accessing the admin interface, you must delete the `install` folder at the root of your site.

### Advanced configuration

To configure the CMS in more detail, edit the `config/application.json` file from the root directory.

You can modify:

- `password_policy`: Regex for password rules  
- `jwt`: JWT authentication settings  
- `image_quality`: Image optimization quality  
- `admin_path`: Admin panel path  
- `mysql`: Database configuration  
- `modules`: Module configuration  
- `theme`: Active theme  

## Keeping the system up to date

The update system is not fully complete yet, but you can still update the CMS manually.

> ⚠ Warning: all files in the `/core` folder will be deleted and replaced. Any modifications will be lost.

> Recommendation: always back up your files and database before updating.

## Administrator features

### Page creation

Page creation is a core CMS feature. It allows building a page using predefined blocks.

To create a page, go to the admin interface → "Pages" section and fill in:

- Page name  
- SEO title  
- SEO description  
- SEO keywords  
- Page icon  
- Page route  

You will then get a blank page ready to be built using blocks via live editing.

### Composing a page

Pages are built using blocks that can be added, edited, or removed.

- Click "+" to add a block  
- Customize text and media  

> Note: changes are not automatically saved (except block movement). Click "Save" to persist changes.  

> Warning: deleting a block removes all its content permanently.  

### User management

You can create user accounts to grant access to others.

> Important: users have full admin access. Only grant access to trusted people.

## Developer features

### Routing

Routing allows you to manage URLs and direct users to the correct pages.

```php
Application::get()->getRouter()->get("/helloworld/", function () {
    echo "Hello world";
});
````

### Model

Models handle database interaction and data retrieval.

They must extend the `Model` class.

### View

Views handle the display (HTML + PHP).

They should not contain business logic.

### Controller

Controllers handle business logic and user actions.

They must extend the `Controller` class.

### Block creation

A block is a visual component (text, images, etc.) that can be added to a page.

To create one:

1. Create a `.php` file in the `blocks/` folder
2. Define editable elements using `editable` attributes
3. Register it in the admin interface

You can also bind data using controllers like `BlockController`, `StructureController`, or `PageController`.
