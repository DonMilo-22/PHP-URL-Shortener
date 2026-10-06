# ✂️ PHP URL Shortener

> Minimal URL shortener with PHP and SQLite.

![PHP](https://img.shields.io/badge/PHP-8.1%2B-777BB4?logo=php&logoColor=white)
![SQLite](https://img.shields.io/badge/SQLite-3-003B57?logo=sqlite)
![License](https://img.shields.io/badge/license-MIT-green)

A tiny web application that turns long links into short local codes and redirects visitors when those codes are opened.

## ✨ Features

- Shorten valid HTTP/HTTPS links
- SQLite persistence
- Automatic database creation
- Collision-resistant short codes
- Redirect endpoint
- Simple responsive UI
- No framework required

## 🚀 Run locally

```bash
php -S localhost:8000 -t public
```

Open `http://localhost:8000`.

## 🧠 How it works

1. Submit a long URL.
2. PHP validates it and creates a short random code.
3. The URL and code are stored in SQLite.
4. Visiting `/?c=CODE` looks up the target and redirects.

## 🛠️ Requirements

- PHP 8.1+
- PDO SQLite extension

## 🧱 Structure

```text
public/
  index.php
src/
  Database.php
data/
.gitignore
```

## ⚠️ Production note

This is intentionally small and educational. A public deployment should add rate limiting, abuse protection, analytics and a proper base URL configuration.

## 📄 License

MIT.

## 🆕 Recent changes

### 2026-10-05

- Added optional custom aliases so short links can use a memorable code instead of a random one.

### 2026-10-04

### 2026-10-04

- The generated short-link card now shows the destination domain so users can confirm the link.

### Previous update

- Added a one-click **Copy link** button with visual confirmation after a URL is shortened.
