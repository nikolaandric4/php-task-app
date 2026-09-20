# 🚀 TaskFlow - PHP Task Management App

A lightweight, secure, and responsive web application for managing daily tasks, built with **Vanilla PHP** and **MySQL**.

---

## 🇬🇧 English Description

### ✨ Features
- **User Authentication**: Secure registration and login system with session management.
- **Task CRUD Operations**:
  - Create new tasks with title and optional description.
  - Read/View tasks specific to the logged-in user.
  - Update existing task details.
  - Delete tasks securely.
- **Modern Responsive UI**: Clean interface built using modern CSS (CSS Variables, Flexbox, Grid).

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

### 🚀 Local Setup Instructions
1. Clone the repository:
   ```bash
   git clone [https://github.com/nikolaandric4/php-task-app.git](https://github.com/nikolaandric4/php-task-app.git)

   # 🚀 TaskFlow - PHP Task Management App

Jednostavna, ali sigurna web aplikacija za upravljanje svakodnevnim zadacima, izrađena u **praznom PHP-u (Vanilla PHP)** i **MySQL** bazi podataka.

## ✨ Funkcionalnosti

- **Registracija i Prijava korisnika** (Sistem autentifikacije)
- **CRUD Operacije nad zadacima**:
  - Kreiranje novih zadataka (Create)
  - Prikaz zadataka specifičnih za prijavljenog korisnika (Read)
  - Izmena postojećih zadataka (Update)
  - Brisanje zadataka (Delete)
- **Moderan i odzivan UI**: Čist interfejs izrađen uz pomoć modernog CSS-a (CSS Variables, Flexbox, Grid).

## 🔒 Primene Sigurnosnih Praksi (Security First)

Posebna pažnja posvećena je bezbednosti aplikacije:
- **Zaštita od SQL Injection-a**: Svi upiti ka bazi koriste **Prepared Statements** (`mysqli`).
- **Zaštita od XSS (Cross-Site Scripting)**: Svi korisnički ulazi se filtriraju kroz `htmlspecialchars()` pre prikaza u HTML-u.
- **Bezbedno čuvanje lozinki**: Koristi se PHP `password_hash()` sa `PASSWORD_DEFAULT` algoritmom (BCrypt).
- **Kontrola Pristupa i Sesije**: Neprijavljeni korisnici nemaju pristup zaštićenim stranicama (`index.php`, `edit.php`).

## 🛠️ Tehnologije

- **Backend**: PHP 8.x
- **Baza podataka**: MySQL / MariaDB
- **Frontend**: HTML5, CSS3
- **Lokalni server**: XAMPP (Apache + MySQL)

## 🚀 Pokretanje Projekta Lokalno

1. Klonirajte repozitorijum:
   ```bash
   git clone [https://github.com/nikolaandric4/php-task-app.git](https://github.com/nikolaandric4/php-task-app.git)