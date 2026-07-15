# Complaint & Service Request Tracking System

A comprehensive Laravel-based complaint management system with robust authentication, role-based access control, a sleek Alpine.js and Tailwind CSS UI, and real-time database notifications.

## 🚀 Key Features

### 🔐 Authentication & Security
- **Session-based Authentication**: Secure authentication with mandatory email verification.
- **Role-Based Access Control (RBAC)**: Three distinct user roles (Admin, Staff, User) with granular boundaries and permissions.
- **Password Management**: Secure password reset functionality and encrypted storage.
- **Account Management**: Users can manage their own accounts and delete them. Admins have authority over all users.

### 👥 User Roles & Access

1. **Users** (`/dashboard`)
   - Submit and track service requests / complaints.
   - Withdraw pending complaints if they change their mind.
   - View complaint timeline, assignments, and resolution status.
   - Receive real-time notifications when their complaint status updates.

2. **Staff** (`/staff/dashboard`)
   - View and manage specifically assigned complaints.
   - Progressive state tracking (can only move from *Pending* -> *In Progress* -> *Resolved*).
   - Export assigned complaint data to CSV/Excel.
   - Receive notifications when assigned a new task.

3. **Administrators** (`/admin/dashboard`)
   - Complete oversight of the system via analytics and dashboard widgets.
   - Manage all users (create, verify emails, delete accounts).
   - Manage Categories and Departments.
   - Absolute control over complaint states (assign to staff, reject, resolve, withdraw).
   - Export all system data for reporting.

### 🔔 Notification System
- **Real-Time Alerts**: Powered by Alpine.js and Laravel Database Notifications.
- **Interactive Dropdown**: Notification bell in the navigation bar displaying unread badges and previews.
- **Bulk Management**: Dedicated `/notifications` page to filter (Read/Unread), sort, and perform bulk actions (Mark as Read, Delete) on notifications.
- **Context-Aware Routing**: Clicking a notification seamlessly directs you to the related complaint or user profile.

### ⚙️ Core Functionality
- **Complaint Management**: Full CRUD operations with detailed Activity Logs to track every status transition.
- **Strict Status Transitions**: Built-in business logic enforcing state rules based on the user's role.
- **Category Management**: Organize complaints dynamically by categories.
- **Advanced Filtering**: Search, filter by status, priority, category, and date ranges.

## 🎨 UI/UX Features
- **Tailwind CSS Integration**: Modern, responsive, mobile-first design.
- **Alpine.js Interactivity**: Used for dropdowns, modals, tabs, and dynamic state without heavy JS frameworks.
- **Toastr Alerts**: Elegant, non-intrusive success and error notifications across all panels.
- **SweetAlert2**: Beautiful confirmation dialogs for critical actions (Logout, Account Deletion).
- Clean, unified dashboard layouts with a distinct Admin Panel aesthetic.

## 🛠️ Tech Stack
- **Backend**: PHP 8.1+, Laravel 10.x/11.x
- **Frontend**: Blade Templating, Tailwind CSS, Alpine.js, Toastr, SweetAlert2
- **Database**: MySQL 8.0+ / SQLite
- **Authentication**: Laravel Breeze
- **Code Quality**: Enforced via Laravel Pint and automated PHPUnit tests.

---

## 🚀 Getting Started

### Prerequisites
- PHP 8.1 or higher
- Composer
- Node.js & NPM
- MySQL 8.0 or higher
- Web server (Apache/Nginx/Laragon/Valet)

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
   *In a separate terminal, run `npm run dev` if you intend to modify frontend assets.*

## 🔑 Default Login Credentials

After seeding the database, you can log in using these generated accounts:

### Admin User
- **Email**: `admin@example.com`
- **Password**: `password`
- **Role**: Admin

### Staff Users
- **Email**: `staff@example.com`
- **Password**: `password`
- **Role**: Staff

### Regular Users
- **Email**: `user@example.com`
- **Password**: `password`
- **Role**: User

---

## 🧪 Testing and Code Quality

This project maintains high code quality and test coverage.
To run the automated test suite:
```bash
php artisan test
```

To automatically format the code using Laravel Pint:
```bash
vendor/bin/pint
```

## 📝 License
This project is open-source and available under the [MIT License](LICENSE).

## 📧 Contact
For support, email [hamzaiqbalrajpoot35@gmail.com](mailto:hamzaiqbalrajpoot35@gmail.com)

---
<div align="center">
  Built with ❤️ using Laravel, Tailwind CSS, and Alpine.js
</div>