<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check Availability - AMV Hotel</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        /* --- GLOBAL STYLES --- */
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            color: #333;
        }

        /* HEADER */
        header {
            position: fixed;
            top: 0;
            width: 100%;
            padding: 15px 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 1000;
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .logo-container {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo-text span {
            color: #333;
            font-weight: 700;
            display: block;
            line-height: 1;
        }

        .logo-text span:first-child {
            font-size: 20px;
            color: #9e8236;
        }

        .logo-text span:last-child {
            font-size: 12px;
            letter-spacing: 1px;
        }

        nav {
            display: flex;
            align-items: center;
        }

        nav a {
            color: #333;
            text-decoration: none;
            margin-right: 25px;
            text-transform: uppercase;
            font-size: 0.8rem;
            font-weight: 600;
            letter-spacing: 1px;
            transition: color 0.3s;
        }

        nav a:hover {
            color: #9e8236;
        }

        .icon-circle {
            color: #555;
            border: 1px solid #ddd;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: 0.3s;
            cursor: pointer;
        }

        /* --- BOOKING STEPPER --- */
        .booking-stepper {
            margin-top: 80px;
            background-color: #fff;
            padding: 20px 0;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: center;
            gap: 50px;
        }

        .step-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            color: #ccc;
            font-size: 0.85rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .step-item.active {
            color: #9e8236;
            font-weight: 700;
        }

        .step-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 2px solid #ccc;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
            font-size: 1.2rem;
        }

        .step-item.active .step-icon {
            border-color: #9e8236;
            background-color: #9e8236;
            color: #fff;
        }

        /* --- MAIN BOOKING CONTAINER --- */
        .booking-container {
            max-width: 1200px;
            margin: 40px auto;
            background: #fff;
            padding: 40px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
            border-radius: 4px;
        }

        /* Controls */
        .booking-controls {
            display: flex;
            gap: 20px;
            margin-bottom: 40px;
            padding-bottom: 30px;
            border-bottom: 1px solid #eee;
        }

        .control-group {
            flex: 1;
            display: flex;
            flex-direction: column;
            position: relative;
        }

        .control-label {
            font-size: 0.8rem;
            text-transform: uppercase;
            color: #888;
            margin-bottom: 8px;
            font-weight: 600;
        }

        .control-input-box {
            border: 1px solid #ddd;
            padding: 15px;
            font-size: 1rem;
            color: #333;
            background: #f9f9f9;
            border-radius: 4px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            position: relative;
        }

        .control-input-box i {
            color: #9e8236;
        }

        .hidden-date-input {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
            z-index: 2;
        }

        /* Calendar Grid Section */
        .calendars-row {
            display: flex;
            gap: 40px;
            margin-bottom: 30px;
        }

        .calendar-wrapper {
            flex: 1;
        }

        .calendar-header {
            background-color: #666;
            color: #fff;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 1.2rem;
            font-weight: 600;
            border-radius: 4px 4px 0 0;
        }

        /* Navigation Buttons */
        .cal-nav-btn {
            background: none;
            border: none;
            color: #fff;
            font-size: 1.2rem;
            cursor: pointer;
            padding: 0 10px;
            transition: color 0.3s;
        }

        .cal-nav-btn:hover {
            color: #9e8236;
        }

        .cal-nav-btn:disabled {
            color: #888;
            cursor: not-allowed;
            visibility: hidden;
        }

        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            border: 1px solid #ddd;
            border-top: none;
        }

        .cal-cell {
            padding: 15px 5px;
            text-align: center;
            font-size: 0.9rem;
            cursor: pointer;
            border-bottom: 1px solid #f0f0f0;
            position: relative;
            z-index: 1;
        }

        .cal-head {
            font-weight: 700;
            color: #9e8236;
            font-size: 0.75rem;
            text-transform: uppercase;
            padding-top: 20px;
            margin-left: 30px;
        }

        .cal-date {
            color: #333;
            transition: background 0.2s;
        }

        /* Hover style for non-selected/non-disabled dates */
        .cal-date:not(.disabled):not(.selected):not(.hover-range):hover {
            background-color: #f0f0f0;
        }
        
        /* Disabled Dates */
        .cal-date.disabled {
            color: #ccc;
            cursor: not-allowed;
            background-color: #f9f9f9;
            pointer-events: none;
        }

        /* Selected Dates (Check-in / Check-out) */
        .cal-date.selected {
            background-color: #9e8236;
            color: #fff;
        }

        /* Range between selected dates */
        .cal-date.range {
            background-color: rgba(158, 130, 54, 0.2);
        }

        /* === NEW: HOVER RANGE STYLE === */
        /* Temporary hover range when only check-in is selected */
        .cal-date.hover-range {
            background-color: rgba(158, 130, 54, 0.4); 
        }

        /* Legend & Action Bar */
        .action-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }

        .legend {
            display: flex;
            gap: 20px;
            font-size: 0.8rem;
            color: #666;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .legend-box {
            width: 15px;
            height: 15px;
            border-radius: 2px;
        }

        .box-available {
            border: 1px solid #ddd;
            background: #fff;
        }

        .box-selected {
            background: #9e8236;
        }

        .box-disabled {
            background: #eee;
        }

        .btn-continue {
            background-color: #9e8236;
            color: #fff;
            border: none;
            padding: 15px 40px;
            font-size: 1rem;
            font-weight: 700;
            text-transform: uppercase;
            cursor: pointer;
            transition: 0.3s;
            border-radius: 4px;
        }

        .btn-continue:hover {
            background-color: #8c7330;
        }

        @media (max-width: 768px) {

            .booking-controls,
            .calendars-row {
                flex-direction: column;
            }
        }
    </style>
