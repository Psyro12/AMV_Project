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
            flex-wrap: wrap; 
        }

        .control-group {
            flex: 1 1 200px; 
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
            user-select: none;
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

        /* --- GUEST DROPDOWN STYLES --- */
        .guest-dropdown {
            display: none; 
            position: absolute;
            top: 100%;
            left: 0;
            width: 300px;
            background: #fff;
            box-shadow: 0 5px 25px rgba(0,0,0,0.15);
            border-radius: 8px;
            padding: 20px;
            z-index: 100;
            margin-top: 10px;
            border: 1px solid #eee;
        }

        .guest-dropdown.show {
            display: block;
        }

        .guest-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .guest-label {
            display: flex;
            flex-direction: column;
        }

        .guest-type {
            font-weight: 600;
            font-size: 1rem;
            color: #333;
        }

        .guest-age {
            font-size: 0.75rem;
            color: #888;
        }

        .guest-counter {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .counter-btn {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: 1px solid #ccc;
            background: #fff;
            color: #555;
            font-size: 1.2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: 0.2s;
            padding-bottom: 3px;
        }

        .counter-btn:hover {
            border-color: #9e8236;
            color: #9e8236;
        }

        /* --- NEW: DISABLED BUTTON STYLE --- */
        .counter-btn.disabled {
            opacity: 0.3; /* Makes it look pale */
            cursor: not-allowed;
            border-color: #eee;
            color: #ccc;
            pointer-events: none; /* Prevents clicking */
        }

        .counter-val {
            font-weight: 600;
            font-size: 1.1rem;
            width: 20px;
            text-align: center;
        }

        .btn-done {
            width: 100%;
            background-color: #9e8236;
            color: #fff;
            border: none;
            padding: 12px;
            border-radius: 4px;
            font-weight: 600;
            cursor: pointer;
            text-transform: uppercase;
        }
        
        .btn-done:hover {
            background-color: #8c7330;
        }

        /* --- CALENDAR STYLES --- */
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

        .cal-nav-btn {
            background: none;
            border: none;
            color: #fff;
            font-size: 1.2rem;
            cursor: pointer;
            padding: 0 10px;
            transition: color 0.3s;
        }

        .cal-nav-btn:hover { color: #9e8236; }
        .cal-nav-btn:disabled { color: #888; cursor: not-allowed; visibility: hidden; }

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

        .cal-date { color: #333; transition: background 0.2s; }
        .cal-date:not(.disabled):not(.selected):not(.hover-range):hover { background-color: #f0f0f0; }
        .cal-date.disabled { color: #ccc; cursor: not-allowed; background-color: #f9f9f9; pointer-events: none; }
        .cal-date.selected { background-color: #9e8236; color: #fff; }
        .cal-date.range { background-color: rgba(158, 130, 54, 0.2); }
        .cal-date.hover-range { background-color: rgba(158, 130, 54, 0.4); }

        .action-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }

        .legend { display: flex; gap: 20px; font-size: 0.8rem; color: #666; }
        .legend-item { display: flex; align-items: center; gap: 8px; }
        .legend-box { width: 15px; height: 15px; border-radius: 2px; }
        .box-available { border: 1px solid #ddd; background: #fff; }
        .box-selected { background: #9e8236; }
        .box-disabled { background: #eee; }

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

        .btn-continue:hover { background-color: #8c7330; }

        @media (max-width: 768px) {
            .booking-controls, .calendars-row { flex-direction: column; }
            .guest-dropdown { width: 100%; } 
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
                    <label class="control-label">Guests</label>
                    <div class="control-input-box" id="guest-input-box" onclick="toggleGuestDropdown()">
                        <span id="guest-summary-text">1 Adult, 0 Children</span>
                        <i class="fa-solid fa-user-group"></i>
                    </div>

                    <div class="guest-dropdown" id="guest-dropdown">
                        
                        <div class="guest-row">
                            <div class="guest-label">
                                <span class="guest-type">Adults</span>
                                <span class="guest-age">Ages 13 or above</span>
                            </div>
                            <div class="guest-counter">
                                <button type="button" class="counter-btn" id="btn-adult-minus" onclick="updateGuest('adults', -1)">-</button>
                                <span class="counter-val" id="count-adults">1</span>
                                <button type="button" class="counter-btn" id="btn-adult-plus" onclick="updateGuest('adults', 1)">+</button>
                            </div>
                        </div>

                        <div class="guest-row">
                            <div class="guest-label">
                                <span class="guest-type">Children</span>
                                <span class="guest-age">Ages 0-12</span>
                            </div>
                            <div class="guest-counter">
                                <button type="button" class="counter-btn" id="btn-child-minus" onclick="updateGuest('children', -1)">-</button>
                                <span class="counter-val" id="count-children">0</span>
                                <button type="button" class="counter-btn" id="btn-child-plus" onclick="updateGuest('children', 1)">+</button>
                            </div>
                        </div>

                        <button type="button" class="btn-done" onclick="toggleGuestDropdown()">DONE</button>
                    </div>

                    <input type="hidden" name="adults" id="input-adults" value="1">
                    <input type="hidden" name="children" id="input-children" value="0">
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

        // Real current date
        const realCurrentMonth = today.getMonth();
        const realCurrentYear = today.getFullYear();

        // Variables for what the user is SEEING
        let displayMonth = realCurrentMonth;
        let displayYear = realCurrentYear;

        let checkInDate = null;
        let checkOutDate = null;

        // --- GUEST COUNTER LOGIC ---
        let adultCount = 1;
        let childCount = 0;
        const MAX_TOTAL_GUESTS = 4; // Combined limit
        const MAX_ADULTS = 4;       // Individual limit
        const MAX_CHILDREN = 4;     // Individual limit

        function toggleGuestDropdown() {
            const dropdown = document.getElementById('guest-dropdown');
            dropdown.classList.toggle('show');
            // Update states immediately when opening to ensure visual accuracy
            updateButtonStates();
        }

        function updateGuest(type, change) {
            // Stop click from bubbling up
            if (event) event.stopPropagation();

            const currentTotal = adultCount + childCount;
            
            // Prevent adding if Total Max reached
            if (change > 0 && currentTotal >= MAX_TOTAL_GUESTS) {
                return;
            }

            if (type === 'adults') {
                const newCount = adultCount + change;
                if (newCount < 1) return; // Min 1 Adult
                if (newCount > MAX_ADULTS) return; // Individual Max
                adultCount = newCount;
                
                document.getElementById('count-adults').innerText = adultCount;
                document.getElementById('input-adults').value = adultCount;

            } else if (type === 'children') {
                const newCount = childCount + change;
                if (newCount < 0) return; // Min 0 Children
                if (newCount > MAX_CHILDREN) return; // Individual Max
                childCount = newCount;
                
                document.getElementById('count-children').innerText = childCount;
                document.getElementById('input-children').value = childCount;
            }

            updateGuestSummary();
            updateButtonStates(); // Update visual state of buttons
        }

        function updateButtonStates() {
            const total = adultCount + childCount;

            // --- Adult Buttons ---
            const btnAdultMinus = document.getElementById('btn-adult-minus');
            const btnAdultPlus = document.getElementById('btn-adult-plus');

            // Disable minus if 1
            if (adultCount <= 1) btnAdultMinus.classList.add('disabled');
            else btnAdultMinus.classList.remove('disabled');

            // Disable plus if Adult Max reached OR Total Max reached
            if (adultCount >= MAX_ADULTS || total >= MAX_TOTAL_GUESTS) {
                btnAdultPlus.classList.add('disabled');
            } else {
                btnAdultPlus.classList.remove('disabled');
            }

            // --- Child Buttons ---
            const btnChildMinus = document.getElementById('btn-child-minus');
            const btnChildPlus = document.getElementById('btn-child-plus');

            // Disable minus if 0
            if (childCount <= 0) btnChildMinus.classList.add('disabled');
            else btnChildMinus.classList.remove('disabled');

            // Disable plus if Child Max reached OR Total Max reached
            if (childCount >= MAX_CHILDREN || total >= MAX_TOTAL_GUESTS) {
                btnChildPlus.classList.add('disabled');
            } else {
                btnChildPlus.classList.remove('disabled');
            }
        }

        function updateGuestSummary() {
            const adultText = adultCount === 1 ? '1 Adult' : `${adultCount} Adults`;
            const childText = childCount === 1 ? '1 Child' : `${childCount} Children`;
            document.getElementById('guest-summary-text').innerText = `${adultText}, ${childText}`;
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const box = document.getElementById('guest-input-box');
            const dropdown = document.getElementById('guest-dropdown');
            
            if (!box.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.classList.remove('show');
            }
        });
        
        // Initial button state check
        document.addEventListener('DOMContentLoaded', () => {
            updateButtonStates();
        });

        // --- CALENDAR & DATE LOGIC (Existing) ---
        const checkInText = document.getElementById('checkin-text');
        const checkOutText = document.getElementById('checkout-text');
        const checkInInput = document.getElementById('checkin-input');
        const checkOutInput = document.getElementById('checkout-input');
        const prevMonthBtn = document.getElementById('prevMonthBtn');

        document.addEventListener('DOMContentLoaded', () => {
            renderCalendars();
            checkInInput.addEventListener('change', (e) => handleInputUpdate(e.target.value, 'checkin'));
            checkOutInput.addEventListener('change', (e) => handleInputUpdate(e.target.value, 'checkout'));
        });

        function changeMonth(offset) {
            let newMonth = displayMonth + offset;
            let newYear = displayYear;

            if (newMonth > 11) { newMonth = 0; newYear++; } 
            else if (newMonth < 0) { newMonth = 11; newYear--; }

            if (newYear < realCurrentYear || (newYear === realCurrentYear && newMonth < realCurrentMonth)) return;

            displayMonth = newMonth;
            displayYear = newYear;
            renderCalendars();
        }

        function renderCalendars() {
            if (displayYear === realCurrentYear && displayMonth === realCurrentMonth) {
                prevMonthBtn.disabled = true;
            } else {
                prevMonthBtn.disabled = false;
            }
            renderMonth(displayYear, displayMonth, 'cal1-title', 'cal1-grid');

            let nextMonth = displayMonth + 1;
            let nextYear = displayYear;
            if (nextMonth > 11) { nextMonth = 0; nextYear++; }
            renderMonth(nextYear, nextMonth, 'cal2-title', 'cal2-grid');
        }

        function renderMonth(year, month, titleId, gridId) {
            const container = document.getElementById(gridId);
            const title = document.getElementById(titleId);
            const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
            title.innerText = `${monthNames[month]} ${year}`;
            container.innerHTML = '';

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
                cell.dataset.fullDate = dateObj.getFullYear() + '-' + (dateObj.getMonth() + 1) + '-' + dateObj.getDate();

                if (dateObj < today) {
                    cell.classList.add('disabled');
                } else {
                    cell.onclick = () => handleDateClick(dateObj);
                    if (checkInDate && !checkOutDate) {
                        cell.onmouseover = () => handleDateHover(dateObj, true);
                        cell.onmouseout = () => handleDateHover(dateObj, false);
                    }
                }

                if (checkInDate && isSameDate(dateObj, checkInDate)) cell.classList.add('selected');
                if (checkOutDate && isSameDate(dateObj, checkOutDate)) cell.classList.add('selected');
                if (checkInDate && checkOutDate && dateObj > checkInDate && dateObj < checkOutDate) cell.classList.add('range');

                container.appendChild(cell);
            }
        }

        function handleDateHover(hoverDate, isHovering) {
            if (!checkInDate || checkOutDate) return;
            const allDateCells = document.querySelectorAll('.cal-date:not(.disabled)');
            allDateCells.forEach(cell => {
                const dateParts = cell.dataset.fullDate.split('-').map(Number);
                const cellDate = new Date(dateParts[0], dateParts[1] - 1, dateParts[2]);
                cell.classList.remove('hover-range');
                if (isHovering && cellDate > checkInDate && (cellDate < hoverDate || isSameDate(cellDate, hoverDate))) {
                    cell.classList.add('hover-range');
                }
            });
        }

        function handleDateClick(date) {
            if (!checkInDate || checkOutDate) {
                checkInDate = date;
                checkOutDate = null;
            } else if (date <= checkInDate) {
                checkInDate = date;
                checkOutDate = null;
            } else {
                checkOutDate = date;
            }
            updateUI();
        }

        function handleInputUpdate(val, type) {
            if (!val) return;
            const date = new Date(val);
            const fixedDate = new Date(date.valueOf() + date.getTimezoneOffset() * 60000);
            if (fixedDate < today) {
                alert("Cannot select past dates.");
                if (type === 'checkin') checkInInput.value = ''; else checkOutInput.value = '';
                updateUI();
                return;
            }
            if (type === 'checkin') {
                checkInDate = fixedDate;
                if (checkOutDate && checkOutDate <= checkInDate) checkOutDate = null;
            } else {
                if (checkInDate && fixedDate > checkInDate) checkOutDate = fixedDate;
                else {
                    alert("Check-out must be after Check-in");
                    checkOutInput.value = '';
                    updateUI();
                    return;
                }
            }
            displayMonth = fixedDate.getMonth();
            displayYear = fixedDate.getFullYear();
            updateUI();
        }

        function updateUI() {
            if (checkInDate) {
                checkInText.innerText = formatDate(checkInDate);
                checkInText.style.color = "#333";
                checkInInput.value = checkInDate.toISOString().split('T')[0];
            } else {
                checkInText.innerText = "Select Date";
                checkInInput.value = '';
            }

            if (checkOutDate) {
                checkOutText.innerText = formatDate(checkOutDate);
                checkOutText.style.color = "#333";
                checkOutInput.value = checkOutDate.toISOString().split('T')[0];
            } else {
                checkOutText.innerText = "Select Date";
                checkOutInput.value = '';
            }

            renderCalendars();
        }

        function formatDate(date) {
            return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
        }

        function isSameDate(d1, d2) {
            return d1.getFullYear() === d2.getFullYear() && d1.getMonth() === d2.getMonth() && d1.getDate() === d2.getDate();
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