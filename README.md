# Order Management API

A Laravel-based REST API for managing orders and payments. Authenticated users can create and manage orders (with products and quantities), confirm orders, and process payments through a pluggable payment gateway.

**Features:**
- **Auth** — Login (Passport) returns a Bearer token for API access.
- **Orders** — Create, list (with optional status filter), show, update, and delete orders. Order items use product IDs; prices are taken from the products table.
- **Confirm** — Confirm an order and trigger payment processing.
- **Payments** — Generic payment gateway interface so you can swap providers (e.g. Stripe, PayPal) via config.

**Tech:** Laravel 8, Passport (API auth), MySQL.

**Assumed flow**
1. User creates an order and chooses a payment method (e.g. `credit_card`, `paypal`). The order is placed without entering payment details such as card number or payment account.
2. When the order is confirmed, a payment is charged using the chosen method. The flow assumes no callback from the payment gateway — the charge is processed synchronously.

**Quick start:** Run migrations and seeders. Default user: **user@user.com** / **password**. Then `POST /api/login` with email/password. Use the returned token in the `Authorization: Bearer {token}` header for all other endpoints.
