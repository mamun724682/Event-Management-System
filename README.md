# Event Management System (Pure PHP) 🚀

## ⚡ Overview

This is a **web-based Event Management System** built with **pure PHP** but structured like Laravel for better organization and maintainability.

🚀 **Why Laravel-Like?**
Many PHP projects lack structure, making them difficult to maintain. This project follows Laravel’s architecture (MVC, routing, request handling, validation, etc.), but it is **100% pure PHP** without using any frameworks.

### 🎯 Features

✅ **User Authentication** - Secure login & registration with hashed passwords

✅ **Event Management** - Export, view, create, update, delete events with attendee limits

✅ **Attendee Registration** - Prevents overbooking, AJAX-enhanced form

✅ **Event Dashboard** - Paginated, sortable, and filterable event list

✅ **CSV Export** - Download attendee lists (Events -> Export)

✅ **Search & Filters** - Find events & attendees easily

---

## 🌐 Live Demo

🔗 [Event Management System](https://event-management.devfaculty.com)

📩 **Login Credentials:**\
✉️ Email: `admin@app.com`\
🔑 Password: `123456`

---

## 💻 Local Setup

### Requirements:

- PHP 8.2+
- MySQL
- Composer (for autoloading and read env)

### 🚀 Installation Steps

```bash
# Clone the repository
git clone 
cd Event-Management-System

# Copy environment file
cp .env.example .env

# Update .env with database credentials
DB_HOST=127.0.0.1
DB_DATABASE=event_management
DB_USERNAME=root
DB_PASSWORD=

# Run migrations and seed database
php database/manage.php migrate:fresh

# Start development server
php -S localhost:8000 -t public
```

### 🔑 Login Credentials

- `admin@app.com` / `123456`

---

## 🛠️ Project Structure

📂 **app/** → Controllers, Models, Services, Repositories, Enums, Requests\
📂 **public/** → Public assets & entry point (`index.php`)\
📂 **routes/** → Web routes (`web.php`, `api.php`)\
📂 **database/** → Migrations & seeds\
📂 **views/** → templating system\
📂 **config/** → Configurations (DB)\
📂 **storage/** → Logs

This structure ensures maintainability without requiring Laravel itself! 🚀
