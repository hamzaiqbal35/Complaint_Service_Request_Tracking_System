# Complaint & Service Request Tracking System

A comprehensive Laravel-based complaint management system with authentication and role-based access control, featuring a modern UI with animated interfaces.

## 🚀 Features

### Authentication & Security
- **JWT Authentication**: Secure token-based authentication with local storage
- **Role-Based Access Control**: Three distinct user roles with granular permissions
- **Password Management**: Secure password reset functionality
- **Session Management**: Secure session handling with configurable lifetime

### User Roles & Access

1. **Users** (`/dashboard`)
   - Submit and track complaints
   - View complaint history and status
   - Update personal profile
   - Receive email notifications

2. **Staff** (`/staff/dashboard`)
   - View and manage assigned complaints
   - Update complaint status
   - Add internal notes and comments
   - View performance metrics

3. **Administrators** (`/admin/dashboard`)
   - Manage all system users
   - Handle categories and departments
   - View system analytics and reports
   - Configure system settings

### Core Functionality
- **Complaint Management**: Full CRUD operations for complaints
- **Real-time Updates**: Live status tracking and notifications
- **File Attachments**: Support for complaint-related documents and images
- **Search & Filters**: Advanced search with multiple filter options
- **Activity Logs**: Comprehensive audit trail of all actions

## 🎨 UI/UX Features
- Modern, responsive design with Bootstrap 5
- Animated interfaces with smooth transitions
- Mobile-first approach for all devices
- Accessibility compliant (WCAG 2.1)
- Custom theming with dark/light mode support

## 🛠️ Tech Stack
- **Backend**: PHP 8.1+, Laravel 10.x
- **Frontend**: HTML5, CSS3, JavaScript, Bootstrap 5
- **Database**: MySQL 8.0+
- **Authentication**: JWT (tymon/jwt-auth)
- **Deployment**: Compatible with shared hosting (e.g., InfinityFree)

## � Getting Started

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
- **Email**: staff@example.com (or any staff email)
- **Password**: password
- **Role**: Staff

### Regular Users
- **Email**: user@example.com (or any user email)
- **Password**: password
- **Role**: User


## 🎯 Key Features Explained

### 1. Dashboard Improvements

- **Horizontal Layout**: Cards arranged horizontally for better space usage
- **Real-time Stats**: Live complaint statistics
- **Quick Actions**: Easy access to common tasks
- **Modern UI**: Bootstrap 5 with custom styling

### 2. Password Reset System

- **Secure Tokens**: Time-limited reset tokens
- **Email Integration**: Automatic email sending
- **User-friendly**: Simple reset process
- **Validation**: Proper password validation

## 🚨 Security Features

- **JWT Token Invalidation**: Tokens are properly invalidated on logout
- **Role-based Middleware**: Access control for all routes
- **CSRF Protection**: All forms protected
- **Input Validation**: Comprehensive validation rules
- **Secure Password Reset**: Time-limited tokens

## 📱 Responsive Design

- **Mobile-first**: Optimized for mobile devices
- **Tablet Support**: Responsive on tablets
- **Desktop Optimization**: Full-featured desktop experience
- **Touch-friendly**: Optimized for touch interfaces

## 🔄 Development Workflow

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

## 🐛 Troubleshooting

### Common Issues

1. **Database Issues**
   - Run migrations: `php artisan migrate:fresh --seed`
   - Check database connection
   - Verify .env configuration

2. **Asset Issues**
   - Run: `npm run dev`
   - Clear cache: `php artisan cache:clear`
   - Check Vite configuration

## 📝 License
This project is open-source and available under the [MIT License](LICENSE).

## 📧 Contact
For support, email [hamzaiqbalrajpoot35@gmail.com](mailto:hamzaiqbalrajpoot35@gmail.com)

## 🎉 Conclusion

This system provides a complete, modern complaint management solution with:
- Role-based access control
- Modern, responsive UI
- Real-time statistics and tracking

The dashboard has been completely designed with horizontal card layouts, modern styling, and improved user experience across all devices.

---

<div align="center">
  Made with using Laravel, MySQL, Tailwind CSS & Bootstrap
</div>