# Cashaty 🛒

Cashaty is a ** Point-of-Sale (POS) system** built with Laravel & AdminLTE.  
It helps you manage products, stock, orders, and customers efficiently. 

---

## 🚀 Features

- Product & Category Management  
- Stock Tracking & Low Stock Alerts  
- Orders Management with Total Calculation & Discounts  
- Dashboard KPIs: Today's Orders, Today's Sales, Low Stock Products, Available Products  
- Recent Orders Table (Last 10 Orders)  
- User Permissions & Roles  
- Activity logs Ready  
- Localization Ready

---

## ⚡ Tech Stack

- **Backend:** Laravel 12, Eloquent ORM, MySQL  
- **Frontend:** AdminLTE, Blade, Bootstrap 5  
- **Version Control:** Git + GitHub

---

## 🌟 Contribution & Improvements

- Export reports (PDF/Excel)

- Dark mode support

- Barcode / QR code scanning

- Enhanced UI/UX

---


## 💻 Installation

```bash
git clone https://github.com/Eslam2302/Cashaty.git
cd Cashaty
composer install
npm install
npm run build
cp .env.example .env
php artisan key:generate



- Update .env with your database credentials.

- Run migrations and seeders:

bash

php artisan migrate --seed

- Serve locally:

php artisan serve
