<?php
// Start the session
session_start();

// Adjust this path to match where you saved FoodImageManager.php
// Based on testing.php, it seems your includes are deeper in the directory structure
// If this path fails, verify the location of FoodImageManager.php
require_once '../PHP/room_includes/includes/FoodImageManager.php';

// Check if the user is logged in (Authentication check from testing.php)
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

// Get user information
$user = $_SESSION['user'];

// Initialize Manager and Fetch Data
$foodManager = new FoodImageManager();
$allFoods = $foodManager->getAllFoodImages();

// Group foods by category for easier PHP handling if needed, 
// though we will largely handle this via JS filtering for a smooth UX.
$categories = [
    'main' => 'Main Courses',
    'appetizer' => 'Appetizers',
    'dessert' => 'Desserts',
    'drink' => 'Beverages'
];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dining Menu | AMV Hotel</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- Reuse your existing styles -->
    <link rel="stylesheet" href="../STYLE/home_page.css">
    <link rel="stylesheet" href="../STYLE/utilities.css">

    <style>
        /* --- REUSED STYLES FROM testing.php (Base Layout) --- */
        body {
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            background-color: #f9f9f9;
            overflow-x: hidden;
        }

        /* HEADER STYLES (Copied to match testing.php look) */
        header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 25px 5%;
            z-index: 1000;
            background-color: #ffffff;
            /* Solid background for menu page readability */
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.4s ease-in-out;
        }



        .logo-container {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo-container img {
            height: 40px;
        }

        .logo-text {
            display: flex;
            /* flex-direction: row; */
            align-items: baseline;
            gap: 6px;
            font-weight: 700;
            line-height: 1.1;
            color: #333;
            transition: color 0.4s ease;
        }

        .logo-text span:first-child {
            font-size: 18px;
            color: #333;
            /* white for contrast */
        }

        .logo-text span:last-child {
            font-size: 12px;
            font-weight: 400;
            color: #333;
            /* lighter gray for contrast */
        }

        nav {
            display: flex;
            align-items: center;
        }

        nav a {
            text-decoration: none;
            color: #333;
            font-weight: 500;
            font-size: 14px;
            margin-right: 25px;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: color 0.4s ease;
        }

        nav a:hover {
            color: #b8860b;
        }

        .nav-icons {
            display: flex;
            gap: 15px;
        }

        .icon-circle {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: #555;
            border: 1px solid #ddd;
            transition: all 0.4s ease;
        }

        .icon-circle:hover {
            background-color: #b8860b;
            border-color: #b8860b;
            color: #fff !important;
        }

        .burger-menu {
            color: #333;
            font-size: 24px;
            cursor: pointer;
            display: none;
        }

        @media (max-width: 992px) {
            .desktop-icons {
                display: none;
            }

            .burger-menu {
                display: block;
            }

            header {
                padding: 15px 20px;
            }
        }

        /* --- MENU SPECIFIC STYLES --- */
        .menu-hero {
            margin-top: 80px;
            /* Offset for fixed header */
            background-image: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('../../IMG/food_7.jpg');
            /* Reuse existing image */
            background-size: cover;
            background-position: center;
            height: 300px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
        }

        .menu-hero h1 {
            font-size: 3rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin: 0;
        }

        .menu-hero p {
            font-size: 1.1rem;
            font-weight: 400;
            margin-top: 10px;
            letter-spacing: 1px;
        }

        /* FILTER TABS */
        .menu-nav {
            display: flex;
            justify-content: center;
            gap: 15px;
            padding: 40px 20px;
            flex-wrap: wrap;
        }

        .filter-btn {
            padding: 10px 25px;
            border: 2px solid #ddd;
            border-radius: 30px;
            background: transparent;
            color: #555;
            font-family: 'Montserrat', sans-serif;
            font-weight: 600;
            font-size: 13px;
            text-transform: uppercase;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .filter-btn:hover,
        .filter-btn.active {
            border-color: #b8860b;
            background-color: #b8860b;
            color: white;
            box-shadow: 0 5px 15px rgba(184, 134, 11, 0.3);
        }

        /* MENU GRID */
        .menu-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px 80px 20px;
        }

        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 30px;
        }

        .menu-item {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            animation: fadeIn 0.5s ease forwards;
        }

        .menu-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }

        .menu-img-wrapper {
            height: 200px;
            overflow: hidden;
            position: relative;
        }

        .menu-img-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .menu-item:hover .menu-img-wrapper img {
            transform: scale(1.1);
        }

        .category-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background-color: rgba(255, 255, 255, 0.9);
            color: #b8860b;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .menu-info {
            padding: 25px;
            text-align: center;
        }

        .menu-title {
            font-size: 1.2rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 8px;
        }

        .menu-divider {
            width: 40px;
            height: 2px;
            background-color: #b8860b;
            margin: 10px auto;
        }

        .no-items {
            grid-column: 1 / -1;
            text-align: center;
            padding: 50px;
            color: #888;
            font-size: 1.2rem;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>

    <!-- HEADER -->
    <header id="mainHeader">
        <div class="logo-container">
            <img src="../../IMG/5.png" alt="AMV Logo">
            <div class="logo-text">
                <span>AMV</span>
                <span>Hotel</span>
            </div>
        </div>
        <nav>
            <!-- <a href="testing.php">Home</a> Link back to home -->
            <a href="#" class="active">Dining</a>
            <a href="#">Reservations</a>
            <div class="nav-icons desktop-icons">
                <div class="icon-circle"><i class="fa-solid fa-user"></i></div>
                <div class="icon-circle"><i class="fa-solid fa-shopping-cart"></i></div>
            </div>
            <div class="burger-menu">
                <i class="fa-solid fa-bars"></i>
            </div>
        </nav>
    </header>

    <!-- HERO SECTION -->
    <section class="menu-hero">
        <div>
            <h1>Exquisite Dining</h1>
            <p>Savor the flavors of our world-class cuisine</p>
        </div>
    </section>

    <!-- FILTER CONTROLS -->
    <nav class="menu-nav">
        <button class="filter-btn active" onclick="filterMenu('all')">All Items</button>
        <button class="filter-btn" onclick="filterMenu('main')">Main Courses</button>
        <button class="filter-btn" onclick="filterMenu('appetizer')">Appetizers</button>
        <button class="filter-btn" onclick="filterMenu('dessert')">Desserts</button>
        <button class="filter-btn" onclick="filterMenu('drink')">Beverages</button>
    </nav>

    <!-- MENU GRID -->
    <div class="menu-container">
        <div class="menu-grid" id="menuGrid">
            <?php if (!empty($allFoods)): ?>
                <?php foreach ($allFoods as $food): ?>
                    <?php
                    // Map raw category to readable name
                    $catRaw = htmlspecialchars($food['food_category']);
                    $catDisplay = $categories[$catRaw] ?? ucfirst($catRaw);
                    ?>
                    <div class="menu-item" data-category="<?php echo $catRaw; ?>">
                        <div class="menu-img-wrapper">
                            <!-- Use the 'url' property set by FoodImageManager -->
                            <img src="<?php echo htmlspecialchars($food['url']); ?>"
                                alt="<?php echo htmlspecialchars($food['food_name']); ?>">
                            <span class="category-badge"><?php echo $catDisplay; ?></span>
                        </div>
                        <div class="menu-info">
                            <h3 class="menu-title"><?php echo htmlspecialchars($food['food_name']); ?></h3>
                            <div class="menu-divider"></div>
                            <!-- If you had a price column, it would go here. -->
                            <!-- <p class="menu-price">$25.00</p> -->
                            <!-- If you had a description column in the DB, display it here -->
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="no-items">
                    <p>No menu items currently available. Please check back later.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- FOOTER -->
    <footer style="background: #333; color: white; padding: 20px; text-align: center;">
        <p>&copy; 2025 AMV Hotel. All rights reserved.</p>
    </footer>

    <script>
        function filterMenu(category) {
            const items = document.querySelectorAll('.menu-item');
            const buttons = document.querySelectorAll('.filter-btn');

            // Update active button state
            buttons.forEach(btn => {
                btn.classList.remove('active');
                if (btn.innerText.toLowerCase().includes(category) || (category === 'all' && btn.innerText === 'ALL ITEMS')) {
                    // Simple check for demo logic, relying on click context usually better
                }
            });

            // Highlight clicked button
            event.target.classList.add('active');

            // Filter Logic
            items.forEach(item => {
                const itemCategory = item.getAttribute('data-category');
                if (category === 'all' || itemCategory === category) {
                    item.style.display = 'block';
                    item.style.animation = 'none';
                    item.offsetHeight; /* trigger reflow */
                    item.style.animation = 'fadeIn 0.5s ease forwards';
                } else {
                    item.style.display = 'none';
                }
            });
        }
    </script>

</body>

</html>