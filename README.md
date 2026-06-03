# Fuelpump - PHP Authentication System with Google OAuth

A lightweight PHP authentication system featuring a traditional registration/login workflow, email verification simulation, and secure Google OAuth2 integration. This project is styled with a modern, scannable dark-themed interface for its dashboard.

---

## 🚀 Features

* **Secure Google OAuth 2.0 Integration:** Direct one-click login/signup via Google.


* **Traditional Authentication:** Register and sign in with email and password.


* **Account Verification Flow:** Seamless multi-step verification code handling.



* **Protected Dashboard:** Session-guarded homepage preventing unauthorized access.



---

## 📁 Project Structure

* `index.php` – The entry point containing the clean Sign In and Register forms.


* `register.php` – Core backend controller processing signup, sign-in, and verification routing.


* `verify.php` – Validates user accounts utilizing six-digit verification codes.


* `connect.php` – Database connection establishing script with auto-updating schema enforcement.


* `homepage.php` – The premium dashboard view showcasing nearby fuel pricing.


* `google_login.php` & `oauth_callback.php` – Handlers managing payload transactions with Google API.


* `oauth_config.php` – Modular configuration file for OAuth application credentials.


* `logout.php` – Flushes application state sessions securely.


* `style.css` & `script.js` – Frontend styling elements and responsive UX DOM animations.



---

## 🛠️ Setup Instructions

### 1. Database Setup

1. Open your local database management application (e.g., **phpMyAdmin**).
2. Create a database named `login`.


3. Import or create a `users` table containing basic profiles (e.g., `id`, `firstName`, `lastName`, `email`, `password`).



> **Note:** The `connect.php` script automatically scales your table schema to append `is_verified` and `verification_code` columns dynamically upon initialization!
> 
> 

### 2. Environment Configurations

Configure your MySQL database parameters inside `connect.php`:

```php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "login";

```

### 3. Setup Google Developer Console

To enable the Google Sign-In button:

1. Navigate to the **Google Cloud Console**.
2. Generate an **OAuth 2.0 Client ID**.
3. Supply your authorized redirect URI as: `http://localhost/login/oauth_callback.php`.


4. Swap the placeholder keys inside your local `oauth_config.php` with your unique live application credentials:



```php
'google' => [
    'client_id' => 'YOUR_CLIENT_ID.apps.googleusercontent.com',
    'client_secret' => 'YOUR_CLIENT_SECRET',
    'redirect_uri' => 'http://localhost/login/oauth_callback.php',
    'scope' => 'openid email profile'
]

```

---

## 🔒 Security Recommendations

This repository functions beautifully as a learning archetype and proof-of-concept. If migrating portions of this stack into production environments, consider prioritizing the following adjustments:

* **Upgrade Password Cryptography:** Swap out legacy `md5()` calculations inside `register.php` and `oauth_callback.php` for PHP native `password_hash()` (using `PASSWORD_BCRYPT` or `PASSWORD_ARGON2ID`).


* **Session Hardening:** Add safety attributes to cookie configurations (`session.cookie_secure`, `session.cookie_httponly`) to minimize session hijacking vectors.
* **CSRF Tokens:** Incorporate anti-Cross-Site Request Forgery tokens into forms within `index.php` and `verify.php` to prevent unauthorized commands.