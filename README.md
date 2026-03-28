# ⚔️ SwordClicker

![PHP](https://img.shields.io/badge/PHP-8.4+-777BB4?logo=php\&logoColor=white)
![Composer](https://img.shields.io/badge/Composer-Required-885630?logo=composer\&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-Database-4479A1?logo=mysql\&logoColor=white)
![Status](https://img.shields.io/badge/Status-Local%20Project-green)
![License](https://img.shields.io/badge/License-Personal-blue)

---

## 📖 Description

**SwordClicker** is a browser-based idle incremental game that can be run locally using a PHP environment.
Fight bosses, track progression, and manage your gameplay directly in your browser.

---

## ⚙️ Requirements

Make sure you install:

* A local server environment (WampServer, XAMPP, or Laragon)
* PHP **8.4 or higher**
* Composer
* phpMyAdmin (or any MySQL manager)

---

## 🚀 Installation

### 1. Install dependencies

Open a terminal (cmd) in the project root and run:

```bash id="5d4q0x"
composer update
```

---

### 2. Configure base path

Edit `.htaccess`:

* Root installation:

```id="6ozwqb"
RewriteBase /
```

* Subfolder installation:

```id="2dhnpu"
RewriteBase /your_folder_name/
```

---

### 3. Update PATH constant

Edit:

```id="ff3c03"
src/core/constants.php
```

```php id="4t42f4"
const PATH = "/";
```

Replace if needed:

```php id="1b9wq9"
const PATH = "/your_folder_name/";
```

---

### 4. Database setup

A ready-to-use database file is included.

#### Option A — Import file (recommended)

1. Open phpMyAdmin
2. Create a database (`your_database_name`)
3. Go to **Import**
4. Select the `.sql` file
5. Execute

---

#### Option B — Manual import

1. Open phpMyAdmin
2. Create a database
3. Go to **SQL tab**
4. Paste the `.sql` content
5. Run query

---

### 5. Configure database connection

Edit:

```id="6k5fnp"
src/config/database.php
```

Example:

```php id="f1l0p8"
$host = "localhost";
$dbname = "your_database_name";
$user = "root";
$password = "";
```

---

## 🧪 Local Run Checklist

* Apache ✅
* MySQL ✅
* mod_rewrite enabled ✅
* Project in `/www` or `/htdocs` ✅

Default MySQL credentials (Wamp):

```
user: root
password: (empty)
```

---

## ⚠️ Troubleshooting

**404 errors**

* Check `.htaccess`
* Verify `RewriteBase`
* Enable `mod_rewrite`

**Database connection error**

* Verify credentials
* Ensure MySQL is running

**Composer issues**

* Run:

```bash id="72h1jn"
composer install
```

---

## 📌 Notes

* This project is intended for **local use**
* Can be adapted for production with proper server configuration

---

## 👤 Author: Kylerises

Developed as a personal project for a public.

---
