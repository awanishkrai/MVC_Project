# CraftNest

**CraftNest** is a production-style multi-vendor handmade marketplace inspired by Etsy. Buyers discover artisan goods, sellers run shops, and admins moderate the platform — all built with **Laravel 12**, **Blade**, **Tailwind CSS**, and **MySQL**.

![CraftNest](https://img.shields.io/badge/Laravel-12-red?style=flat-square&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=flat-square&logo=php)
![Tests](https://img.shields.io/badge/tests-56%20passing-success?style=flat-square)

---

## Features

### Public / Buyer
- Marketplace browsing with search, categories, and filters
- Product detail pages with reviews and ratings
- Session cart, checkout (COD + simulated card), order tracking
- Wishlist with heart favorites and move-to-cart
- In-app notification center + transactional emails
- Buyer profile and account management
- Dark mode with persisted theme preference
- Floating help chatbot (orders, shipping, payments, seller FAQ)

### Seller Panel
- Shop creation and storefront preview
- Product CRUD with image uploads
- Order management and status updates
- Review analytics dashboard
- Revenue/order charts (Chart.js)
- CSV export reports
- Low-stock and wishlist milestone alerts

### Admin Panel
- Platform dashboard and analytics
- Category CRUD
- Order oversight across vendors
- Review moderation
- Platform-wide reports and CSV exports

---

## Tech Stack

| Layer | Technology |
|-------|------------|
| Backend | Laravel 12 (MVC) |
| Frontend | Blade + Tailwind CSS + Vite |
| Database | MySQL (SQLite supported for tests) |
| Auth | Laravel Breeze-style session auth with roles |
| Notifications | Laravel database notifications |
| Email | Laravel Mailables (Mailtrap-compatible SMTP) |
| Charts | Chart.js |

---

## Screenshots

> Add screenshots to `/docs/screenshots/` and reference them here for your portfolio README.

| Home | Marketplace | Seller Dashboard |
|------|-------------|------------------|
| _screenshot-home.png_ | _screenshot-marketplace.png_ | _screenshot-seller.png_ |

---

## Installation

### Prerequisites
- PHP 8.2+
- Composer
- Node.js 18+
- MySQL 8+ (or MariaDB)

### Setup

```bash
# 1. Clone and enter project
cd handmade-marketplace

# 2. Install dependencies
composer install
npm install

# 3. Environment
copy .env.example .env   # Windows
# cp .env.example .env   # macOS/Linux

php artisan key:generate

# 4. Configure database in .env
# DB_DATABASE=craftnest
# DB_USERNAME=root
# DB_PASSWORD=your_password

# 5. Migrate and seed demo data
php artisan migrate --seed

# 6. Storage link (required for product/shop images)
php artisan storage:link

# 7. Build assets
npm run build
# or for development: npm run dev

# 8. Start server
php artisan serve
```

Visit **http://127.0.0.1:8000**

> **Note:** Do not run `php artisan migrate:fresh` unless you intend to wipe all data.

---

## Demo Accounts

Password for all accounts: **`password`**

| Role | Email |
|------|-------|
| Buyer | buyer@craftnest.test |
| Seller | seller@craftnest.test |
| Admin | admin@craftnest.test |

---

## Mail Setup (Optional)

Transactional emails are sent for order and review events when SMTP is configured.

```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_user
MAIL_PASSWORD=your_mailtrap_pass
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@craftnest.com"
MAIL_FROM_NAME="CraftNest"
CRAFTNEST_MAIL_NOTIFICATIONS=true
```

**Emails sent:**
- **Buyers:** order placed, shipped, delivered
- **Sellers:** new order, new review

Disable emails without affecting in-app notifications:

```env
CRAFTNEST_MAIL_NOTIFICATIONS=false
```

---

## Testing

```bash
php artisan test
```

All feature tests run against an in-memory SQLite database. Mail uses the `array` driver in tests.

---

## Architecture

```
app/
├── Http/Controllers/     # MVC controllers (Public, Seller, Admin, Auth)
├── Http/Middleware/      # Role-based access (buyer, seller, admin)
├── Models/               # Eloquent models
├── Services/             # Cart, notifications, analytics, email
├── Mail/                 # Transactional mailables
└── Notifications/        # Database notifications

resources/views/
├── layouts/              # public, seller, admin, guest (auth)
├── public/               # Buyer-facing pages
├── seller/               # Seller panel
├── admin/                # Admin panel
├── auth/                 # Login, register, password reset
├── components/           # Reusable Blade components
└── emails/               # Markdown email templates
```

**Route groups:** public marketplace, authenticated buyer routes, `seller/*`, `admin/*`

**Images:** stored in `storage/app/public`, served via `php artisan storage:link` and `PublicStorage` helper.

---

## Dark Mode

- Toggle in the navbar (public), seller topbar, admin topbar, and auth pages
- Preference stored in `localStorage` under `craftnest-theme`
- Admin panel defaults to dark; public/seller default to light

---

## Future Improvements

- Payment gateway integration (Stripe/PayPal)
- AI-powered chatbot with live order lookup (optional upgrade from rule-based assistant)
- Advanced search (facets, price range)
- Multi-language support
- PWA / mobile app
- Newsletter system (out of scope for current build)

---

## License

MIT — portfolio and educational use welcome.
