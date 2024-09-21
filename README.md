# Book Management System

## Features
- Add books with title, author, and publication year.
- Validate input for title and author (minimum 4 characters, no special characters).
- Display a list of added books.
- Reset the book list and clear the form inputs.
- Responsive design with a user-friendly interface.

## Contents
- `index.php`: Main PHP file containing the logic for adding and displaying books.
- `style.css`: CSS file for styling the book management system layout and design.
- `book_management.js`: JavaScript file for handling form reset functionality.

## Files
1. **index.php**
   - Implements the book management functionality.
   - Contains the `Book` class for managing book attributes.
   - Handles form submissions and session storage of book data.

2. **style.css**
   - Styles the overall layout, including the form and book list containers.
   - Adds styles for buttons, tables, and error messages.

3. **book_management.js**
   - Contains JavaScript functions for client-side interactivity, such as resetting form error messages.

## Installation
1. Clone or download the repository.
2. Place the files in your web server's document root.
3. Access `index.php` through your web browser to start using the Book Management System.

## Usage
- Fill out the form to add a book.
- Click "Add Book" to save it to the list.
- Reset the form fields with the "Reset Form" button.
- Clear the book list with the "Reset List" button.
