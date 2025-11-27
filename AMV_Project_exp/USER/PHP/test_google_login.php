<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Room - AMV Hotel</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        /* Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Montserrat', sans-serif;
        }

        body {
            background-color: #f8f9fa;
            color: #333;
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            /* padding: 0 20px; */
        }

        /* Header */
        header {
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 15px 0;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo-container {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo-container img {
            height: 50px;
        }

        .logo-text {
            display: flex;
            flex-direction: column;
            line-height: 1.2;
        }

        .logo-text span:first-child {
            font-weight: 700;
            font-size: 1.5rem;
            color: #2c3e50;
        }

        .logo-text span:last-child {
            font-weight: 400;
            font-size: 1rem;
            color: #7f8c8d;
        }

        .btn {
            display: inline-block;
            background-color: #3498db;
            color: white;
            padding: 10px 20px;
            border-radius: 4px;
            text-decoration: none;
            font-weight: 600;
            transition: background-color 0.3s;
            border: none;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #2980b9;
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('../../IMG/room_1.jpg');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 100px 0;
            text-align: center;
        }

        .hero-content h1 {
            font-size: 2.5rem;
            margin-bottom: 15px;
        }

        .hero-content p {
            font-size: 1.2rem;
            margin-bottom: 25px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        /* Main Content Layout */
        .d-grid {
            display: grid;
        }

        .grid-cols-2 {
            grid-template-columns: 1fr 400px; /* Changed to 400px for form */
        }

        .g-3 {
            gap: 30px;
        }

        .mt-3 {
            margin-top: 30px;
        }

        .p-3 {
            padding: 20px;
        }

        /* Room Details */
        .booking-container {
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .room-details img {
            width: 100%;
            height: 250px;
            object-fit: cover;
        }

        .room-details h2 {
            font-size: 1.8rem;
            margin-bottom: 15px;
            color: #2c3e50;
        }

        .room-details p {
            color: #7f8c8d;
            margin-bottom: 20px;
        }

        .price {
            font-size: 1.5rem;
            font-weight: 700;
            color: #e74c3c;
            margin-top: 20px;
        }

        /* Amenities Section */
        .amenities-section {
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            margin-top: 20px;
        }

        .amenities-section h3 {
            font-size: 1.5rem;
            margin-bottom: 20px;
            color: #2c3e50;
        }

        .amenities-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        .amenity-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px;
            border-radius: 6px;
            transition: all 0.2s ease;
            background: #f8fafc;
        }

        .amenity-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.05);
        }

        .amenity-item i {
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: #3498db;
            color: white;
            font-size: 0.9rem;
        }

        .amenity-item span {
            font-weight: 500;
            color: #2c3e50;
        }

        /* Compact Amenities Section */
        .compact-amenities {
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            margin-top: 20px;
        }

        .compact-amenities h3 {
            font-size: 1.5rem;
            margin-bottom: 20px;
            color: #2c3e50;
            text-align: center;
        }

        .compact-amenities-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
        }

        .compact-amenity-item {
            text-align: center;
            padding: 15px 10px;
            border-radius: 6px;
            transition: all 0.2s ease;
            background: #f8fafc;
        }

        .compact-amenity-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.05);
        }

        .compact-amenity-icon {
            width: 40px;
            height: 40px;
            margin: 0 auto 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: #3498db;
            color: white;
            font-size: 1rem;
        }

        .compact-amenity-title {
            font-size: 0.95rem;
            font-weight: 600;
            margin-bottom: 6px;
            color: #2c3e50;
        }

        .compact-amenity-description {
            color: #7f8c8d;
            line-height: 1.3;
            font-size: 0.75rem;
            font-weight: 400;
        }

        /* Calendar Section */
        .calendar-section {
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            margin-top: 20px;
        }

        .calendar-section h2 {
            font-size: 1.5rem;
            margin-bottom: 20px;
            color: #2c3e50;
        }

        .calendar-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .calendar {
            border: 1px solid #e1e1e1;
            border-radius: 8px;
            overflow: hidden;
        }

        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 15px;
            background-color: #f8f9fa;
            border-bottom: 1px solid #e1e1e1;
        }

        .calendar-header h3 {
            font-size: 1rem;
            margin: 0;
        }

        .calendar-header button {
            background: none;
            border: none;
            cursor: pointer;
            color: #3498db;
            font-size: 0.9rem;
        }

        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            padding: 10px;
        }

        .calendar-grid div {
            text-align: center;
            padding: 8px 5px;
            font-size: 0.8rem;
        }

        .calendar-grid .day-header {
            font-weight: 600;
            color: #7f8c8d;
        }

        .calendar-grid .day {
            cursor: pointer;
            border-radius: 4px;
        }

        .calendar-grid .day:hover {
            background-color: #e3f2fd;
        }

        .calendar-grid .day.booked {
            background-color: #ffebee;
            color: #e74c3c;
            text-decoration: line-through;
        }

        .calendar-grid .day.selected {
            background-color: #3498db;
            color: white;
        }

        /* Booking Form - Increased to 400px */
        .booking-form-container {
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            padding: 25px;
            position: sticky;
            top: 100px;
            width: 400px; /* Increased to 400px */
            margin-left: auto; /* Align to right */
        }

        .booking-form-container h2 {
            font-size: 1.6rem;
            margin-bottom: 20px;
            color: #2c3e50;
            text-align: center;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #2c3e50;
            font-size: 0.95rem;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
        }

        .date-inputs,
        .guest-inputs {
            display: grid;
            grid-template-columns: 1fr 1fr; /* Back to two columns with more space */
            gap: 15px;
        }

        .nights-info {
            text-align: center;
            padding: 10px;
            background-color: #e3f2fd;
            border-radius: 4px;
            margin-bottom: 20px;
            font-weight: 600;
            font-size: 1rem;
        }

        .total-price {
            border-top: 1px solid #e1e1e1;
            padding-top: 20px;
            margin-top: 20px;
        }

        .total-price h3 {
            font-size: 1.2rem;
            margin-bottom: 10px;
            color: #2c3e50;
        }

        .total-amount {
            font-size: 1.8rem;
            font-weight: 700;
            color: #e74c3c;
        }

        .book-now-btn {
            width: 100%;
            padding: 15px;
            font-size: 1.1rem;
            margin-top: 20px;
        }

        /* Footer */
        footer {
            background-color: #2c3e50;
            color: white;
            text-align: center;
            padding: 20px 0;
            margin-top: 50px;
        }

        /* Responsive */
        @media (max-width: 900px) {
            .d-grid.grid-cols-2 {
                grid-template-columns: 1fr;
            }

            .booking-form-container {
                width: 100%;
                margin-left: 0;
            }

            .calendar-container {
                grid-template-columns: 1fr;
            }

            .date-inputs,
            .guest-inputs {
                grid-template-columns: 1fr;
            }

            .amenities-grid,
            .compact-amenities-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <!-- Header -->
    <header>
        <div class="container header-content">
            <div class="logo-container">
                <img src="../../IMG/5.png" alt="AMV Logo">
                <div class="logo-text">
                    <span>AMV</span>
                    <span>Hotel</span>
                </div>
            </div>
            <nav>
                <a href="home_page.php" class="btn">Back to Home</a>
            </nav>
        </div>
    </header>

    <?php
    $roomName = isset($_GET['room']) ? urldecode($_GET['room']) : 'Room';
    ?>

    <!-- Hero / Image background -->
    <section class="hero">
        <div class="hero-content">
            <h1><?php echo htmlspecialchars($roomName); ?></h1>
            <p>Book your stay at AMV Hotel — comfortable rooms and great service.</p>
            <a href="#bookingForm" class="btn">Book Now</a>
        </div>
    </section>

    <!-- Main Content -->
    <div class="container d-grid grid-cols-2 g-3 mt-3">
        <div class="booking-container">
            <!-- Room Details -->
            <div class="room-details">
                <img src="../../IMG/room_1.jpg" alt="Deluxe Room">

                <div class="p-3">
                    <h2>Deluxe Room</h2>
                    <p>Spacious room with a queen-size bed, perfect for couples. Enjoy modern amenities and a beautiful
                        view
                        of the city.</p>

                    <!-- <div class="amenities">
                        <h3>Amenities</h3>
                        <div class="amenities-grid">
                            <div class="amenity-item">
                                <i class="fa-solid fa-wifi"></i>
                                <span>Free Wi-Fi</span>
                            </div>
                            <div class="amenity-item">
                                <i class="fa-solid fa-tv"></i>
                                <span>Smart TV</span>
                            </div>
                            <div class="amenity-item">
                                <i class="fa-solid fa-snowflake"></i>
                                <span>Air Conditioning</span>
                            </div>
                            <div class="amenity-item">
                                <i class="fa-solid fa-shower"></i>
                                <span>Private Bathroom</span>
                            </div>
                            <div class="amenity-item">
                                <i class="fa-solid fa-mug-hot"></i>
                                <span>Coffee Maker</span>
                            </div>
                            <div class="amenity-item">
                                <i class="fa-solid fa-utensils"></i>
                                <span>Room Service</span>
                            </div>
                        </div>
                    </div> -->

                    <div class="price">₱2,500 / night</div>
                </div>
            </div>

            <!-- Compact Amenities Section -->
            <div class="compact-amenities">
                <h3>All Amenities</h3>
                <div class="compact-amenities-grid">
                    <!-- Top Row -->
                    <div class="compact-amenity-item">
                        <div class="compact-amenity-icon">
                            <i class="fas fa-wifi"></i>
                        </div>
                        <h4 class="compact-amenity-title">Wireless Internet</h4>
                        <p class="compact-amenity-description">High-speed WiFi available</p>
                    </div>
                    
                    <div class="compact-amenity-item">
                        <div class="compact-amenity-icon">
                            <i class="fas fa-snowflake"></i>
                        </div>
                        <h4 class="compact-amenity-title">Air Conditioned</h4>
                        <p class="compact-amenity-description">Climate control comfort</p>
                    </div>
                    
                    <div class="compact-amenity-item">
                        <div class="compact-amenity-icon">
                            <i class="fas fa-concierge-bell"></i>
                        </div>
                        <h4 class="compact-amenity-title">Room Service</h4>
                        <p class="compact-amenity-description">24/7 service available</p>
                    </div>
                    
                    <div class="compact-amenity-item">
                        <div class="compact-amenity-icon">
                            <i class="fas fa-bed"></i>
                        </div>
                        <h4 class="compact-amenity-title">Linen/Towel Provided</h4>
                        <p class="compact-amenity-description">Fresh linens available</p>
                    </div>
                    
                    <!-- Bottom Row -->
                    <div class="compact-amenity-item">
                        <div class="compact-amenity-icon">
                            <i class="fas fa-tv"></i>
                        </div>
                        <h4 class="compact-amenity-title">Smart TV</h4>
                        <p class="compact-amenity-description">Streaming services included</p>
                    </div>
                    
                    <div class="compact-amenity-item">
                        <div class="compact-amenity-icon">
                            <i class="fas fa-soap"></i>
                        </div>
                        <h4 class="compact-amenity-title">Toiletries</h4>
                        <p class="compact-amenity-description">Bathroom amenities</p>
                    </div>
                    
                    <div class="compact-amenity-item">
                        <div class="compact-amenity-icon">
                            <i class="fas fa-wine-bottle"></i>
                        </div>
                        <h4 class="compact-amenity-title">Water Bottles</h4>
                        <p class="compact-amenity-description">Complimentary water</p>
                    </div>
                    
                    <div class="compact-amenity-item">
                        <div class="compact-amenity-icon">
                            <i class="fas fa-laptop"></i>
                        </div>
                        <h4 class="compact-amenity-title">Working Table</h4>
                        <p class="compact-amenity-description">Dedicated workspace</p>
                    </div>
                </div>
            </div>

            <!-- Calendar Section -->
            <div class="calendar-section">
                <h2>Availability Calendar</h2>
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

        <!-- Booking Form - Now 400px wide -->
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

    <script>
        // Simple calendar functionality for demonstration
        document.addEventListener('DOMContentLoaded', function() {
            // Set minimum date for check-in to today
            const today = new Date();
            const tomorrow = new Date(today);
            tomorrow.setDate(tomorrow.getDate() + 1);
            
            document.getElementById('checkIn').min = today.toISOString().split('T')[0];
            document.getElementById('checkOut').min = tomorrow.toISOString().split('T')[0];
            
            // Update nights and price when dates change
            function updateBookingInfo() {
                const checkIn = new Date(document.getElementById('checkIn').value);
                const checkOut = new Date(document.getElementById('checkOut').value);
                
                if (checkIn && checkOut && checkOut > checkIn) {
                    const nights = Math.ceil((checkOut - checkIn) / (1000 * 60 * 60 * 24));
                    document.getElementById('nightsInfo').textContent = `${nights} nights`;
                    
                    const pricePerNight = 2500;
                    const totalPrice = nights * pricePerNight;
                    document.querySelector('.total-amount').textContent = `₱${totalPrice.toLocaleString()}`;
                } else {
                    document.getElementById('nightsInfo').textContent = '0 nights';
                    document.querySelector('.total-amount').textContent = '₱0';
                }
            }
            
            document.getElementById('checkIn').addEventListener('change', updateBookingInfo);
            document.getElementById('checkOut').addEventListener('change', updateBookingInfo);
            
            // Form submission
            document.getElementById('bookingForm').addEventListener('submit', function(e) {
                e.preventDefault();
                alert('Booking submitted successfully! We will contact you shortly.');
            });
            
            // Generate simple calendar for demonstration
            function generateCalendar(monthOffset, gridId) {
                const calendarGrid = document.getElementById(gridId);
                const monthNames = ["January", "February", "March", "April", "May", "June",
                    "July", "August", "September", "October", "November", "December"];
                
                const currentDate = new Date();
                currentDate.setMonth(currentDate.getMonth() + monthOffset);
                
                const month = currentDate.getMonth();
                const year = currentDate.getFullYear();
                
                // Set month title
                document.getElementById(`currentMonth${monthOffset === 0 ? '' : '2'}`).textContent = 
                    `${monthNames[month]} ${year}`;
                
                // Clear previous content
                calendarGrid.innerHTML = '';
                
                // Add day headers
                const days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
                days.forEach(day => {
                    const dayElement = document.createElement('div');
                    dayElement.className = 'day-header';
                    dayElement.textContent = day;
                    calendarGrid.appendChild(dayElement);
                });
                
                // Get first day of month
                const firstDay = new Date(year, month, 1).getDay();
                
                // Add empty cells for days before the first day of the month
                for (let i = 0; i < firstDay; i++) {
                    const emptyCell = document.createElement('div');
                    calendarGrid.appendChild(emptyCell);
                }
                
                // Add days of the month
                const daysInMonth = new Date(year, month + 1, 0).getDate();
                for (let day = 1; day <= daysInMonth; day++) {
                    const dayElement = document.createElement('div');
                    dayElement.className = 'day';
                    dayElement.textContent = day;
                    
                    // Randomly mark some days as booked for demo
                    if (Math.random() > 0.7) {
                        dayElement.classList.add('booked');
                    }
                    
                    calendarGrid.appendChild(dayElement);
                }
            }
            
            // Generate calendars
            generateCalendar(0, 'calendarGrid');
            generateCalendar(1, 'calendarGrid2');
            
            // Calendar navigation
            document.getElementById('prevMonth').addEventListener('click', function() {
                // In a real app, this would navigate to previous month
                alert('Previous month');
            });
            
            document.getElementById('nextMonth').addEventListener('click', function() {
                // In a real app, this would navigate to next month
                alert('Next month');
            });
            
            document.getElementById('prevMonth2').addEventListener('click', function() {
                // In a real app, this would navigate to previous month
                alert('Previous month');
            });
            
            document.getElementById('nextMonth2').addEventListener('click', function() {
                // In a real app, this would navigate to next month
                alert('Next month');
            });
        });
    </script>
</body>

</html>