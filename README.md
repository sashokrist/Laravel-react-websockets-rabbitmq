<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Laravel + React + WebSockets + RabbitMQ + Redis Image Gallery

A full-stack image gallery app built with **Laravel 10**, **React**, **WebSockets (Laravel WebSockets)**, **RabbitMQ**, and **Redis**.

It allows uploading and deleting images in real time, with Redis caching and email notifications sent via RabbitMQ.

---

## 🌀 Features

- ✅ Upload and display images (stored publicly)
- ✅ Real-time updates via Laravel WebSockets
- ✅ Asynchronous email notifications via RabbitMQ queues
- ✅ Redis caching for faster responses and reduced DB calls
- ✅ Built-in React frontend (Vite)
- ✅ Works without Docker (e.g. XAMPP on Windows)

---

## 🔧 Requirements

- PHP 8.1+
- Composer
- Node.js + npm
- XAMPP (Apache + MySQL + RabbitMQ manually installed)
- Laravel WebSockets + RabbitMQ + Redis
- Mailtrap (or any SMTP for dev)

---

## 🚀 Clone & Setup

```bash
git clone https://github.com/sashokrist/Laravel-react-websockets-rabbitmq.git
cd Laravel-react-websockets-rabbitmq
```

### ⚙️ Backend Setup (Laravel)

```bash
composer install
cp .env.example .env
php artisan key:generate
```

Update `.env` with:

```env
APP_URL=http://localhost/laravel-gallery/public
VITE_API_BASE_URL=http://localhost/laravel-gallery/public
VITE_STORAGE_URL=http://localhost/laravel-gallery/public/storage
DB_DATABASE=your_db
DB_USERNAME=root
DB_PASSWORD=
QUEUE_CONNECTION=rabbitmq
CACHE_DRIVER=redis
SESSION_DRIVER=redis
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_user
MAIL_PASSWORD=your_mailtrap_pass
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="Gallery App"
PUSHER_APP_ID=your_app_id
PUSHER_APP_KEY=your_key
PUSHER_APP_SECRET=your_secret
PUSHER_APP_CLUSTER=mt1
REDIS_HOST=127.0.0.1
REDIS_PORT=6379
```

### 🗃️ Migrations & Storage

```bash
php artisan migrate
php artisan storage:link
```

### 🧵 Start Laravel WebSocket & Queue Workers

```bash
php artisan websockets:serve
php artisan queue:work
```

---

### 🖼 Frontend Setup (React with Vite)

```bash
npm install
npm run dev
```

Browse: [http://localhost:5173/](http://localhost:5173/)

---

## 📦 API Endpoints

| Method | Endpoint            | Description      |
|--------|---------------------|------------------|
| GET    | /api/gallery        | List all images  |
| POST   | /api/gallery        | Upload image     |
| DELETE | /api/gallery/{id}   | Delete image     |

---

## 🔁 Real-Time Updates

Live image updates via WebSockets using Laravel Echo + Pusher-compatible server.

---

## 🧠 Redis Caching

- Images are cached with `Cache::remember()` in controller
- When image is added or deleted, cache is invalidated with `Cache::forget()`

---

## ✉️ Email Notifications

Emails are queued and sent when:

- Image is uploaded
- Image is deleted

---

## 📁 Folder Structure

```
/app
    /Http/Controllers/GalleryController.php
    /Events/ImageUpdated.php
    /Mail/ImageActionMail.php
/resources
    /views/emails/image-action.blade.php
/public
    /storage/images/
```

---

## 👨‍💻 Author

**Aleksander Keremidarov**  
GitHub: [@sashokrist](https://github.com/sashokrist)
