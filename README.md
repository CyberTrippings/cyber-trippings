# Simple PHP Registration and Login System

This repository is a basic PHP authentication example demonstrating how to build a registration and login flow with a database connection.

## Project Overview

Features included in this project:
- User registration (`register.php`)
- User login (`index.php`)
- User verification (`verify.php`)
- Simple session-based protected page (`homepage.php`)
- Logout support (`logout.php`)
- Google OAuth integration example (`google_login.php`, `oauth_callback.php`, `oauth_config.php`)
- Database connection helper (`connect.php`)
- Frontend assets (`style.css`, `script.js`)

## Setup Instructions

1. Place the project folder in your web server root (for example, `c:\xampp\htdocs\login`).
2. Create a MySQL database and a `users` table.
3. Update `connect.php` with your database host, username, password, and database name.
4. Open the project in your browser, for example: `http://localhost/login/`

## Recommended Security Improvements

This example is intended for learning and should not be used in production without enhancements.

Recommended improvements:
- Use prepared statements or parameterized queries to prevent SQL injection.
- Hash passwords securely with `password_hash()` and verify with `password_verify()`.
- Validate and sanitize all input data.
- Add CSRF protection for forms.
- Use HTTPS in production environments.
- Consider a framework such as Laravel for a more secure and maintainable authentication system.

## Notes

- The OAuth files are provided as an example and may require configuration with a Google API project.
- This repository is a learning example, not a production-ready authentication solution.

## References

For more advanced authentication examples, review a dedicated PHP auth starter kit or framework-based authentication tutorial.