</head>

<body>

    <header>
        <div class="logo-container">
            <img src="../../IMG/5.png" alt="AMV Logo" style="height:40px;">
            <div class="logo-text">
                <span>AMV</span>
                <span>Hotel</span>
            </div>
        </div>
        <nav>
            <a href="about_us.php">About</a>
            <a href="check_availability.php" style="color:#9e8236;">Book Now</a>
            <div class="nav-icons">
                <div class="icon-circle"><i class="fa-solid fa-user"></i></div>
            </div>
        </nav>
    </header>

    <div class="booking-stepper">
        <div class="step-item active">
            <div class="step-icon"><i class="fa-regular fa-calendar-check"></i></div>
            Check-in & Check-out
        </div>
        <div class="step-item">
            <div class="step-icon"><i class="fa-solid fa-bed"></i></div>
            Select Rooms
        </div>
        <div class="step-item">
            <div class="step-icon"><i class="fa-regular fa-id-card"></i></div>
            Guest Info
        </div>
        <div class="step-item">
            <div class="step-icon"><i class="fa-solid fa-check"></i></div>
            Confirmation
        </div>
    </div>

    <div class="booking-container">

        <form id="bookingForm" action="select_rooms.php" method="GET">
            <div class="booking-controls">

                <div class="control-group">
                    <label class="control-label">Check-in</label>
                    <div class="control-input-box">
                        <span id="checkin-text">Select Date</span>
                        <i class="fa-regular fa-calendar"></i>
                        <input type="date" id="checkin-input" name="checkin" class="hidden-date-input">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Check-out</label>
                    <div class="control-input-box">
                        <span id="checkout-text">Select Date</span>
                        <i class="fa-regular fa-calendar"></i>
                        <input type="date" id="checkout-input" name="checkout" class="hidden-date-input">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Number of Night(s)</label>
                    <div class="control-input-box" style="cursor: default;">
                        <span id="nights-count">0</span>
                        <i class="fa-solid fa-moon"></i>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Special Code (Optional)</label>
                    <div class="control-input-box" style="cursor: text;">
                        <input type="text" name="promo_code" placeholder="Enter code..."
                            style="border:none; background:transparent; width:100%; font-size:1rem; outline:none; color:#333;">
                        <i class="fa-solid fa-tag"></i>
                    </div>
                </div>
            </div>
        </form>

        <div class="calendars-row">
            <div class="calendar-wrapper">
                <div class="calendar-header">
                    <button class="cal-nav-btn" id="prevMonthBtn" onclick="changeMonth(-1)"><i
                            class="fa-solid fa-chevron-left"></i></button>
                    <span id="cal1-title">Month 1</span>
                    <span style="width:24px;"></span>
                </div>
                <div class="calendar-grid" id="cal1-grid"></div>
            </div>

            <div class="calendar-wrapper">
                <div class="calendar-header">
                    <span style="width:24px;"></span>
                    <span id="cal2-title">Month 2</span>
                    <button class="cal-nav-btn" onclick="changeMonth(1)"><i
                            class="fa-solid fa-chevron-right"></i></button>
                </div>
                <div class="calendar-grid" id="cal2-grid"></div>
            </div>
        </div>

        <div class="action-bar">
            <div class="legend">
                <div class="legend-item">
                    <div class="legend-box box-available"></div> Available
                </div>
                <div class="legend-item">
                    <div class="legend-box box-selected"></div> Check-in/Out
                </div>
                <div class="legend-item">
                    <div class="legend-box box-disabled"></div> Booked/Past
                </div>
            </div>
            <button class="btn-continue" onclick="submitBooking()">CONTINUE <i
                    class="fa-solid fa-chevron-right"></i></button>
        </div>

    </div>

    <footer>
        <div style="background:#333; color:#fff; padding:30px; text-align:center;">
            <p>© 2025 AMV Hotel. All rights reserved.</p>
        </div>
    </footer>

    <script>
        const today = new Date();
        today.setHours(0, 0, 0, 0);

        // Real current date (for logic constraints)
        const realCurrentMonth = today.getMonth();
        const realCurrentYear = today.getFullYear();

        // Variables for what the user is SEEING (Calendar 1's month/year)
        let displayMonth = realCurrentMonth;
        let displayYear = realCurrentYear;

        let checkInDate = null;
        let checkOutDate = null;

        // Elements
        const checkInText = document.getElementById('checkin-text');
        const checkOutText = document.getElementById('checkout-text');
        const checkInInput = document.getElementById('checkin-input');
        const checkOutInput = document.getElementById('checkout-input');
        const nightsCount = document.getElementById('nights-count');
        const prevMonthBtn = document.getElementById('prevMonthBtn');
        const calendarContainers = document.querySelectorAll('.calendar-grid'); // Used for hover/range cleanup

        document.addEventListener('DOMContentLoaded', () => {
            renderCalendars();

            checkInInput.addEventListener('change', (e) => handleInputUpdate(e.target.value, 'checkin'));
            checkOutInput.addEventListener('change', (e) => handleInputUpdate(e.target.value, 'checkout'));
        });

        // --- NAVIGATION LOGIC ---
        function changeMonth(offset) {
            let newMonth = displayMonth + offset;
            let newYear = displayYear;

            if (newMonth > 11) {
                newMonth = 0;
                newYear++;
            } else if (newMonth < 0) {
                newMonth = 11;
                newYear--;
            }

            // Prevent going back past today's month
            if (newYear < realCurrentYear || (newYear === realCurrentYear && newMonth < realCurrentMonth)) {
                return;
            }

            displayMonth = newMonth;
            displayYear = newYear;
            renderCalendars();
        }

        // --- RENDER LOGIC ---
        function renderCalendars() {
            // Update Prev Button Visibility based on Current Date
            if (displayYear === realCurrentYear && displayMonth === realCurrentMonth) {
                prevMonthBtn.disabled = true; // Visually disabled
            } else {
                prevMonthBtn.disabled = false;
            }

            // Render First Calendar
            renderMonth(displayYear, displayMonth, 'cal1-title', 'cal1-grid');

            // Render Second Calendar (Next Month)
            let nextMonth = displayMonth + 1;
            let nextYear = displayYear;
            if (nextMonth > 11) { nextMonth = 0; nextYear++; }
            renderMonth(nextYear, nextMonth, 'cal2-title', 'cal2-grid');
        }

        function renderMonth(year, month, titleId, gridId) {
            const container = document.getElementById(gridId);
            const title = document.getElementById(titleId);

            const monthNames = ["January", "February", "March", "April", "May", "June",
                "July", "August", "September", "October", "November", "December"];
            title.innerText = `${monthNames[month]} ${year}`;

            container.innerHTML = '';

            // Headers
            const days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
            days.forEach(d => {
                const div = document.createElement('div');
                div.className = 'cal-head';
                div.innerText = d;
                container.appendChild(div);
            });

            const firstDay = new Date(year, month, 1).getDay();
            const daysInMonth = new Date(year, month + 1, 0).getDate();

            for (let i = 0; i < firstDay; i++) {
                const empty = document.createElement('div');
                empty.className = 'cal-cell disabled';
                container.appendChild(empty);
            }

            for (let i = 1; i <= daysInMonth; i++) {
                const dateObj = new Date(year, month, i);
                const cell = document.createElement('div');
                cell.className = 'cal-cell cal-date';
                cell.innerText = i;
                
                // Add data attribute for easier date retrieval on hover/click
                cell.dataset.fullDate = dateObj.getFullYear() + '-' + (dateObj.getMonth() + 1) + '-' + dateObj.getDate(); 

                // Disable Past Dates
                if (dateObj < today) {
                    cell.classList.add('disabled');
                } else {
                    cell.onclick = () => handleDateClick(dateObj);

                    // Add HOVER listeners ONLY if a Check-in date is set and Check-out is NOT
                    if (checkInDate && !checkOutDate) {
                        cell.onmouseover = () => handleDateHover(dateObj, true);
                        cell.onmouseout = () => handleDateHover(dateObj, false);
                    }
                }

                // Apply permanent selection classes
                if (checkInDate && isSameDate(dateObj, checkInDate)) cell.classList.add('selected');
                if (checkOutDate && isSameDate(dateObj, checkOutDate)) cell.classList.add('selected');
                if (checkInDate && checkOutDate && dateObj > checkInDate && dateObj < checkOutDate) {
                    cell.classList.add('range');
                }

                container.appendChild(cell);
            }
        }
        
        // --- HOVER LOGIC ---
        function handleDateHover(hoverDate, isHovering) {
            // Only proceed if Check-in is set and Check-out is not
            if (!checkInDate || checkOutDate) return;

            const allDateCells = document.querySelectorAll('.cal-date:not(.disabled)');

            allDateCells.forEach(cell => {
                const dateParts = cell.dataset.fullDate.split('-').map(Number);
                // Note: Months in JS are 0-indexed, so we subtract 1
                const cellDate = new Date(dateParts[0], dateParts[1] - 1, dateParts[2]);

                // Clear previous hover state
                cell.classList.remove('hover-range');

                if (isHovering && cellDate > checkInDate) {
                    // Apply hover range: between check-in (exclusive) and hovered date (inclusive)
                    if (cellDate < hoverDate || isSameDate(cellDate, hoverDate)) {
                        cell.classList.add('hover-range');
                    }
                }
            });
        }
        
        // --- SELECTION LOGIC ---
        function handleDateClick(date) {
            if (!checkInDate || checkOutDate) {
                // Case 1: Start new selection (no dates, or both dates set)
                checkInDate = date;
                checkOutDate = null;
            } else if (date <= checkInDate) {
                // Case 2: Clicked date is same or before Check-in -> Reset/Change Check-in
                checkInDate = date;
                checkOutDate = null; // Ensure checkout is cleared
            } else {
                // Case 3: Clicked date is after Check-in -> Set Check-out
                checkOutDate = date;
                // Since selection is complete, next click should start a new one.
            }
            
            updateUI();
        }


        function handleInputUpdate(val, type) {
            if (!val) return;
            const date = new Date(val);
            // Fix timezone offset issue for input[type="date"]
            const fixedDate = new Date(date.valueOf() + date.getTimezoneOffset() * 60000);

            if (fixedDate < today) {
                alert("Cannot select past dates.");
                // Reset the input field that triggered the change
                if (type === 'checkin') checkInInput.value = '';
                else checkOutInput.value = '';
                updateUI(); // Re-render to clear any invalid selections
                return;
            }

            if (type === 'checkin') {
                checkInDate = fixedDate;
                if (checkOutDate && checkOutDate <= checkInDate) checkOutDate = null;
            } else {
                if (checkInDate && fixedDate > checkInDate) {
                    checkOutDate = fixedDate;
                } else {
                    alert("Check-out must be after Check-in");
                    checkOutInput.value = ''; // Reset invalid input
                    updateUI();
                    return;
                }
            }
            // Navigate calendar to view selection
            displayMonth = fixedDate.getMonth();
            displayYear = fixedDate.getFullYear();
            updateUI();
        }

        function updateUI() {
            // Display Check-in Date
            if (checkInDate) {
                checkInText.innerText = formatDate(checkInDate);
                checkInText.style.color = "#333";
                const isoDate = checkInDate.toISOString().split('T')[0];
                if (checkInInput.value !== isoDate) checkInInput.value = isoDate;
            } else {
                checkInText.innerText = "Select Date";
                checkInInput.value = ''; // Clear hidden input value
            }

            // Display Check-out Date
            if (checkOutDate) {
                checkOutText.innerText = formatDate(checkOutDate);
                checkOutText.style.color = "#333";
                const isoDate = checkOutDate.toISOString().split('T')[0];
                if (checkOutInput.value !== isoDate) checkOutInput.value = isoDate;
            } else {
                checkOutText.innerText = "Select Date";
                checkOutInput.value = ''; // Clear hidden input value
            }

            // Calculate Nights Count
            if (checkInDate && checkOutDate) {
                const diffTime = Math.abs(checkOutDate - checkInDate);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                nightsCount.innerText = diffDays;
            } else {
                nightsCount.innerText = "0";
            }
            
            // Re-render the calendar grids to update selection/range/hover listeners
            renderCalendars();
        }

        function formatDate(date) {
            return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
        }

        function isSameDate(d1, d2) {
            return d1.getFullYear() === d2.getFullYear() &&
                d1.getMonth() === d2.getMonth() &&
                d1.getDate() === d2.getDate();
        }

        function submitBooking() {
            if (checkInDate && checkOutDate) {
                document.getElementById('bookingForm').submit();
            } else {
                alert("Please select both Check-in and Check-out dates.");
            }
        }
    </script>

</body>

</html>