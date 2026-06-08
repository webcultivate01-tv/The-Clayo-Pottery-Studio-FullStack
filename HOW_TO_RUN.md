# 🏺 Clayo Pottery Studio - Project Setup Guide

## Complete Step-by-Step Instructions to Run the Project Using XAMPP

---

## 📋 Prerequisites

Before you start, make sure you have:
- **XAMPP** installed on your computer ([Download here](https://www.apachefriends.org/))
- **PHP 7.4+** (comes with XAMPP)
- **MySQL/MariaDB** (comes with XAMPP)
- A text editor or IDE (VS Code recommended)

---

## ✅ Step 1: Start XAMPP Server

### On Windows:
1. Open **XAMPP Control Panel** (usually in `C:\xampp\xampp-control.exe`)
2. Click **"Start"** button next to:
   - **Apache** (web server)
   - **MySQL** (database server)
3. Both should show **GREEN** status when running

**Example:**
```
Apache     ✓ Running (Port 80)
MySQL      ✓ Running (Port 3307)
```

---

## 🗂️ Step 2: Place Project in XAMPP Folder

1. Locate your XAMPP installation folder: `C:\xampp\htdocs\`
2. Your project should be at:
   ```
   C:\xampp\htdocs\clayo-Studio-Management-System\
   ```

> **Note:** If your project is elsewhere, you can create a symbolic link or move it to htdocs

---

## 🛢️ Step 3: Create the Database

### Option A: Using phpMyAdmin (Easy Way)

1. Open your browser and go to: **http://localhost/phpmyadmin**
2. You should see the phpMyAdmin login page
3. Click on the "Import" tab (top menu)
4. Click "Choose File" and select:
   ```
   admin/database/schema_clayo_pottery.sql
   ```
5. Click **"Import"** button
6. You should see: ✓ "Import successful"

### Option B: Using MySQL Command Line

1. Open **Command Prompt** or **PowerShell**
2. Navigate to project folder:
   ```powershell
   cd "C:\Users\USER\Desktop\Work\Queue Clients\clayo-Studio-Management-System"
   ```
3. Run this command:
   ```powershell
   "C:\xampp\mysql\bin\mysql.exe" -h 127.0.0.1 -P 3307 -u root < "admin\database\schema_clayo_pottery.sql"
   ```
4. Wait for completion (no errors = success ✓)

---

## 👤 Step 4: Create Admin User (Only First Time)

1. Open **PowerShell** or **Command Prompt**
2. Navigate to project:
   ```powershell
   cd "C:\Users\USER\Desktop\Work\Queue Clients\clayo-Studio-Management-System"
   ```
3. Run the admin creator script:
   ```powershell
   "C:\xampp\php\php.exe" admin/database/seeds/create_admin.php
   ```
4. Follow the prompts:
   - Enter your name
   - Enter your email
   - Enter your password (at least 6 characters)
5. You'll see: ✓ "Admin user created successfully"

---

## 🖼️ Step 5: Populate Gallery Images (Optional)

To add sample pottery images to the gallery:

```powershell
cd "C:\Users\USER\Desktop\Work\Queue Clients\clayo-Studio-Management-System"
"C:\xampp\php\php.exe" admin/database/seeds/seed_gallery_images.php
```

You should see: ✓ "Successfully seeded gallery with 24 images!"

---

## 🌐 Step 6: Access the Project

### Public Website:
Open your browser and visit:
```
http://localhost/clayo-Studio-Management-System/
```

**Pages Available:**
- Home: `http://localhost/clayo-Studio-Management-System/index.php`
- About: `http://localhost/clayo-Studio-Management-System/about.php`
- Workshops: `http://localhost/clayo-Studio-Management-System/services.php`
- Gallery: `http://localhost/clayo-Studio-Management-System/gallery.php`
- Contact: `http://localhost/clayo-Studio-Management-System/contact.php`

### Admin Dashboard:
```
http://localhost/clayo-Studio-Management-System/admin/
```

**Login with:**
- Email: (the email you created in Step 4)
- Password: (the password you created in Step 4)

---

## 📊 Database Information

- **Database Name:** `Clayo-Pottery-Studio`
- **Host:** `127.0.0.1`
- **Port:** `3307` (Important! Not the default 3306)
- **Username:** `root`
- **Password:** (leave empty)

---

## 🚀 Admin Panel Features

After logging in, you can manage:

### 📸 Gallery
- Add/Edit/Delete pottery images
- Manage categories (Mugs, Bowls, Vases, etc.)
- Control which images appear on public site

### 📋 Bookings
- View workshop booking requests
- Accept/confirm bookings
- Track booking status

### 👥 Clients
- Manage studio clients
- Store client information
- Track client interactions

### 🎓 Services/Workshops
- Add/Edit workshop offerings
- Set pricing and descriptions
- Manage workshop availability

### ⚙️ Settings
- Update studio name and email
- Configure theme and appearance
- Manage system settings

### 👤 Users
- Create staff accounts
- Assign admin/staff roles
- Manage user permissions

---

## 🔧 Troubleshooting

### Problem: "Connection Refused" when accessing website

**Solution:**
1. Check that XAMPP Apache is running (GREEN status)
2. Check that MySQL is running
3. Verify project path is: `C:\xampp\htdocs\clayo-Studio-Management-System\`

### Problem: "Database Connection Error"

**Solution:**
1. Verify MySQL is running on port 3307
2. Make sure database `Clayo-Pottery-Studio` exists
3. Check that `admin/config/database.php` has correct settings:
   ```php
   'host'     => '127.0.0.1',
   'port'     => 3307,
   'database' => 'Clayo-Pottery-Studio',
   'username' => 'root',
   'password' => '',
   ```

### Problem: "Admin page shows login loop"

**Solution:**
1. Make sure you created an admin user (Step 4)
2. Check database has users table
3. Clear browser cookies for localhost
4. Try incognito/private window

### Problem: "Can't upload gallery images"

**Solution:**
1. Make sure `public/uploads/gallery/` folder exists
2. Give folder write permissions (Right-click > Properties > Security)
3. Check file size isn't too large (Max 5MB recommended)

---

## 📁 Project Structure

```
clayo-Studio-Management-System/
├── admin/                    # Admin dashboard
│   ├── index.php            # Admin login page
│   ├── app/                 # Models, Controllers, Views
│   ├── config/              # Database config
│   ├── database/            # Schema & seeds
│   └── core/                # Framework core
├── public/                  # Public assets
│   ├── uploads/             # User uploaded files
│   ├── css/                 # Stylesheets
│   └── images/              # Static images
├── index.php                # Home page
├── about.php                # About page
├── services.php             # Workshops page
├── gallery.php              # Gallery page
├── contact.php              # Contact page
└── HOW_TO_RUN.md           # This file
```

---

## 🔐 Default Database Tables

The system automatically creates:
- `users` - Admin staff accounts
- `clients` - Studio clients
- `bookings` - Workshop bookings
- `services` - Workshop offerings
- `gallery_images` - Gallery photos
- `gallery_categories` - Gallery categories
- `settings` - App settings
- And more...

---

## 📞 Support

If you encounter any issues:

1. Check this guide again (common issues in Troubleshooting section)
2. Verify all steps were completed correctly
3. Make sure XAMPP is running (both Apache & MySQL)
4. Check file permissions on folders
5. Review error messages in browser console (F12)

---

## ✨ You're All Set!

Your Clayo Pottery Studio project is now ready to use! 🎉

**Quick Access Links:**
- 🏠 Public Website: http://localhost/clayo-Studio-Management-System/
- 🔒 Admin Panel: http://localhost/clayo-Studio-Management-System/admin/
- 📊 Database: http://localhost/phpmyadmin

Enjoy managing your pottery studio! 🏺

---

**Last Updated:** June 2026  
**Version:** 1.0
