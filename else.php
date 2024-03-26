<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Note Taking Website</title>
    <style>
        .sidebar {
            float: left;
            width: 20%; /* Adjust the width as needed */
            /* Add other styles for the sidebar */
        }
        .main-content {
            float: left;
            width: 60%; /* Adjust the width as needed */
            /* Add other styles for the main content area */
            overflow-y: auto; /* Enable vertical scrolling */
            height: 500px; /* Set a fixed height for demonstration */
        }
        .write-note-block {
            position: sticky;
            top: 0;
            background-color: #fff; /* Set background color */
            padding: 20px;
            z-index: 1000; /* Ensure it appears above other content */
        }
        .search-bar {
            position: sticky;
            top: 0;
            background-color: #fff; /* Set background color */
            padding: 20px;
            z-index: 1000; /* Ensure it appears above other content */
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav>
        <!-- Add your navbar content here -->
    </nav>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Add your sidebar content here -->
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- New Note Writing Block -->
        <div class="write-note-block">
            <h2>Write New Note</h2>
            <!-- Add your input fields and form for writing a new note -->
            <input type="text" placeholder="Write your new note here...">
            <!-- Add other form elements as needed -->
        </div>

        <!-- Search Bar -->
        <div class="search-bar">
            <h2>Search Notes</h2>
            <!-- Add your search input field and search button -->
            <input type="text" placeholder="Search notes...">
            <!-- Add search button or icon -->
            <button>Search</button>
        </div>

        <!-- Container for Displaying Past Notes -->
        <div class="notes-container">
            
        
        </div>
    </div>

    <!-- Third Sidebar (optional) -->
    <div class="sidebar">
        <!-- Add content for the third sidebar if needed -->
    </div>
</body>
</html>
