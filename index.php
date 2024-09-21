<?php
session_start(); // Start a session to maintain the book list

// Book class definition with exception handling
class Book {
    private $title;
    private $author;
    private $year;

    public function __construct($title, $author, $year) {
        $this->setTitle($title);
        $this->setAuthor($author);
        $this->setYear($year);
    }

    public function setTitle($title) {
        if (empty($title)) {
            throw new Exception("Title cannot be empty.");
        }
        $this->title = $title;
    }

    public function setAuthor($author) {
        if (empty($author)) {
            throw new Exception("Author cannot be empty.");
        }
        $this->author = $author;
    }

    public function setYear($year) {
        if (!is_numeric($year) || $year < 1000 || $year > intval(date("Y"))) {
            throw new Exception("Invalid year. Please enter a valid year between 1000 and the current year.");
        }
        $this->year = $year;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getAuthor() {
        return $this->author;
    }

    public function getYear() {
        return $this->year;
    }
}

// Initialize an empty array to store books in session
if (!isset($_SESSION['bookArray'])) {
    $_SESSION['bookArray'] = [];
}
$errors = [];
$message = ''; // Variable for messages

// Handle form submission
if (isset($_POST['submit'])) {
    try {
        $title = $_POST['title'];
        $author = $_POST['author'];
        $year = $_POST['year'];

        // Validate input fields
       
        if (empty($title) || strlen($title) < 4 || !preg_match('/^[a-zA-Z0-9\s]+$/', $title)) {
            $errors['title'] = "Please enter a valid book title.";
        }
        if (empty($author) || strlen($author) < 4 || !preg_match('/^[a-zA-Z\s]+$/', $author)) {
            $errors['author'] = "Please enter the author's name.";
        }
        if (empty($year)) {
            $errors['year'] = "Please enter a publication year.";
        }

        // If no validation errors, create a new book object
        if (empty($errors)) {
            $book = new Book($title, $author, $year);
            // Store the book object in the session array
            $_SESSION['bookArray'][] = $book;

            // Clear the input fields by unsetting the values
            unset($_POST['title'], $_POST['author'], $_POST['year']);

            $message = "<p style='color: green; font-weight: bold;'>Book added successfully!</p>";
        }

    } catch (Exception $e) {
        $message = "<p style='color: red; font-weight: bold;'>Error: " . $e->getMessage() . "</p>";
    }
}

// Handle list reset
if (isset($_POST['reset_list'])) {
    $_SESSION['bookArray'] = []; // Clear the book list
    $message = "<p style='color: blue; font-weight: bold;'>Book list has been reset.</p>";
}

// Function to display books
function displayBooks($books, $message) {
    echo $message; // Display the message
    if (count($books) === 0) {
        echo "<p style='color: black; font-weight: bold;'>No books have been added yet.</p>";
    } else {
        echo "<h2>Book List</h2>";
        echo "<table>";
        echo "<tr><th>Title</th><th>Author</th><th>Year</th></tr>";

        foreach ($books as $book) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($book->getTitle()) . "</td>";
            echo "<td>" . htmlspecialchars($book->getAuthor()) . "</td>";
            echo "<td>" . htmlspecialchars($book->getYear()) . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Management System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1 style='color: wheat;'>Book Management System</h1>

<div class="container">
    <div class="form-container">
        <h2>Add a Book</h2>
        <form method="POST" action="">
            <label for="title">Book Title:</label>
            <input type="text" id="title" name="title" value="<?php echo isset($_POST['title']) ? htmlspecialchars($_POST['title']) : ''; ?>">
            <?php if (isset($errors['title'])): ?>
                <div class="error"><?php echo $errors['title']; ?></div>
            <?php endif; ?>

            <label for="author">Author:</label>
            <input type="text" id="author" name="author" value="<?php echo isset($_POST['author']) ? htmlspecialchars($_POST['author']) : ''; ?>">
            <?php if (isset($errors['author'])): ?>
                <div class="error"><?php echo $errors['author']; ?></div>
            <?php endif; ?>

            <label for="year">Publication Year:</label>
            <input type="number" id="year" name="year" value="<?php echo isset($_POST['year']) ? htmlspecialchars($_POST['year']) : ''; ?>" min="1000" max="9999">
            <?php if (isset($errors['year'])): ?>
                <div class="error"><?php echo $errors['year']; ?></div>
            <?php endif; ?>

            <div class="button-group">
                <input type="submit" name="submit" value="Add Book">
                <input type="reset" value="Reset Form" onclick="resetForm()">
                <input type="submit" name="reset_list" value="Reset List">
            </div>
        </form>
    </div>

    <div class="book-list-container">
        <?php
        // Display the list of books
        displayBooks($_SESSION['bookArray'], $message);
        ?>
    </div>
</div>

<script src="book_management.js"></script>

</body>
</html>
