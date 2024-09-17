<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .top-bar {
            background-color: black;
            padding: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 4rem; /* 16 Tailwind units equal 4rem */
        }
        .logo {
            height: 2.5rem; /* 10 Tailwind units equal 2.5rem */
            margin-left: 16rem; /* 64 Tailwind units equal 16rem */
        }
        .search-bar {
            display: none;
        }
        .search-bar.active {
            display: flex;
        }
        .dark-transparent {
            background-color: rgba(0, 0, 0, 0.8);
        }
        .search-input {
            background-color: rgba(0, 0, 0, 0.8);
            border: none;
            color: white;
        }
    </style>
</head>
<body>
    
<!-- Top bar with logo and search bar -->
<div class="top-bar">
    <img src="Bar_Logo.png" alt="Logo" class="logo">
</div>

</body>
</html>
