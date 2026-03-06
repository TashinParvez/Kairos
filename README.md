<div align="center">

# Kairos

### A personal growth and life-tracking platform built to help users build better habits, stay accountable, and reduce procrastination.

<p align="center">
  <img src="https://img.shields.io/badge/PHP-Backend-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP">
  <img src="https://img.shields.io/badge/MySQL-Database-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
  <img src="https://img.shields.io/badge/HTML-Frontend-E34F26?style=for-the-badge&logo=html5&logoColor=white" alt="HTML">
  <img src="https://img.shields.io/badge/CSS-Styling-1572B6?style=for-the-badge&logo=css3&logoColor=white" alt="CSS">
  <img src="https://img.shields.io/badge/JavaScript-Interactive-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black" alt="JavaScript">
</p>

<p align="center">
  <img src="https://img.shields.io/github/stars/TashinParvez/Kairos?style=flat-square" alt="Stars">
  <img src="https://img.shields.io/github/forks/TashinParvez/Kairos?style=flat-square" alt="Forks">
  <img src="https://img.shields.io/github/issues/TashinParvez/Kairos?style=flat-square" alt="Issues">
  <img src="https://img.shields.io/github/last-commit/TashinParvez/Kairos?style=flat-square" alt="Last Commit">
  <img src="https://img.shields.io/github/languages/top/TashinParvez/Kairos?style=flat-square" alt="Top Language">
  <img src="https://img.shields.io/github/repo-size/TashinParvez/Kairos?style=flat-square" alt="Repo Size">
</p>

</div>

---

## Overview

**Kairos** is a self-improvement and life-management web application designed to support users in building positive habits, tracking progress, documenting personal experiences, and staying focused on long-term growth.

The platform combines several productivity and reflection tools inside a single ecosystem. Instead of being limited to one feature like goal tracking or journaling, Kairos brings together multiple areas of personal development such as:

- goal management
- daily life tracking
- journaling
- blogging
- community engagement
- memory preservation
- self-learning resources
- admin moderation

This makes Kairos more than a productivity dashboard. It acts as a **digital support system for intentional living**.

---

## Why Kairos?

Personal growth is not just about setting goals. It also involves:

- understanding habits
- reflecting on good and bad experiences
- staying consistent over time
- learning from books and resources
- sharing thoughts with others
- finding motivation through community

Kairos was built around that broader idea.

---

## Core Features

### 1. Authentication System

- User sign up flow
- User login flow
- Session-based access control
- Route protection for authenticated areas

### 2. Dashboard

- Central landing page after login
- Personalized overview of activity
- Navigation hub for all modules
- Quick access to major life-management tools

### 3. Goal Tracking

- Add and manage personal goals
- Set start dates and deadlines
- Track completion status
- Monitor progress toward personal milestones

### 4. Break-Loop / Anti-Procrastination Direction

- The project theme strongly focuses on reducing procrastination
- Encourages behavior change through structure and accountability
- Supports better routines and intentional action

### 5. Personal Journal

- Record reflections and daily experiences
- Keep a private space for thoughts and emotional tracking
- Build a habit of self-awareness through writing

### 6. Good and Bad Things Tracking

- Log positive and negative events
- Reflect on daily experiences
- Promote mindful review of actions and outcomes

### 7. Life Library

- Curated self-improvement and learning-oriented book/resource section
- Includes books and related descriptions
- Encourages continuous self-education

### 8. Blog Module

- Users can explore or create blog-style content
- Supports knowledge sharing and expression
- Useful for motivation, community learning, and reflection

### 9. Memories Module

- Preserve meaningful moments
- Store memorable entries and media-related references
- Helps users revisit meaningful milestones

### 10. Community Modules

- Dedicated community-oriented areas
- Includes general community pages and themed sub-community sections
- Adds a social and belonging-focused dimension to the platform

### 11. Profile Management

- Profile-related user pages
- Personalized identity within the app
- Supports more customized platform usage

### 12. Admin Panel

- Separate administrative area
- Intended for moderation and data supervision
- Suggests role-based separation between normal users and admins

---

## Project Structure

```bash
Kairos/
├── Admin-Panel/
├── Blog/
├── Break-Loop/
├── Chart/
├── Community/
├── Community Namaz/
├── Community Puja/
├── CommunityLandingPage Prototype/
├── Dashboard/
├── Database/
├── Goal/
├── HeroPage/
├── Images/
├── Includes/
├── Life-Library/
├── Memories/
├── Others/
├── Own-News-Letter/
├── Personal Journal/
├── Playground/
├── Profile/
├── Sign Up/
└── login Main/
```

---

## Folder Highlights

### `Dashboard/`

Contains the main post-login dashboard interface and supporting files such as navigation, modal UI, styling, and database connection helpers.

### `Goal/`

Responsible for user goal management and progress-oriented workflows.

### `Personal Journal/`

Handles user reflection and journaling features.

### `Blog/`

Contains blog-related pages for content sharing and reading.

