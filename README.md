<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>


# Laravel + React + WebSockets + RabbitMQ Image Gallery

A full-stack image gallery app built with **Laravel 10**, **React**, **WebSockets (Laravel WebSockets)**, and **RabbitMQ**.  

It allows uploading and deleting images in real time, with email notifications sent on each action.

---

## 🌀 Features

- ✅ Upload and display images (stored publicly)
- 
- ✅ Real-time updates via Laravel WebSockets
- 
- ✅ Asynchronous email notifications via RabbitMQ queues
- 
- ✅ Built-in React frontend (Vite)
- 
- ✅ Works without Docker (e.g. XAMPP on Windows)

---

## 🔧 Requirements

- PHP 8.1+
- 
- Composer
- 
- Node.js + npm
- 
- XAMPP (Apache + MySQL + RabbitMQ manually installed)
- 
- Laravel WebSockets + RabbitMQ (no Docker)
- 
- Mailtrap (or any SMTP for dev)

---

## 🚀 Clone & Setup


git clone https://github.com/sashokrist/Laravel-react-websockets-rabbitmq.git

cd Laravel-react-websockets-rabbitmq

⚙️ Backend Setup (Laravel)

composer install

cp .env.example .env

php artisan key:generate

1. Configure .env
2. 
Update these lines:

APP_URL=http://localhost/laravel-gallery/public

VITE_API_BASE_URL=http://localhost/laravel-gallery/public

VITE_STORAGE_URL=http://localhost/laravel-gallery/public/storage

DB_CONNECTION=mysql

DB_DATABASE=your_db

DB_USERNAME=root

DB_PASSWORD=

QUEUE_CONNECTION=rabbitmq

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

2. Run Migrations

php artisan migrate

php artisan storage:link

3. Start Laravel WebSocket Server

php artisan websockets:serve

💌 Queue Worker (RabbitMQ)

Make sure RabbitMQ is installed and running locally.

Start queue worker:

php artisan queue:work

🖼 Frontend Setup (React with Vite)

npm install

npm run dev

This will launch the React app at:

arduino

http://localhost:5173/

Make sure API calls work via VITE_API_BASE_URL.

📦 API Endpoints

Method	Endpoint	Description

GET	/api/gallery	List all images

POST	/api/gallery	Upload image

DELETE	/api/gallery/{id}	Delete image

🔁 Real-Time Updates

All connected clients see new images or deletions live via Echo and laravel-websockets.

Uses Pusher-compatible Laravel broadcasting with WebSockets driver.

✉️ Email Notifications

Emails are queued and sent on:

Image upload

Image deletion

Customize email view in:

resources/views/emails/image-action.blade.php

✅ Usage
Upload image

Image appears in list immediately

All other users see image live

Email sent asynchronously

Deleting an image triggers real-time update + mail

🧹 Troubleshooting

Image not visible?

Ensure php artisan storage:link is run and the file is inside /public/storage/images.

Queue not sending mails?

Make sure:

php artisan queue:work

WebSocket not working?

Check:

php artisan websockets:serve

.env has correct PUSHER_* keys

config/broadcasting.php has verify => false for dev

📂 Folder Structure
swift

/app
    /Http/Controllers/GalleryController.php
    /Events/ImageUpdated.php
    /Mail/ImageActionMail.php
/resources
    /views/emails/image-action.blade.php
/public
    /storage/images/
    
👨‍💻 Author

Aleksander Keremidarov

GitHub: sashokrist


