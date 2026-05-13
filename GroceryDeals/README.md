# 🛒 GroceryDeals

> A full-featured grocery e-commerce web application built with **Laravel 11** and **MongoDB Atlas**. Featuring real-time deals, a shopping cart, user authentication, and a modern UI.

![GroceryDeals Banner](https://placehold.co/1200x400/16a34a/ffffff?text=GroceryDeals+%7C+Fresh+Prices+Every+Day)

---

## ✨ Features

| Feature | Description |
|---|---|
| 🏠 **Home Page** | Hero section, featured products, category pills, promo banner |
| 🛍️ **Product Catalog** | Filterable grid with sidebar categories and pagination |
| 🏷️ **Deals Page** | Time-limited deals with countdown and discounted product grids |
| 🛒 **Shopping Cart** | Session-based cart with quantity, free delivery logic, promo codes |
| 🔐 **Authentication** | Login, Register, Logout with middleware-protected routes |
| 📧 **Email Alerts** | Mailable deal notifications to subscribers |
| 🌍 **Localization** | English & Hindi language support |
| 🧑‍💼 **Admin Panel** | Protected admin area for managing products and deals |
| 📡 **REST API** | JSON endpoints for products and deals |
| 🍃 **MongoDB** | NoSQL backend via MongoDB Atlas – no SQL schemas needed |

---

## 🚀 Quick Start

### Prerequisites

Make sure you have the following installed:
- PHP 8.3+
- Composer
- Node.js 18+ & npm
- **MongoDB PHP Extension** (`ext-mongodb`)
- A [MongoDB Atlas](https://www.mongodb.com/atlas) account (free tier available)

---

### 1. Clone the Repository

```bash
git clone https://github.com/LusmicSam/grocerydeals
cd grocerydeals
```

### 2. Install Dependencies

```bash
# Install PHP dependencies
php composer.phar install   # or: composer install

# Install Node.js dependencies
npm install
```

### 3. Configure Environment

```bash
# Copy the example env file
cp .env.example .env

# Generate the app key
php artisan key:generate
```

Edit `.env` and set your MongoDB Atlas connection:

```env
APP_NAME=GroceryDeals
APP_ENV=local
APP_URL=http://localhost:8000

DB_CONNECTION=mongodb
DB_URI="mongodb+srv://<username>:<password>@cluster0.xxxxx.mongodb.net/?appName=Cluster0"
DB_DATABASE=grocerydeals

SESSION_DRIVER=cookie
CACHE_STORE=array

MAIL_MAILER=log   # change to smtp for real emails
```

### 4. Seed the Database

```bash
php artisan db:seed
```

This will create:
- **7 product categories** (Fruits, Vegetables, Dairy, Bakery, Beverages, Meat, Snacks)
- **35 products** with Indian pricing, descriptions, ratings and discount percentages
- **4 active deals** (Fruit Bonanza, Dairy Delights, Bakery Flash Sale, Weekend Meat Fest)
- **1 demo user** — `demo@grocerydeals.com` / `password`

### 5. Build Frontend Assets

```bash
npm run build        # For production
# OR
npm run dev          # For development with hot-reload
```

### 6. Run the App

```bash
php artisan serve
```

Open **http://localhost:8000** in your browser.

---

## 📁 Project Structure

```
GroceryDeals/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── WelcomeController.php     # Home page
│   │   │   ├── ProductController.php     # Product CRUD + API
│   │   │   ├── DealController.php        # Deals listing
│   │   │   ├── CartController.php        # Session cart
│   │   │   ├── Auth/
│   │   │   │   ├── LoginController.php
│   │   │   │   └── RegisterController.php
│   │   │   └── LanguageController.php    # i18n switching
│   │   └── Requests/
│   │       └── StoreProductRequest.php   # Form validation
│   └── Models/
│       ├── Product.php                   # MongoDB model
│       ├── Category.php
│       ├── Deal.php
│       ├── Order.php
│       ├── DealSubscription.php
│       └── User.php
├── database/
│   └── seeders/
│       ├── DatabaseSeeder.php
│       └── ProductSeeder.php             # 35 products + 4 deals
├── resources/
│   └── views/
│       ├── layouts/app.blade.php         # Master layout
│       ├── welcome.blade.php             # Home page
│       ├── products/                     # index, show, create, edit
│       ├── deals/index.blade.php
│       ├── cart/index.blade.php
│       └── auth/                         # login, register
├── routes/
│   ├── web.php                           # Web routes
│   └── api.php                           # API routes
└── .env                                  # Environment configuration
```

---

## 🌐 Routes

### Public
| Method | URL | Description |
|---|---|---|
| GET | `/` | Home / featured products |
| GET | `/products` | All products (filterable) |
| GET | `/products/{id}` | Product detail |
| GET | `/deals` | Active deals |
| GET | `/login` | Login form |
| GET | `/register` | Register form |
| GET | `/lang/{lang}` | Switch language |

### Authenticated
| Method | URL | Description |
|---|---|---|
| GET | `/cart` | View cart |
| POST | `/cart/add/{id}` | Add item to cart |
| DELETE | `/cart/remove/{id}` | Remove item |
| POST | `/cart/clear` | Clear entire cart |

### Admin (requires `auth` + `admin` middleware)
| Method | URL | Description |
|---|---|---|
| GET | `/admin/products/create` | New product form |
| POST | `/admin/products` | Store product |
| GET | `/admin/products/{id}/edit` | Edit form |
| PUT | `/admin/products/{id}` | Update product |
| DELETE | `/admin/products/{id}` | Delete product |

### API
| Method | URL | Description |
|---|---|---|
| GET | `/api/products` | List all products (JSON) |
| GET | `/api/products/{id}` | Single product (JSON) |

---

## 🍃 MongoDB Integration

This app uses the [`mongodb/laravel-mongodb`](https://www.mongodb.com/docs/drivers/php/laravel-mongodb/) package (v5.7+). Models extend `MongoDB\Laravel\Eloquent\Model` instead of the standard Eloquent model.

Key MongoDB features demonstrated:
- Document-based storage (no SQL migrations needed)
- ObjectID (`_id`) as primary key
- Atomic array operations
- Text search
- Embedded relations via `product_ids` arrays in deals

---

## 📧 Email Configuration

For deal alert emails, configure a real mail provider in `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.resend.com        # or mailgun, sendgrid, etc.
MAIL_PORT=587
MAIL_USERNAME=resend
MAIL_PASSWORD=your_api_key
MAIL_FROM_ADDRESS=deals@yoursite.com
```

---

## 🚀 Deployment to Vercel

This project is pre-configured for Vercel via `vercel.json` and `api/index.php`.

```bash
npx vercel
```

Set these environment variables in the Vercel dashboard:
- `APP_KEY` — from your local `.env`
- `DB_URI` — your MongoDB Atlas connection string
- `APP_ENV=production`
- `APP_DEBUG=false`
- `SESSION_DRIVER=cookie`
- `CACHE_STORE=array`

---

## 🛠️ Tech Stack

| Layer | Technology |
|---|---|
| Backend | Laravel 11 (PHP 8.4) |
| Database | MongoDB Atlas (via `mongodb/laravel-mongodb`) |
| Frontend | Blade Templates + Bootstrap 5 + Bootstrap Icons |
| Fonts | Google Fonts – Outfit |
| Build Tool | Vite |
| Mail | Laravel Mailable (log / SMTP) |
| Deployment | Vercel (Serverless PHP) |

---

## 🔑 Demo Credentials

```
Email:    demo@grocerydeals.com
Password: password
```

---

## 📄 License

This project is open-sourced under the [MIT License](LICENSE).

---

<p align="center">Made with 💚 using Laravel & MongoDB</p>