### `Life-Library/`

Holds the self-learning and resource-focused section of the platform.

### `Memories/`

Dedicated to storing and displaying meaningful personal memories.

### `Community/`, `Community Namaz/`, `Community Puja/`

Community-based spaces for interaction, shared reflection, and topic-based engagement.

### `Admin-Panel/`

Provides administrative functionality for the application.

### `Database/`

Contains the SQL dump used to initialize the project database.

### `Includes/`

Reusable shared components and helper files used across different modules.

---

## Tech Stack

### Backend

- **PHP**

### Frontend

- **HTML**
- **CSS**
- **JavaScript**

### Database

- **MySQL / MariaDB**

### Development Environment

- XAMPP / WAMP / Local Apache + MySQL stack

---

## Database Design Snapshot

The included SQL dump indicates the project stores data for multiple self-improvement workflows, including:

- admin credentials
- blogs
- goals
- exercise tracking
- positive and negative life events
- images
- interests
- labels/tags
- life library resources

This shows the application is built as a multi-feature system rather than a single-purpose tracker.

---

## How It Works

Kairos appears to follow a modular PHP application style:

1. A user signs up or logs in
2. The session redirects them into the dashboard
3. From the dashboard, they can access goal tracking, journaling, community features, blog pages, memories, and learning resources
4. Data is stored in a relational database
5. Shared UI and helper files are reused across the project structure

---

## Installation Guide

## Prerequisites

Before running the project locally, make sure you have:

- PHP installed
- Apache server
- MySQL or MariaDB
- phpMyAdmin or another database management tool
- A local environment such as **XAMPP**, **WAMP**, or **Laragon**

---

## Local Setup

### 1. Clone the repository

```bash
git clone https://github.com/TashinParvez/Kairos.git
```

### 2. Move the project into your server directory

For example:

- **XAMPP:** `htdocs/`
- **WAMP:** `www/`

Example:

```bash
C:/xampp/htdocs/Kairos
```

### 3. Create the database

Open phpMyAdmin and create a database named:

```sql
kairos
```

### 4. Import the SQL file

Import the SQL dump from:

```bash
Database/kairos.sql
```

### 5. Configure database connection

Locate the database connection file used by the project and update credentials if needed.

Typical local values may look like:

```php
$host = "localhost";
$user = "root";
$password = "";
$database = "kairos";
```

### 6. Start Apache and MySQL

Launch your local server stack.

### 7. Open the project in browser

```bash
http://localhost/Kairos/
```

---

## Suggested Entry Points

Depending on your setup, the project may start from one of these locations:

- `HeroPage/`
- `login Main/`
- `Dashboard/`
- a root-level landing page if added later

If no root `index.php` is configured yet, begin from the login or hero page.

---

## Example Usage Flow

### User Journey

- Create an account
- Log in to the system
- Open the dashboard
- Add goals
- Write journal entries
- Track positive and negative daily events
- Explore the life library
- Visit community areas
- Store important memories
- Continue building better habits over time

---

## Strengths of the Project

- Modular structure with multiple focused sections
- Clear real-world purpose centered on self-improvement
- Practical combination of productivity and reflection
- Includes both personal and community-oriented experiences
- Expandable architecture for future features
- Database-backed design for persistent user data

---

## Potential Improvements

This project already has a strong concept. A few future enhancements could make it even better:

- add a root `README` with screenshots and demo GIFs
- introduce `.env`-based configuration for database credentials
- improve routing and entry-point consistency
- add prepared statements for stronger SQL security
- hash passwords securely using `password_hash()`
- add form validation and clearer error handling
- document each module separately
- add contribution guidelines
- add a license file
- include deployment steps for production hosting

---

## Security Notes

For production readiness, consider the following upgrades:

- hash passwords instead of storing plain values
- validate and sanitize all user input
- use prepared statements for database queries
- move credentials to environment variables
- add CSRF protection for sensitive forms
- enforce stricter session security

---

## Future Roadmap

Possible future directions for Kairos:

- habit streak system
- progress analytics dashboard
- daily check-in system
- reminders and notifications
- richer community interaction
- media upload improvements
- admin analytics
- responsive UI improvements
- API support for mobile integration

---

## Screenshots

You can add screenshots here later:

## Screenshots

### Hero Page

![Hero Page](./Images/hero-page.png)

### Dashboard

![Dashboard](./Images/dashboard.png)

### Goal Tracker

![Goal Tracker](./Images/goals.png)

### Journal

![Journal](./Images/journal.png)

---

---

## 🌟 Contributors

A big thanks to all the people who contribute to this project!

## [![Contributors](https://contrib.rocks/image?repo=TashinParvez/Kairos)](https://github.com/TashinParvez/Kairos/graphs/contributors)

---

## License

This repository currently does not appear to include a license file.

If you plan to make it open for reuse, consider adding one of the following:

- MIT License
- Apache 2.0
- GPL-3.0

---

<div align="center">

### Built to support growth, reflection, and better living.

</div>
