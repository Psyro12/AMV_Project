<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Room - AMV Hotel</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="../STYLE/room_booking.css">
    <link rel="stylesheet" href="../STYLE/utilities.css">
    <style>

    </style>
</head>

<body>
    <!-- Header -->
    <header>
        <div class="logo-container">
            <img src="../../IMG/5.png" alt="AMV Logo">
            <div class="logo-text">
                <span>AMV</span>
                <span>Hotel</span>
            </div>
        </div>

        <nav>
            <a href="login.php" class="btn">Sign In</a>
        </nav>
    </header>

    <?php
    $roomName = isset($_GET['room']) ? urldecode($_GET['room']) : 'Room';
    ?>

    <!-- Hero / Image background -->
    <section class="hero">
        <div class="hero-content">
            <h1><?php echo htmlspecialchars($roomName); ?></h1>
            <p>Book your stay at AMV Hotel — comfortable rooms and great service.</p>
            <!-- <a href="#bookingForm" class="btn">Book Now</a> -->
        </div>
    </section>

    <!-- Breadcrumb -->
    <!-- <div class="breadcrumb container">
        <a href="home_page.php">Home</a> > <a href="#rooms">Rooms</a> > Deluxe Room
    </div> -->

    <!-- Main Content -->
    <div class="container d-grid grid-cols-2 g-3 mt-3">
        <div class="booking-container">
            <!-- Room Details -->
            <div class="room-details">
                <h3><?php echo htmlspecialchars($roomName); ?></h3>
                <img src="../../IMG/room_1.jpg" alt="Deluxe Room">

                <div class="p-3">
                    <h2>Deluxe Room</h2>
                    <p>Spacious room with a queen-size bed, perfect for couples. Enjoy modern amenities and a beautiful
                        view
                        of the city.</p>
                    <div class="price">₱2,500 / night</div>
                </div>
            </div>

            <!-- Compact Amenities Section -->
            <div class="compact-amenities">
                <h3>ALL AMENITIES</h3>
                <div class="compact-amenities-grid">
                    <!-- Top Row -->
                    <div class="compact-amenity-item">
                        <div class="compact-amenity-icon">
                            <i class="fas fa-wifi"></i>
                        </div>
                        <h4 class="compact-amenity-title fs-base">Wireless Internet</h4>
                        <p class="compact-amenity-description fs-sm">High-speed WiFi available</p>
                    </div>

                    <div class="compact-amenity-item">
                        <div class="compact-amenity-icon">
                            <i class="fas fa-snowflake"></i>
                        </div>
                        <h4 class="compact-amenity-title fs-base">Air Conditioned</h4>
                        <p class="compact-amenity-description fs-sm">Climate control comfort</p>
                    </div>

                    <div class="compact-amenity-item">
                        <div class="compact-amenity-icon">
                            <i class="fas fa-concierge-bell"></i>
                        </div>
                        <h4 class="compact-amenity-title fs-base">Room Service</h4>
                        <p class="compact-amenity-description fs-sm">24/7 service available</p>
                    </div>

                    <div class="compact-amenity-item">
                        <div class="compact-amenity-icon">
                            <i class="fas fa-bed"></i>
                        </div>
                        <h4 class="compact-amenity-title fs-base">Linen/Towel Provided</h4>
                        <p class="compact-amenity-description fs-sm">Fresh linens available</p>
                    </div>

                    <!-- Bottom Row -->
                    <div class="compact-amenity-item">
                        <div class="compact-amenity-icon">
                            <i class="fas fa-tv"></i>
                        </div>
                        <h4 class="compact-amenity-title fs-base">Smart TV</h4>
                        <p class="compact-amenity-description fs-sm">Streaming services included</p>
                    </div>

                    <div class="compact-amenity-item">
                        <div class="compact-amenity-icon">
                            <i class="fas fa-soap"></i>
                        </div>
                        <h4 class="compact-amenity-title fs-base">Toiletries</h4>
                        <p class="compact-amenity-description fs-sm">Bathroom amenities</p>
                    </div>

                    <div class="compact-amenity-item">
                        <div class="compact-amenity-icon">
                            <i class="fas fa-wine-bottle"></i>
                        </div>
                        <h4 class="compact-amenity-title fs-base">Water Bottles</h4>
                        <p class="compact-amenity-description fs-sm">Complimentary water</p>
                    </div>

                    <div class="compact-amenity-item">
                        <div class="compact-amenity-icon">
                            <i class="fas fa-laptop"></i>
                        </div>
                        <h4 class="compact-amenity-title fs-base">Working Table</h4>
                        <p class="compact-amenity-description fs-sm">Dedicated workspace</p>
                    </div>
                </div>
            </div>

            <!-- Calendar Section -->
            <div class="calendar-section mt-3">
                <h2>AVAILABILITY CALENDAR</h2>
                <div class="calendar-container">
                    <div class="calendar">
                        <div class="calendar-header">
                            <button id="prevMonth"><i class="fa-solid fa-chevron-left"></i></button>
                            <h3 id="currentMonth">May 2025</h3>
                            <button id="nextMonth"><i class="fa-solid fa-chevron-right"></i></button>
                        </div>
                        <div class="calendar-grid" id="calendarGrid">
                            <!-- Calendar will be generated by JavaScript -->
                        </div>
                    </div>

                    <div class="calendar">
                        <div class="calendar-header">
                            <button id="prevMonth2"><i class="fa-solid fa-chevron-left"></i></button>
                            <h3 id="currentMonth2">June 2025</h3>
                            <button id="nextMonth2"><i class="fa-solid fa-chevron-right"></i></button>
                        </div>
                        <div class="calendar-grid" id="calendarGrid2">
                            <!-- Calendar will be generated by JavaScript -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- <div class="d-grid grid-cols-2">

        </div> -->


        <!-- Booking Form -->
        <div class="grid">
            <div class="booking-form-container">
                <h2>Book Your Stay</h2>
                <form id="bookingForm">
                    <div class="date-inputs">
                        <div class="form-group">
                            <label for="checkIn">Check-in Date</label>
                            <input type="date" id="checkIn" required>
                        </div>
                        <div class="form-group">
                            <label for="checkOut">Check-out Date</label>
                            <input type="date" id="checkOut" required>
                        </div>
                    </div>

                    <div id="nightsInfo" class="nights-info">0 nights</div>

                    <div class="guest-inputs">
                        <div class="form-group">
                            <label for="adults">Adults</label>
                            <select id="adults" required>
                                <option value="1">1 Adult</option>
                                <option value="2" selected>2 Adults</option>
                                <option value="3">3 Adults</option>
                                <option value="4">4 Adults</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="children">Children</label>
                            <select id="children">
                                <option value="0" selected>0 Children</option>
                                <option value="1">1 Child</option>
                                <option value="2">2 Children</option>
                                <option value="3">3 Children</option>
                            </select>
                        </div>
                    </div>

                    <div class="total-price">
                        <h3>Total Price</h3>
                        <div class="total-amount">₱0</div>
                    </div>

                    <button type="submit" class="btn book-now-btn">Book Now</button>
                </form>
            </div>
        </div>

    </div>

    <!-- Footer -->
    <footer>
        <div class="container">
            <p>&copy; 2025 AMV Hotel. All rights reserved.</p>
        </div>
    </footer>

    <script src="../SCRIPT/room_booking.js"></script>
</body>

</html>