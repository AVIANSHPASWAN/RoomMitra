
# 🏠 RoomMitra — Find Your Perfect Room

RoomMitra is a Laravel-based room-finding web application designed to help users discover rooms according to their location and budget.

## 🚀 Project Overview

The goal of RoomMitra is to make it easier for students and other people to find suitable rooms through a simple web interface.

## ✨ Features

- Browse available rooms
- Search rooms by location or keywords
- Filter rooms by minimum and maximum price
- View room details and images
- User authentication
- Role-based interfaces for Admin, Owner, and Customer
- Room management features for owners

*Note: RoomMitra is a work in progress. Features may change as development continues.*

## 🛠️ Tech Stack

- **Backend:** PHP, Laravel
- **Database:** MySQL
- **Frontend:** HTML, CSS, JavaScript, Tailwind CSS
- **Development Environment:** XAMPP

## 💻 Installation and Setup

### 1. Clone the repository

```bash
git clone https://github.com/AVIANSHPASWAN/RoomMitra.git
cd RoomMitra
```

### 2. Install PHP dependencies

```bash
composer install
```

### 3. Configure the environment

Copy `.env.example` to `.env` and configure your database credentials.

On Windows PowerShell:

```powershell
Copy-Item .env.example .env
```

### 4. Generate the application key

```bash
php artisan key:generate
```

### 5. Create the database

Create a MySQL database for RoomMitra, then set the database name and credentials in `.env`.

### 6. Run migrations

```bash
php artisan migrate
```

### 7. Create the storage link

```bash
php artisan storage:link
```

### 8. Start the development server

```bash
php artisan serve
```

Open the local URL shown in your terminal, usually `http://127.0.0.1:8000`.

## 🔐 Environment and Security

- Never upload your `.env` file or private credentials.
- Keep database passwords and application secrets private.
- Do not commit `vendor` or `node_modules` folders.

## 👨‍💻 Developer

**Avinash Paswan**

GitHub: [AVIANSHPASWAN](https://github.com/AVIANSHPASWAN)

## 📌 Project Status

RoomMitra is currently under development. More improvements and features may be added over time.
