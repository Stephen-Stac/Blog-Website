# Blog Website

## Description
A simple blog application that allows users to create, edit, delete posts, and add comments.

## Features
- User authentication (login and registration).
- Create, edit, and delete blog posts.
- Add comments to posts.
- Display all posts and user-specific posts.

## Technologies Used
- PHP
- MySQL
- HTML
- CSS

## Installation
1. Clone the repository.
2. Set up a MySQL database and import the necessary tables.
3. Update the database connection settings in `includes/db.php`.
4. Run the application on a local server (e.g., XAMPP).

## Usage
- Navigate to `index.php` to view all blog posts.
- Use the navigation bar to log in, register, or create a new post.
- Users can edit or delete their posts and add comments to any post.


## Security
- CSRF protection is implemented using tokens generated and validated in `includes/csrf.php`.
- Passwords are hashed using `password_hash` and verified using `password_verify`.

