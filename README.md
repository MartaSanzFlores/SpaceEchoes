
# 🚀 SpaceEchoes Backend Symfony

## Description

This repository contains the **backend** for the SpaceEchoes web application. It is built using the Symfony framework and provides a RESTful API consumed by a separate React frontend.

The backend handles core features such as article management, image browsing, user interactions (likes, comments), and administrative moderation. It uses Doctrine ORM with MySQL for data persistence, and Twig/Bootstrap for rendering the admin panel.

The full application is the result of a collaborative one-month project involving four developers: two backend and two frontend. Development is ongoing to extend functionality and improve the overall system.

## Functional Overview

- **Articles Section**  
  Provides a collection of astronomy-related articles. Users can read, comment on, and report inappropriate comments. Admins can moderate these through the back-office.

- **Image Gallery**  
  Displays a gallery of captivating space images. Users can like and explore each image in detail.

- **Admin Back-Office**  
  Built with Twig and styled using Bootstrap, this panel allows administrators to review and moderate user content.

## Technologies Used

- **Framework**: Symfony 5 (tested with PHP 7.4)  
- **Templating**: Twig (admin interface)  
- **ORM**: Doctrine  
- **Database**: MySQL  
- **Styling**: Bootstrap  
- **Security**: JWT Authentication, Role-based access control  
- **API**: RESTful, consumed by a React frontend  
- **Tools**: Symfony CLI, Composer, Doctrine Migrations

## Core Features

- [x] JWT-based authentication
- [x] Role-based access control (`ROLE_USER`, `ROLE_ADMIN`)
- [x] Astronomy article browsing, commenting, and moderation
- [x] Space image gallery with like functionality
- [x] Admin dashboard for managing comments and reports

## Prerequisites

- PHP >= 7.2.5 (Symfony 5 or newer)  
- Composer  
- MySQL or MariaDB  
- Symfony CLI (optional)  
- Node.js & npm (only required if working with the frontend)  

## Getting Started

### 1. Clone the Repository

```bash
git clone https://github.com/your-username/spaceechoes-backend.git
cd spaceechoes-backend
```
### 2. Install Dependencies

```bash
composer install
```
### 3. Configure Environment

Create a .env.local file using the existing .env as a template. Set up your database connection and other environment variables.

### 4. Set Up the Database

```bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

### 5. Run the Development Server

```bash
symfony server:start
# or
php -S 0.0.0.0:8000 -t public
```

## Contact

For questions or collaboration inquiries, feel free to reach out:

- **Amel Belkacem** – amel.belkacem.pro@gmail.com

- **Marta Sanz** – martasf22@gmail.com

