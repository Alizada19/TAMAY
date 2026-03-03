# Comprehensive Business Management System

A robust and versatile business management solution built on CodeIgniter 4, designed to streamline daily operations, financial tracking, and employee management for modern enterprises.

## Key Features

- **Attendance Management**: Track employee clock-in/out times, manage leaves, and generate detailed attendance reports with tolerance settings.
- **Salary & Payroll**: Automated salary calculation, payslip generation, and financial record keeping.
- **Expense Tracking**: Categorize and monitor business expenses with graphical insights and Excel/PDF reporting.
- **Perfume Inventory**: Specialized module for managing perfume stock, including olfactory notes (floral, oriental, woody, etc.) and category filtering.
- **Daily Sales Reporting**: Capture and analyze daily sales across multiple shop locations with MTD performance metrics.
- **Debtors & Creditors**: Comprehensive balance sheet management to track outstanding payments and collections.
- **Reporting Engine**: Generate professional PDF and Excel reports for sales, expenses, attendance, and payments.

## Tech Stack

- **Framework**: CodeIgniter 4.x (PHP 8.1+)
- **Frontend**: Bootstrap, jQuery, W3.CSS
- **Database**: MySQL/MariaDB
- **Reporting**: Dompdf for PDF generation, PHPExcel/PhpSpreadsheet for Excel.

## Installation Guide

### Prerequisites

- PHP 8.1 or higher
- MySQL 5.7+ or MariaDB 10.3+
- Composer installed globally
- PHP Extensions: `intl`, `mbstring`, `json`, `mysqlnd`, `libcurl`, `gd`

### Setup Steps

1. **Clone the Repository**
   ```bash
   git clone <repository-url>
   cd <project-folder>
   ```

2. **Install Dependencies**
   ```bash
   composer install
   ```

3. **Environment Configuration**
   - Copy `env` to `.env`:
     ```bash
     cp env .env
     ```
   - Edit `.env` and configure your database settings:
     ```env
     database.default.hostname = localhost
     database.default.database = your_db_name
     database.default.username = your_db_user
     database.default.password = your_db_password
     database.default.DBDriver = MySQLi
     ```

4. **Database Setup**
   - Create a new database in MySQL.
   - Import the provided SQL schema (if available) into your database.

5. **Run the Application**
   - You can use the built-in PHP server:
     ```bash
     php spark serve
     ```
   - Access the application at `http://localhost:8080`.

## Security Note

For production environments, ensure that your web server points to the `public/` directory as the document root to prevent unauthorized access to system files.

---
*Built with CodeIgniter 4 - Light, Fast, Flexible, and Secure.*
