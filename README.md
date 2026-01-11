<div align="center">

# 🏫 PTTA-RESERVATION-SYSTEM  

_Empower Your Space – Effortlessly Reserve and Manage_

[![Last Commit](https://img.shields.io/github/last-commit/SNFASA/Hikmah-and-Ekplorasi-Room-Reservation-System)](https://github.com/SNFASA/Hikmah-and-Ekplorasi-Room-Reservation-System/commits)  
![JavaScript](https://img.shields.io/badge/JavaScript-70.9%25-yellow)  
![Languages](https://img.shields.io/github/languages/count/SNFASA/Hikmah-and-Ekplorasi-Room-Reservation-System)

---

## 🔧 Built With

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

---

## 📝 Overview

The **Room & Equipment Reservation System** is designed to streamline **room reservations, equipment bookings, maintenance scheduling, and feedback management**.  
It is tailored for academic institutions and organizations to manage resources efficiently.
---
### Demo website 
- ![websit](https://pttareservation.lamanrasmi.com).
- User can create new account to access the website 
- Admin page 
- username : nabil
- password : 1234
---

## 🔑 Features

### 👤 User Management
- CRUD operations for users (Create, Read, Update, Delete)  
- Password reset and role assignment  
- Faculty/office and course management  

### 🗓 Booking Management
- Create, update, and cancel room/equipment bookings  
- Attach users to bookings  
- Calendar view by month & purpose  
- Email reminders & admin notifications  

### 🏢 Room Management
- Add, edit, view, and delete rooms  
- Track capacity & availability  
- Link equipment to specific rooms  

### 🖥 Equipment Management
- Manage equipment lifecycle (CRUD)  
- Categorize & track usage status  

### 🛠 Maintenance
- Schedule maintenance sessions  
- Track progress & record maintenance logs  

### 💬 Feedback
- Booking users can submit feedback  
- Admin reviews feedback & reports  
- Automatic damage reports sent to maintenance  

### 📅 Reservation
- Similar to booking, but with extra admin features  
- Admin can add notes & update reservation status  
- Notifications for both users & admins  

### 📜 Activity Log
- Admin dashboard shows detailed system activity  

---

## 📊 Dashboards & Interfaces

### 🔹 Admin Dashboard  
![Admin Dashboard](./public/images/1.png)

### 🔹 PPP Staff Dashboard  
![PPP Staff](./public/images/2.png)

### 🔹 Home Page  
![Home Page 1](./public/images/20.png)  

### 🔹 My Booking List  
![Booking List](./public/images/4.png)

### 🔹 Booking Checkout Form  
![Checkout Form](./public/images/6.png)

### 🔹 Reservation Checkout Form  
![Checkout Form](./public/images/7.png)

### 🔹 User Profile  
![User Profile](./public/images/8.png)

### 🔹 Feedback Page  
![Feedback](./public/images/9.png)

---

## 🗃 Database Design

### Key Entities:
1. **User** – name, email, role, faculty/office  
2. **Booking** – date, time, purpose, room  
3. **Room** – capacity, status, equipment associations  
4. **Equipment** – name, category, status  
5. **Schedule Booking** – blocked booking times  
6. **Maintenance** – logs and statuses  
7. **Reservation** – date, time, purpose, room  
8. **Log Activity** – record of admin/user actions  

📄 [View the EER Diagram](./doc/EERD%20librarRoom%20reservation%20system%20PDF.pdf)

![EERD](./doc/EERD.png)

---

## 🧱 Class Diagram (version 2)

![Class Diagram](./public/images/10.png)

---

## 🚀 Installation & Running  

```bash
# Clone the repository
git clone https://github.com/SNFASA/Hikmah-and-Ekplorasi-Room-Reservation-System

# Navigate into project folder
cd Hikmah-and-Ekplorasi-Room-Reservation-System

# Install PHP dependencies
composer install

# Install frontend dependencies
npm install

# Copy environment file & configure DB credentials
cp .env.example .env

# Generate Laravel app key
php artisan key:generate

# Run database migrations
php artisan migrate

# Start backend server
php -S localhost:8000 -t public

# Run frontend dev server
npm run dev

# Run backend tests
vendor/bin/phpunit

# Run frontend tests
npm test

website : http://pttareservation.lamanrasmi.com  
can create user 
admin :-
username : nabil@gmail.com
password : 1234
