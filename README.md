# Complaint & Service Request Tracking System

A comprehensive Laravel-based complaint management system with authentication and role-based access control, featuring a modern UI.

## 🚀 Features

### Authentication & Security
- **Session-based Authentication**: Secure authentication with email verification
- **Role-Based Access Control**: Three distinct user roles with granular permissions
- **Password Management**: Secure password reset functionality
- **Email Verification**: Required for all new accounts

### User Roles & Access

1. **Users** (`/dashboard`)
   - Submit and track complaints
   - View complaint history and status
   - Update personal profile
   - Export complaint history

2. **Staff** (`/staff/dashboard`)
   - View and manage assigned complaints
   - Update complaint status
   - Export complaint data
   - View performance metrics

3. **Administrators** (`/admin/dashboard`)
   - Manage all system users
   - Handle categories and departments
   - View system analytics and reports
   - Export user and complaint data
   - Manage user email verification

### Core Functionality
- **Complaint Management**: Full CRUD operations for complaints
- **Category Management**: Organize complaints by categories
- **Search & Filters**: Advanced search with multiple filter options
- **Data Export**: Export complaints and user data
- **Activity Logs**: Track all important actions

## 🎨 UI/UX Features
- Modern, responsive design with Tailwind CSS
- Mobile-first approach for all devices
- Intuitive dashboard for each user role
- Clean and accessible interface

## 🛠️ Tech Stack
- **Backend**: PHP 8.1+, Laravel 10.x
- **Frontend**: HTML5, JavaScript, Tailwind CSS, Alpine.js
- **Database**: MySQL 8.0+
- **Authentication**: Laravel Breeze
- **Deployment**: Compatible with shared hosting

## 🚀 Getting Started

### Prerequisites
- PHP 8.1 or higher
- Composer
- Node.js & NPM
- MySQL 8.0 or higher
- Web server (Apache/Nginx)

### Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/hamzaiqbal35/Complaint_Service_Request_Tracking_System.git
   cd Complaint_Service_Request_Tracking_System
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install NPM dependencies**
   ```bash
   npm install
   npm run build
   npm run dev
   ```

4. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configure database**
   Update `.env` with your database credentials:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

6. **Run migrations and seeders**
   ```bash
   php artisan migrate --seed
   ```

7. **Start the development server**
   ```bash
   php artisan serve
   ```

## 🔑 Default Login Credentials

After seeding, you can login with these credentials:

### Admin User
- **Email**: admin@example.com
- **Password**: password
- **Role**: Admin

### Staff Users
- **Email**: staff@example.com
- **Password**: password
- **Role**: Staff

### Regular Users
- **Email**: user@example.com
- **Password**: password
- **Role**: User

##  Development Workflow

### Adding New Features
1. **Create Migration**: `php artisan make:migration create_new_table`
2. **Create Model**: `php artisan make:model NewModel`
3. **Create Controller**: `php artisan make:controller NewController`
4. **Add Routes**: Update `routes/web.php` or `routes/api.php`
5. **Create Views**: Add Blade templates
6. **Test**: Verify functionality

### Testing
```bash
# Run tests
php artisan test

# Run specific test
php artisan test --filter TestName
```

## 📝 License
This project is open-source and available under the [MIT License](LICENSE).

## 📧 Contact
For support, email [hamzaiqbalrajpoot35@gmail.com](mailto:hamzaiqbalrajpoot35@gmail.com)

## 🎉 Conclusion

This system provides a complete, modern complaint management solution with:
- Role-based access control
- Modern, responsive UI
- Real-time statistics and tracking

---

<div align="center">
  Made with using Laravel, MySQL, Tailwind CSS & Bootstrap
</div>