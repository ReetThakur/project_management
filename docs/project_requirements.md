Create a minimal project management tool using Laravel 12 with the following stack and features:


Tech Stack:
- Laravel 12
- Blade templates for frontend
- Tailwind CSS for styling
- Laravel Sanctum for authentication
- MySQL or PostgreSQL for database

Features:
1. Authentication 
   - Use Laravel Breeze with Blade frontend and Sanctum.
   - Register, Login, Logout, Forgot Password. 
   - Role selection on registration (Admin, Manager, Member).

2. User Roles
   - Admin: Full access to everything.
   - Manager: Can create/manage projects, assign tasks.
   - Member: Can view and manage their own tasks.
   - Implement using Laravel Policies.

3. Projects Module
   - Fields: title, description, start_date, due_date, status (Active, Completed), created_by.
   - Admin and Managers can create/edit/delete.
   - List view with status filter.
   - Blade UI with form to create/edit projects.

4. Tasks Module
- Fields: title, description, status (To Do, In Progress, Done), due_date, priority (Low, Medium, 
High), project_id, assigned_to.

   - CRUD from Blade UI.
   - Tasks shown under each project.
   - Assign task via dropdown of users.

5. Comments
   - Tasks can have multiple comments.
   - Each comment: content, created_by, timestamps.
   - Show task detail page with comments section (AJAX optional).

6. Dashboard
   - Overview for logged-in user:
     - Total Projects
     - Total Tasks
     - Tasks due today/this week
   - Rendered using Blade + Tailwind cards/charts.

7. Notifications
   - Store notifications in DB for:
     - Task assignment
     - Status change
     - Due date reminders (cron job optional)

8. General
   - Use Tailwind CSS for all styling (responsive).
   - Use Laravel's Resource classes for API responses.
   - Use layout components for header/sidebar/dashboard.
   - Use route groups for roles (admin, manager, member).

9. Bonus (optional)
   - Add search and filter on project/task list pages.
   - Dark mode toggle using Tailwind.

Structure code with good separation of concerns. Blade views should be modular 
(layouts, partials, components). Follow Laravel and Tailwind best practices.
