# Complaint & Service Request Tracking System

A comprehensive Laravel-based complaint management system with JWT authentication and role-based access control.

## 🚀 Features

- **JWT Authentication**: Secure token-based authentication with local storage
- **Role-Based Access**: Three user roles (User, Staff, Admin)
- **Modern UI**: Bootstrap 5 with custom styling and animations
- **Real-time Updates**: Live complaint status tracking
- **Password Reset**: Complete forgot password functionality
- **Responsive Design**: Works on all devices

## 🏗️ System Architecture

### User Roles & Access

1. **Users** (`/dashboard`)
   - Submit new complaints
   - View their own complaints
   - Track complaint status
   - Update profile

2. **Staff** (`/staff/complaints`)
   - View assigned complaints
   - Update complaint status
   - Add notes to complaints
   - Manage their workload

3. **Admin** (`/admin/complaints`)
   - View all complaints
   - Assign complaints to staff
   - Update complaint status
   - System-wide statistics
   - User management

## 🔐 Authentication System

### JWT Token Management

- **Login**: `/jwt/login` - Modern login interface with role selection
- **Token Storage**: JWT tokens stored in localStorage
- **Session Management**: Separate sessions for each role
- **Logout**: Automatic token invalidation and cleanup

### Password Reset Flow

1. **Forgot Password**: `/jwt/forgot-password`
2. **Reset Link**: Email with secure reset token
3. **Reset Password**: `/jwt/reset-password/{token}`

## 🎨 UI Improvements

### Dashboard Features

- **Horizontal Card Layout**: Statistics cards in modern horizontal design
- **Real-time Statistics**: Live complaint counts and percentages
- **Quick Actions**: Easy access to common tasks
- **Recent Activity**: Timeline of recent complaints
- **Responsive Design**: Mobile-friendly interface

### Modern Styling

- **Gradient Backgrounds**: Beautiful gradient designs
- **Card Animations**: Hover effects and smooth transitions
- **Icon Integration**: Font Awesome icons throughout
- **Color-coded Status**: Visual status indicators
- **Loading States**: Professional loading animations

## 🛠️ Installation & Setup

### Prerequisites

- PHP 8.2+
- Composer
- Node.js & NPM
- SQLite (or MySQL/PostgreSQL)

### Installation Steps

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd Complaint_Service_Request_Tracking_System
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   php artisan jwt:secret
   ```

4. **Database setup**
   ```bash
   php artisan migrate:fresh --seed
   ```

5. **Build assets**
   ```bash
   npm run dev
   ```

6. **Start the server**
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

## 🚪 How to Access Different Panels

### 1. JWT Login System

Visit `/jwt/login` to access the new JWT authentication system.

### 2. Role-Based Access

#### For Users:
- **Dashboard**: `/dashboard`
- **My Complaints**: `/complaints`
- **New Complaint**: `/complaints/create`

#### For Staff:
- **Assigned Complaints**: `/staff/complaints`
- **Update Status**: Available in complaint details

#### For Admin:
- **All Complaints**: `/admin/complaints`
- **Manage Complaints**: `/admin/complaints/{id}/edit`
- **System Statistics**: Available on admin dashboard

### 3. Navigation

The navigation bar automatically shows relevant links based on your role:
- **Users**: Dashboard, My Complaints, New Complaint
- **Staff**: Assigned Complaints, My Assignments
- **Admin**: All Complaints, Manage Complaints

## 🔧 API Endpoints

### Authentication
- `POST /api/login` - JWT login
- `POST /api/register` - User registration
- `POST /api/logout` - JWT logout
- `POST /api/refresh` - Token refresh
- `GET /api/me` - Get current user

### Password Reset
- `POST /api/forgot-password` - Send reset link
- `POST /api/reset-password` - Reset password

### Complaints
- `GET /api/complaints` - List complaints (role-based)
- `GET /api/complaints/{id}` - Get complaint details

## 🎯 Key Features Explained

### 1. JWT Authentication Flow

```javascript
// Login process
1. User submits credentials
2. Server validates and returns JWT token
3. Token stored in localStorage
4. Token used for subsequent requests
5. Automatic role-based redirect
```

### 2. Separate Sessions

- Each role has its own session
- Tokens are role-specific
- Logout clears all session data
- Automatic token refresh

### 3. Dashboard Improvements

- **Horizontal Layout**: Cards arranged horizontally for better space usage
- **Real-time Stats**: Live complaint statistics
- **Quick Actions**: Easy access to common tasks
- **Modern UI**: Bootstrap 5 with custom styling

### 4. Password Reset System

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

1. **JWT Token Issues**
   - Clear localStorage
   - Check token expiration
   - Verify JWT secret

2. **Database Issues**
   - Run migrations: `php artisan migrate:fresh --seed`
   - Check database connection
   - Verify .env configuration

3. **Asset Issues**
   - Run: `npm run dev`
   - Clear cache: `php artisan cache:clear`
   - Check Vite configuration

## 📞 Support

For issues or questions:
1. Check the troubleshooting section
2. Review the logs in `storage/logs/`
3. Verify your environment setup
4. Check Laravel documentation

## 🎉 Conclusion

This system provides a complete, modern complaint management solution with:
- Secure JWT authentication
- Role-based access control
- Modern, responsive UI
- Complete password reset functionality
- Real-time statistics and tracking

The dashboard has been completely redesigned with horizontal card layouts, modern styling, and improved user experience across all devices.
