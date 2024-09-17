<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
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
            background-color: rgba(0, 0, 0, 0.9); /* Darker background color */
            border: none; /* Remove border */
            color: white; /* Set text color to white */
            outline: none; /* Remove outline on focus */
            box-shadow: none; /* Remove any box shadow */
        }
    </style>
</head>
<body>
    
<!-- Top bar with logo and search bar -->
<div class="bg-black p-2 flex items-center justify-between h-16">
    <img src="Bar_Logo.png" alt="Logo" class="h-10 ml-64">
    <div class="flex items-center gap-4 mr-64">
        <!-- <div id="search-bar" class="search-bar dark-transparent rounded-md p-2">
            <form action="" method="post" class="flex">
                <input type="text" name="search" class="form-control w-64 px-3 py-2 rounded-l-md search-input" placeholder="Search by Movie Name, Genre, or Language" value="<?php echo $searchQuery; ?>">
                <button type="submit" name="moviesrh" class="bg-black text-white px-3 py-2 rounded-r-md">Search</button>
            </form>
        </div> -->
    </div>
</div>

<!-- <script>
    document.getElementById('search-icon').addEventListener('click', function() {
        document.getElementById('search-bar').classList.toggle('active');
    });
</script> -->
</body>
</html>
