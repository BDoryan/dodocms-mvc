<!-- PROJECT LOGO -->

<br />
<div align="center">
  <a href="https://github.com/BDoryan/dodocms-mvc">
    <img src="https://i.ibb.co/tzw8HHt/Microsoft-Fluentui-Emoji-3d-Dodo-3d-1024-2.png" alt="Logo" width="80" height="80">
  </a>

<h3 align="center"><strong>DodoCMS</strong></h3>

  <p align="center">
    Simplifying the development of solutions with streamlined content management.
    <br />
    <a href="https://github.com/BDoryan/dodocms-mvc">View Project</a>
    ·
    <a href="https://github.com/BDoryan/dodocms-mvc/issues">Report an Issue</a>
    ·
    <a href="https://github.com/BDoryan/dodocms-mvc/issues">Submit a Suggestion</a>
  </p>
</div>

# Technical Documentation

## Table of Contents

1. [Introduction](#introduction)
2. [Technologies](#technologies)
3. [Setup](#setup)

   1. [Prerequisites](#prerequisites)
   2. [Installation](#installation)
   3. [Installation with GUI](#installation-with-gui)
   4. [Advanced Configuration](#advanced-configuration)
   5. [Keeping the System Updated](#keeping-the-system-updated)
4. [Admin Features](#admin-features)

   1. [Page Creation](#create-a-block)
   2. [Page Composition](#create-a-page)
   3. [User Management](#user-management)
   4. [Block Management](#block-management)
5. [Page Management](#page-management)
6. [Developer Features](#developer-features)

   1. [Routing](#routing)
   2. [Model](#model)
   3. [View](#view)
   4. [Controller](#controller)
   5. [Block Creation](#block-creation)

## Introduction

Welcome to the technical documentation of the DodoCMS project. The purpose of this document is to guide you as much as possible in using this CMS.

This document is intended for both administrators and developers. At times, detailed explanations are provided to ensure clarity. If the code does not interest you, feel free to skip those parts.

### Project Context (fictional)

This project was created to meet the needs of a web agency. The goal was to simplify and speed up website creation while making content editing easy and accessible for clients.

The agency chose to develop its own CMS to maintain ownership and provide a tool tailored for web developers. Beyond being a CMS, this tool is also a framework offering various utilities for building websites.

* CMS: Content Management System
* Framework: A codebase, structure, and toolbox

## Technologies

The technology choices for this project were carefully considered to meet modern requirements.

### Technologies used

* HTML, CSS & JS: essential for building websites
* jQuery: simplifies DOM manipulation
* PHP (7.4 ≥ 8.4): backend language, widely used
* Vue.js: enables dynamic frontend integration
* TailwindCSS: fast UI development
* FontAwesome: icons for better UX
* MariaDB: relational database

## Setup

### Prerequisites

* Apache web server
* PHP 7.4+ with extensions: curl, xml, zip, json, pdo, pdo_mysql
* MariaDB 10.5+
* Composer
* npm (for TailwindCSS modifications)

### Installation

1. Download the project from GitHub
2. Extract it into your web server directory
3. Copy the `.htaccess` file to the root if needed
4. Install PHP dependencies: `composer install`
5. Access the site to start the installation wizard

## Installation with GUI

### 1. Database setup

Enter your database credentials. It is recommended to use a fresh database.

### 2. Admin account creation

Set up your administrator account credentials.

### 3. Installation complete

Delete the `install` folder before accessing the admin panel.

## Advanced Configuration

Edit `config/application.json`:

* password policy
* JWT settings
* image quality
* admin path
* database credentials
* modules
* theme

## Keeping the System Updated

Updating replaces all files in `/core`. Custom changes in this folder will be lost.
Always backup files and database before updating.

## Admin Features

### Page Creation

Create pages via the admin panel with:

* Name
* SEO title
* SEO description
* Keywords
* Favicon
* Route

### Page Composition

Pages are built using blocks that can be added, edited, or removed.
Changes must be saved manually (except block positioning).

### User Management

Create and manage user accounts.
All users have full admin access (permission system planned).

## Developer Features

### Routing

Custom routes can be defined in `index.php`.

### Model

Models manage database data and must extend `Model`.

### View

Views are `.php` files combining HTML and PHP.
They should not contain business logic.

### Controller

Controllers handle business logic and extend `Controller`.

### Block Creation

Blocks are reusable UI components stored in `/blocks/`.
They can include editable attributes for dynamic content.

Example:

```php
<h2 editable="title">About</h2>
```
