<div align="center">

# HIKMAH-AND-EKPLORASI-ROOM-RESERVATION-SYSTEM

_Empower Your Space, Effortlessly Reserve and Manage_

[![Last Commit](https://img.shields.io/github/last-commit/SNFASA/Hikmah-and-Ekplorasi-Room-Reservation-System)](https://github.com/SNFASA/Hikmah-and-Ekplorasi-Room-Reservation-System/commits)
![JavaScript](https://img.shields.io/badge/javascript-70.9%25-yellow)
![Languages](https://img.shields.io/github/languages/count/SNFASA/Hikmah-and-Ekplorasi-Room-Reservation-System)

---

## 🔧 Built with the tools and technologies:

![JSON](https://img.shields.io/badge/-JSON-black?logo=json&logoColor=white)
![Markdown](https://img.shields.io/badge/-Markdown-000?logo=markdown)
![npm](https://img.shields.io/badge/-npm-CB3837?logo=npm&logoColor=white)
![Composer](https://img.shields.io/badge/-Composer-885630?logo=composer)
![JavaScript](https://img.shields.io/badge/-JavaScript-F7DF1E?logo=javascript&logoColor=black)
![Vue.js](https://img.shields.io/badge/-Vue.js-4FC08D?logo=vue.js&logoColor=white)
![jQuery](https://img.shields.io/badge/-jQuery-0769AD?logo=jquery&logoColor=white)
![XML](https://img.shields.io/badge/-XML-0060AC?logo=xml&logoColor=white)
![GitHub Actions](https://img.shields.io/badge/-GitHub%20Actions-2088FF?logo=githubactions&logoColor=white)
![Lodash](https://img.shields.io/badge/-Lodash-3492FF?logo=lodash&logoColor=white)
![PHP](https://img.shields.io/badge/-PHP-777BB4?logo=php&logoColor=white)
![Vite](https://img.shields.io/badge/-Vite-646CFF?logo=vite&logoColor=white)
![Axios](https://img.shields.io/badge/-Axios-5A29E4?logo=axios&logoColor=white)
![Bootstrap](https://img.shields.io/badge/-Bootstrap-7952B3?logo=bootstrap&logoColor=white)
![Sass](https://img.shields.io/badge/-Sass-CC6699?logo=sass&logoColor=white)

</div>


## 📝 Overview

The **Booking Management System** allows users to manage room and equipment bookings. It also facilitates user account management, maintenance scheduling, and booking records.

---

## 🔑 Features

### 👤 User Management
- Create, view, edit, and delete user accounts
- Change password functionality
- Role and faculty/office assignment
- Course management

### 🗓 Booking Management
- Create and manage bookings for rooms and equipment
- Attach users to bookings
- View bookings by month and purpose
- Cancel bookings
- Email reminders for upcoming bookings
- Admin notification on new bookings

### 🏢 Room Management
- Add, edit, view, and delete rooms
- Track room capacity and status
- Associate equipment with rooms

### 🖥 Equipment Management
- Add, edit, view, and delete equipment
- Categorize and track equipment status

### 🛠 Maintenance
- Schedule maintenance for rooms and equipment
- Record maintenance details and track progress

### 💬 Feedback
- Only the user who booked the room can manage feedback
- Admin can review feedback and reports
- Damage reports are sent directly to maintenance

---

## 📊 Dashboards & Interface

### Admin Dashboard  
![Admin Dashboard](./public/images/1.png)

### PPP Staff Dashboard  
![PPP Staff](./public/images/2.png)

### Home Page  
![Home Page 1](./public/images/3.png)  
![Home Page 2](./public/images/4.png)

### My Booking List  
![Booking List](./public/images/13.png)

### Booking Checkout Form  
![Checkout Form](./public/images/7.png)

### User Profile  
![User Profile](./public/images/6.png)

### Feedback Page  
![Feedback](./public/images/9.png)

---

## 🗃 Database Design

### Key Entities:

1. **User** – name, email, role, faculty/office  
2. **Booking** – date, time, purpose, associated room  
3. **Room** – capacity, status, equipment associations  
4. **Equipment** – name, category, status  
5. **Schedule Booking** – invalid/blocked booking times  
6. **Maintenance** – logs and statuses for rooms and equipment

📄 [View the EER Diagram](./EERD%20librarRoom%20reservation%20system%20PDF.pdf)

---

## 🧱 Class Diagram

![Class Diagram](./public/images/8.png)

---

## 🚀 Installation & Running the System

Follow these steps to install dependencies and run the system:

```bash
# Clone the repository
git clone https://github.com/SNFASA/Hikmah-and-Ekplorasi-Room-Reservation-System

# Navigate to the project directory
cd Hikmah-and-Ekplorasi-Room-Reservation-System

# Install PHP dependencies
composer install

# Install frontend dependencies
npm install

# Copy and configure the .env file
cp .env.example .env
# (Edit .env with your DB credentials)

# Generate application key (if Laravel)
php artisan key:generate

# Run migrations (optional)
php artisan migrate

# Run backend server
php -S localhost:8000 -t public

# Run frontend build tool
npm run dev
# Run backend tests
vendor/bin/phpunit

# Run frontend tests
npm test
