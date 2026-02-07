# HeartWay

**Peace of mind, delivered in real time.**

HeartWay is a web application for tracking school buses live, receiving timely notifications, and staying confident about your child’s daily commute.

## Features

- **Live bus tracking** – Track school buses in real time
- **Notifications** – Get alerts about your child’s commute
- **Secure login** – Email/password with **OTP verification** sent to your email (Gmail)
- **Google Sign-In** – Sign in or register with your Google account
- **User roles** – Role-based access for parents, drivers, and admins

## Tech Stack

- **Backend:** Laravel 12, PHP 8.2
- **Auth:** Laravel Breeze, Google OAuth (Laravel Socialite)
- **Mail:** SMTP (Gmail) for OTP and notifications
- **Frontend:** Blade, Bootstrap, Tailwind CSS, Vite

## Requirements

- PHP 8.2+
- Composer
- Node.js & npm
- MySQL (or SQLite for local dev)

## Setup

1. **Clone the repository**
   ```bash
   git clone https://github.com/prasunpaudel/FYP-HeartWay.git
   cd FYP-HeartWay
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   Edit `.env`: set database credentials and (for OTP/login emails) Gmail SMTP:
   - `MAIL_MAILER=smtp`
   - `MAIL_HOST=smtp.gmail.com`
   - `MAIL_PORT=587`
   - `MAIL_USERNAME` / `MAIL_PASSWORD` (use a [Gmail App Password](https://myaccount.google.com/apppasswords))
   - `MAIL_ENCRYPTION=tls`

4. **Database**
   ```bash
   php artisan migrate
   ```

5. **Frontend**
   ```bash
   npm install
   npm run build
   ```

6. **Run the app**
   ```bash
   php artisan serve
   ```
   Visit `http://localhost:8000`. For dev with hot reload:
   ```bash
   npm run dev
   ```
   (and in another terminal: `php artisan serve`)

## Google Sign-In

1. Create OAuth credentials at [Google Cloud Console](https://console.cloud.google.com/apis/credentials).
2. Set `GOOGLE_CLIENT_ID` and `GOOGLE_CLIENT_SECRET` in `.env`.
3. Add authorized redirect URI: `http://localhost:8000/auth/google/callback` (or your `APP_URL` + `/auth/google/callback`).

## Login flow

- **Email/password:** User enters credentials → OTP is sent to their email → they enter the 6-digit code → logged in.
- **Register:** Name, email, password → account created and user logged in (no OTP).
- **Google:** One-click sign-in or registration via Google.

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
