<!-- Use this file to provide workspace-specific custom instructions to Copilot. For more details, visit https://code.visualstudio.com/docs/copilot/copilot-customization#_use-a-githubcopilotinstructionsmd-file -->

# CodeIgniter 4 PPDB Application

This is a Student Admission (PPDB) system built with CodeIgniter 4 framework.

## Project Structure
- `app/` - Application code (Controllers, Models, Views)
  - `Controllers/` - Request handlers
  - `Models/` - Database models
  - `Views/` - HTML templates
- `app/Database/` - Database migrations and seeds
- `public/` - Web accessible files
- `writable/` - Cache, logs, uploads

## Key Features
- User Authentication (Admin & Applicants)
- Student Registration Form
- Dashboard for applicants to track status
- Admin panel for managing applications
- Database integration with MySQL
- Form validation and security

## Coding Standards
- Follow PSR-4 autoloading standards
- Use CodeIgniter 4 conventions
- Add proper error handling and validation
- Use prepared statements for database queries
- Implement proper access control

## Commands
- `php spark serve` - Run development server
- `php spark migrate` - Run database migrations
- `php spark db:seed SampleSeeder` - Seed sample data
