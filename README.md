# Wachemo University Student Dating Web Application

A production-ready, scalable, secure, and visually modern student-only dating platform for Wachemo University, built with PHP, MySQL, HTML5, CSS3, and Vanilla JavaScript.

## Features

- **University Email Verification**: Only @wcu.edu.et emails allowed
- **Intelligent Matching**: Rule-based matching with interests, department, and age preferences
- **Real-time Chat**: AJAX-based messaging with typing indicators
- **3D UI/UX**: Smooth 3D interactions with glassmorphism, parallax effects, and animations
- **Security**: Prepared statements, CSRF protection, XSS prevention
- **Localization**: English and Amharic support
- **Admin Dashboard**: User management and moderation tools

## Tech Stack

- **Backend**: PHP (MVC structure)
- **Database**: MySQL
- **Frontend**: HTML5, CSS3 (3D transforms, animations), Vanilla JS
- **Security**: PDO, bcrypt hashing, session management

## Setup Instructions

1. **Database Setup**:
   ```bash
   mysql -u root -p < database/schema.sql
   ```

2. **Configure Database**:
   Edit `app/config/database.php` with your MySQL credentials.

3. **Web Server**:
   - Place the project in your web server's root directory (e.g., `/var/www/html/`)
   - Ensure PHP and MySQL are installed
   - For Apache, enable mod_rewrite if using URL rewriting

4. **Permissions**:
   ```bash
   chmod 755 public/images/
   ```

5. **Access**:
   - Open `index.php` in your browser
   - Register with a @wcu.edu.et email
   - Admin login: admin@wcu.edu.et (password: admin123)

## Project Structure

```
/
├── app/
│   ├── config/          # Database config
│   ├── controllers/     # MVC Controllers
│   ├── models/          # Data models
│   └── views/           # HTML templates
├── public/              # Static assets
│   ├── css/
│   ├── js/
│   └── images/
├── database/            # Schema
├── includes/            # Common functions
└── index.php            # Entry point
```

## Security Features

- Prepared statements for all queries
- Password hashing with bcrypt
- CSRF token validation
- Input sanitization
- Session hijacking prevention
- Rate limiting basics

## 3D UI Elements

- Profile cards with flip animations
- Swipe interactions with rotation
- Glassmorphism effects
- Parallax tilt on hover
- Smooth transitions and microinteractions

## Localization

Switch between English and Amharic using the dropdown in the header.

## Admin Features

- View and manage users
- Review and resolve reports
- Ban/suspend accounts
- Basic analytics

## Performance Optimizations

- Efficient database queries with indexes
- CSS hardware acceleration
- Image compression (implement in production)
- Lazy loading for images
- Minimized DOM reflows

## Future Enhancements

- Email verification via SMTP
- Push notifications
- Advanced matching algorithms
- Mobile app version
- Video chat integration