# 🚀 TaskFlow - PHP Task Management App

A lightweight, secure, and responsive web application for managing daily tasks, built with **Vanilla PHP** and **MySQL**.

---

## 🇬🇧 English Description

### ✨ Features
- **User Authentication**: Secure registration and login system with session management.
- **Task CRUD Operations**:
  - Create new tasks with title, description, priority, status, and due date.
  - Read/View tasks specific to the logged-in user.
  - Update existing task details and statuses.
  - Delete tasks securely.
- **Advanced Filtering & Search**:
  - Real-time search by task title or description.
  - Filter tasks dynamically by status (*Pending, In Progress, Completed*) and priority (*Low, Medium, High*).
- **Modern Responsive UI**: Clean interface built using modern CSS (CSS Variables, Flexbox, Grid, Badges).

### 🔒 Security Implementations
- **SQL Injection Prevention**: All database queries use Prepared Statements (`mysqli`).
- **XSS (Cross-Site Scripting) Protection**: User inputs are sanitized using `htmlspecialchars()` before outputting to HTML.
- **Password Hashing**: Secure password hashing using PHP's `password_hash()` with BCrypt (`PASSWORD_DEFAULT`).
- **Access Control**: Protected routes (`index.php`, `edit.php`) automatically redirect unauthenticated users to the login page.

### 🛠️ Tech Stack
- **Backend**: PHP 8.x
- **Database**: MySQL / MariaDB
- **Frontend**: HTML5, CSS3 (Custom Stylesheet)
- **Local Server Environment**: XAMPP (Apache + MySQL)

---

## 🇸🇷 Opis na srpskom jeziku

### ✨ Funkcionalnosti
- **Autentifikacija korisnika**: Siguran sistem registracije i prijave.
- **Napredne CRUD operacije**: Kreiranje, pregled, izmena i brisanje sa opcijama za prioritet, status i rok.
- **Pretraga i Filtriranje**: Pretraživanje po nazivu i filtriranje po statusu ili prioritetu.
- **Moderan i odzivan UI**: Čist dizajn sa kolor-kodiranim bedževima.