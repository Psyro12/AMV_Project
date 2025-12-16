<?php
session_start();

// 1. DATABASE CONNECTION
$servername = "localhost";
$username = "root"; // Change if needed
$password = ""; // Change if needed
$dbname = "amv_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}
$user = $_SESSION['user'];

// 2. FETCH DASHBOARD STATS
// Total Bookings
$sql_bookings = "SELECT COUNT(*) as total FROM bookings";
$result_bookings = $conn->query($sql_bookings);
$totalBookings = $result_bookings->fetch_assoc()['total'];

// Total Revenue (Only confirmed)
$sql_revenue = "SELECT SUM(total_price) as total FROM bookings WHERE status = 'confirmed'";
$result_revenue = $conn->query($sql_revenue);
$totalRevenue = $result_revenue->fetch_assoc()['total'] ?? 0;

// Total Orders (Placeholder - Table missing in DB)
$totalOrders = 0;

// 3. FETCH CHART DATA
// Pie Chart (Status Breakdown)
$sql_pie = "SELECT status, COUNT(*) as count FROM bookings GROUP BY status";
$result_pie = $conn->query($sql_pie);
$pieData = ['confirmed' => 0, 'pending' => 0, 'cancelled' => 0];
while ($row = $result_pie->fetch_assoc()) {
    $pieData[$row['status']] = $row['count'];
}

// --- Calculate Percentages for the Progress Bars ---
$totalPie = array_sum($pieData);
$pctConfirmed = $totalPie > 0 ? round(($pieData['confirmed'] / $totalPie) * 100) : 0;
$pctPending = $totalPie > 0 ? round(($pieData['pending'] / $totalPie) * 100) : 0;
$pctCancelled = $totalPie > 0 ? round(($pieData['cancelled'] / $totalPie) * 100) : 0;

// Bar Chart (Monthly Revenue for Current Year)
$currentYear = date('Y');
$sql_bar = "SELECT MONTH(check_in) as month, SUM(total_price) as total 
            FROM bookings 
            WHERE status='confirmed' AND YEAR(check_in) = '$currentYear' 
            GROUP BY MONTH(check_in)";
$result_bar = $conn->query($sql_bar);
$barData = array_fill(1, 12, 0); // Initialize Jan-Dec with 0
while ($row = $result_bar->fetch_assoc()) {
    $barData[$row['month']] = $row['total'];
}

// 4. CALENDAR DATA LOGIC
$allRooms = [101, 102, 103, 104, 105, 201, 202];
$calendarData = [];

// Fetch all active bookings with room details
$sql_cal = "SELECT b.id, b.check_in, b.check_out, b.status, br.room_id, br.room_name, u.name as guest_name 
            FROM bookings b 
            JOIN booking_rooms br ON b.id = br.booking_id 
            JOIN users u ON b.user_id = u.id
            WHERE b.status IN ('confirmed', 'pending')";
$result_cal = $conn->query($sql_cal);

while ($row = $result_cal->fetch_assoc()) {
    $start = new DateTime($row['check_in']);
    $end = new DateTime($row['check_out']);

    for ($date = clone $start; $date < $end; $date->modify('+1 day')) {
        $dateStr = $date->format('Y-m-d');

        if (!isset($calendarData[$dateStr])) {
            $calendarData[$dateStr] = [];
        }

        $todayStr = date('Y-m-d');
        $colorType = 'future'; // Default Yellow

        if ($dateStr <= $todayStr && $row['status'] == 'confirmed') {
            $colorType = 'in_house'; // Gold
        }

        $calendarData[$dateStr][] = [
            'room_id' => $row['room_id'],
            'room_name' => $row['room_name'],
            'guest' => $row['guest_name'],
            'status' => $row['status'],
            'type' => $colorType,
            'check_in' => $row['check_in'],   // Added
            'check_out' => $row['check_out']  // Added
        ];
    }
}

// Pass PHP data to JS
$js_pieData = json_encode([$pieData['confirmed'], $pieData['pending'], $pieData['cancelled']]);
$js_barData = json_encode(array_values($barData));
$js_calendarData = json_encode($calendarData);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AMV - Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="../STYLE/dashboard-styles.css">
    <link rel="stylesheet" href="../STYLE/utilities.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        /* --- LOCK PAGE & DISABLE SCROLL --- */
        html,
        body {
            height: 100%;
            margin: 0;
            overflow: hidden;
            /* Disables scroll */
        }

        .dashboard-container {
            height: 100vh;
            /* Full Viewport Height */
            display: flex;
            overflow: hidden;
        }

        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            height: 100%;
            overflow: hidden;
        }

        .page-content {
            flex: 1;
            padding: 20px;
            overflow: hidden;
            /* Prevents scrollbars in content area */
            display: flex;
            flex-direction: column;
        }

        /* Dashboard Page Specific Layout to Stretch Charts */
        #dashboard.page.active {
            display: flex;
            flex-direction: column;
            height: 100%;
            gap: 1rem;
        }

        .stats-grid {
            flex: 0 0 auto;
            /* Don't grow, stick to content size */
        }

        /* Charts Grid fills remaining space */
        .charts-grid-dashboard {
            flex: 1;
            min-height: 0;
            /* Allows flex child to shrink properly */
            display: flex;
            gap: 1rem;
            align-items: stretch;
            /* Stretch children vertically */
        }

        /* Chart Cards stretch to fill grid */
        .chart-card {
            height: 100%;
            display: flex;
            flex-direction: column;
            background: #fff;
            border-radius: 8px;
            /* Assuming rounded corners */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .chart-card- {
            display: flex;
            flex-direction: column;
            background: #fff;
            border-radius: 8px;
            /* Assuming rounded corners */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        /* Chart containers expand to fill card space */
        .chart-container {
            flex: 1;
            min-height: 0;
            position: relative;
            width: 100%;
        }

        /* --- Specific Calendar Styles --- */
        .calendar-wrapper {
            background: #fff;
            border-radius: 4px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            /* REMOVED max-width: 800px; */
            width: 100%;
            /* Added */
            height: 100%;
            /* Added */
            display: flex;
            /* Added */
            flex-direction: column;
            /* Added */
            margin: 0;
            /* Changed from 0 auto */
            border: 1px solid #e0e0e0;
        }

        .calendar-header-styled {
            background-color: #545454;
            color: #fff;
            padding: 15px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .calendar-header-styled h3 {
            margin: 0;
            font-size: 1.2rem;
            font-weight: 600;
        }

        .cal-nav-btn {
            background: none;
            border: none;
            color: white;
            cursor: pointer;
            font-size: 1.2rem;
            display: flex;
            align-items: center;
            transition: opacity 0.2s;
        }

        .cal-nav-btn:disabled {
            opacity: 0.3;
            cursor: not-allowed;
        }

        .calendar-days-styled {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            padding: 15px 0;
            border-bottom: 1px solid #eee;
        }

        .calendar-days-styled span {
            text-align: center;
            color: #B88E2F;
            font-weight: 700;
            font-size: 0.8rem;
            text-transform: uppercase;
        }

        .calendar-grid-styled {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            flex: 1;
            /* Added: Fills vertical space */
            grid-auto-rows: 1fr;
            /* Added: Stretches rows to fill height evenly */
            overflow-y: auto;
        }

        .cal-cell {
            height: 90px;
            border-bottom: 1px solid #f0f0f0;
            border-right: 1px solid #f0f0f0;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: #444;
            font-weight: 500;
            transition: background 0.2s;
            position: relative;
        }

        .cal-cell:nth-child(7n) {
            border-right: none;
        }

        .cal-cell:nth-last-child(-n+7) {
            border-bottom: none;
        }

        .cal-cell:hover {
            background-color: #f9f9f9;
        }

        .cal-cell.other-month {
            color: #eee;
            cursor: default;
        }

        .cal-cell.disabled-date {
            color: #ccc;
            background-color: #fafafa;
            cursor: not-allowed;
        }

        /* --- DYNAMIC STATUS COLORS --- */
        .cal-cell.status-booked {
            background-color: #F7EC73;
            color: #333;
        }

        .cal-cell.status-inhouse {
            background-color: #D3C855;
            color: #fff;
        }

        .cal-cell.status-full {
            background-color: #FE8578;
            color: #fff;
        }


        /* --- NEW MODAL STYLES (Paste this into your <style> tag) --- */

        /* The row container */
        .room-status-row {
            display: flex;
            align-items: center;
            background-color: #FAFAFA;
            /* Very light grey background for the whole strip */
            border-radius: 8px;
            margin-bottom: 12px;
            overflow: hidden;
            /* Ensures the box stays inside rounded corners */
        }

        /* The colored square with the number */
        .room-number-box {
            width: 70px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Montserrat', sans-serif;
            font-weight: 600;
            font-size: 1.1rem;
            color: #fff;
            /* Default text color */
            flex-shrink: 0;
        }

        /* The text details on the right */
        .room-details-text {
            padding-left: 15px;
            font-family: 'Montserrat', sans-serif;
            font-size: 0.9rem;
            color: #000;
            font-weight: 500;
        }

        /* Specific styling for bold dates */
        .room-details-text b {
            font-weight: 700;
        }

        /* --- COLOR VARIANTS --- */

        /* 1. OCCUPIED (In House) - Darker Gold/Greenish */
        .box-occupied {
            background-color: #CDBD46;
        }

        /* 2. RESERVED (Future) - Lighter Yellow */
        .box-reserved {
            background-color: #F5E875;
            color: #fff;
            /* Or #333 if you want dark text on light yellow */
        }

        /* 3. AVAILABLE - Grey */
        .box-available {
            background-color: #D6D6D6;
            color: #333;
            /* Dark text for grey box */
        }


        /* Modal Room List Styling */
        .room-item {
            padding: 10px;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
        }

        .room-item.booked {
            background-color: #fff3cd;
        }

        .room-item .status-badge {
            font-size: 0.8rem;
            padding: 2px 6px;
            border-radius: 4px;
        }

        /* --- STYLES FOR DOUGHNUT CHART CARD --- */
        .progress-bar-bg {
            background-color: #f3f4f6;
            border-radius: 999px;
            height: 8px;
            width: 100%;
            overflow: hidden;
        }

        .progress-bar-fill {
            height: 100%;
            border-radius: 999px;
        }

        .fs-xxs {
            font-size: 0.75rem;
            color: #666;
            font-weight: 500;
        }

        .legend-dot {
            display: inline-block;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            margin-right: 5px;
        }

        .d-flex-between {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .progress-list {
            padding-top: 10px;
            flex-shrink: 0;
        }
    </style>
</head>

<body>
    <div class="dashboard-container">
        <nav class="sidebar" style="font-size:0.85rem;">
            <div class="sidebar-header">
                <div class="logo">
                    <div class="logo-icon">
                        <img src="../../IMG/4.png" alt="AMV Logo"
                            style="height: 64px; width: auto; display: block; margin: 0 auto;">
                    </div>
                    <span class="brand-text">AMV</span>
                </div>
            </div>
            <ul class="nav-menu">
                <li class="nav-item active" data-page="dashboard"><a href="#"
                        class="nav-link"><span>Dashboard</span></a></li>
                <li class="nav-item" data-page="calendar"><a href="#" class="nav-link"><span>Calendar</span></a></li>
                <li class="nav-item" data-page="guests"><a href="#" class="nav-link"><span>Guests</span></a></li>
                <li class="nav-item" data-page="bookings"><a href="#" class="nav-link"><span>Bookings</span></a></li>
                <li class="nav-item" data-page="food-ordered"><a href="#" class="nav-link"><span>Food Ordered</span></a>
                </li>
                <li class="nav-item" data-page="transactions"><a href="#" class="nav-link"><span>Transactions</span></a>
                </li>
                <li class="nav-item" data-page="settings"><a href="#" class="nav-link"><span>Settings</span></a></li>
            </ul>
            <div class="sidebar-footer">
                <a href="#" class="logout-btn" id="logoutBtn"><span>Logout</span></a>
            </div>
        </nav>

        <main class="main-content">
            <header class="top-header">
                <div class="header-left">
                    <h1 class="page-title ml-2 fs-md">Dashboard</h1>
                </div>
            </header>

            <div class="page-content">
                <div class="page active" id="dashboard">

                    <div class="stats-grid g-3">
                        <div class="stat-card d-flex">
                            <div class="stat-icon orders-icon">📦</div>
                            <div class="stat-content">
                                <h3 class="stat-number p-1 fs-md"><?php echo $totalBookings; ?></h3>
                                <p class="stat-label fs-xs">Total Bookings</p>
                            </div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-icon revenue-icon">💰</div>
                            <div class="stat-content">
                                <h3 class="stat-number p-1 fs-md">$<?php echo number_format($totalRevenue, 2); ?></h3>
                                <p class="stat-label fs-xs">Total Revenue</p>
                            </div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-icon users-icon">🧾</div>
                            <div class="stat-content">
                                <h3 class="stat-number p-1 fs-md"><?php echo $totalOrders; ?></h3>
                                <p class="stat-label fs-xs">Total Orders</p>
                            </div>
                        </div>
                    </div>

                    <div class="charts-grid charts-grid-dashboard">

                        <div
                            style="display: flex; flex-direction: column; gap: 1rem; flex: 0 1 320px; min-width: 300px;">

                            <div class="chart-card" style="flex: 1; padding: 20px; justify-content: center;">
                                <h3 class="chart-title fs-sm mb-2 text-center" style="text-align:center;">Monthly
                                    Bookings Breakdown</h3>

                                <div class="chart-container" style="flex: 1; position: relative; max-height: 250px;">
                                    <canvas id="pieBookings"></canvas>
                                </div>

                                <div class="d-flex justify-center g-3 mt-2">
                                    <div class="fs-xxs"><span class="legend-dot"
                                            style="background:#10B981"></span>Check-ins</div>
                                    <div class="fs-xxs"><span class="legend-dot"
                                            style="background:#F59E0B"></span>No-show</div>
                                    <div class="fs-xxs"><span class="legend-dot"
                                            style="background:#EF4444"></span>Cancelled</div>
                                </div>
                            </div>

                            <div class="chart-card-" style="flex: 0 0 auto; padding: 20px;">
                                <div class="progress-list">
                                    <div class="mb-2">
                                        <div class="d-flex-between fs-xxs mb-1">
                                            <span>Check-ins</span><span><?php echo $pctConfirmed; ?>%</span>
                                        </div>
                                        <div class="progress-bar-bg">
                                            <div class="progress-bar-fill"
                                                style="width: <?php echo $pctConfirmed; ?>%; background: #10B981;">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-2">
                                        <div class="d-flex-between fs-xxs mb-1">
                                            <span>No-show</span><span><?php echo $pctPending; ?>%</span>
                                        </div>
                                        <div class="progress-bar-bg">
                                            <div class="progress-bar-fill"
                                                style="width: <?php echo $pctPending; ?>%; background: #F59E0B;"></div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="d-flex-between fs-xxs mb-1">
                                            <span>Cancelled</span><span><?php echo $pctCancelled; ?>%</span>
                                        </div>
                                        <div class="progress-bar-bg">
                                            <div class="progress-bar-fill"
                                                style="width: <?php echo $pctCancelled; ?>%; background: #EF4444;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="chart-card"
                            style="flex: 1 1 600px; min-width: 400px; display: flex; flex-direction: column;">
                            <div
                                style="display:flex;align-items:center;justify-content:space-between; padding: 20px 20px 10px 20px;">
                                <button class="cal-btn" id="barPrevBtn" title="Previous months">◀</button>
                                <h3 class="chart-title" id="barMonthLabel" style="margin:0;">Jan - Mar</h3>
                                <button class="cal-btn" id="barNextBtn" title="Next months">▶</button>
                            </div>

                            <div class="chart-container"
                                style="flex: 1; padding: 0 20px 20px 20px; position: relative; min-height: 0;">
                                <canvas id="barMonthly"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="page" id="calendar" style="overflow-y: auto;">
                    <div class="calendar-wrapper">
                        <div class="calendar-header-styled">
                            <h3 id="currentMonthYear">Month YYYY</h3>
                            <div class="d-flex g-2">
                                <button class="cal-nav-btn" id="prevMonthBtn">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="15 18 9 12 15 6"></polyline>
                                    </svg>
                                </button>
                                <button class="cal-nav-btn" id="nextMonthBtn">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="9 18 15 12 9 6"></polyline>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="calendar-days-styled">
                            <span>Sun</span><span>Mon</span><span>Tue</span><span>Wed</span><span>Thu</span><span>Fri</span><span>Sat</span>
                        </div>
                        <div class="calendar-grid-styled" id="calendarRealtimeGrid"></div>
                    </div>

                    <div class="modal" id="calendarModal">
                        <div class="modal-content-calendar">
                            <div class="d-flex justify-end pr-3 pt-2">
                                <button class="modal-close" id="closeCalendarModal">✕</button>
                            </div>
                            <div class="modal-header px-4 pb-4">
                                <h3 class="fs-md" id="calendarModalTitle">Room Status</h3>
                            </div>
                            <div class="modal-body px-5" id="calendarModalBody"></div>
                        </div>
                    </div>
                </div>

                <div class="page" id="guests" style="overflow-y: auto;">
                    <h2 class="p-3">Guests Page</h2>
                </div>
                <div class="page" id="bookings" style="overflow-y: auto;">
                    <h2 class="p-3">Bookings Page</h2>
                </div>
                <div class="page" id="food-ordered" style="overflow-y: auto;">
                    <h2 class="p-3">Food Ordered Page</h2>
                </div>
                <div class="page" id="transactions" style="overflow-y: auto;">
                    <h2 class="p-3">Transactions Page</h2>
                </div>
                <div class="page" id="settings" style="overflow-y: auto;">
                    <h2 class="p-3">Settings Page</h2>
                </div>
            </div>
        </main>
    </div>

    <div id="logoutModal" class="modal">
        <div class="modal-content py-3">
            <button class="modal-close-x" id="closeLogoutModal">✕</button>
            <h2>Confirm Logout</h2>
            <div class="modal-buttons">
                <button id="confirmLogout">Yes, Logout</button>
                <button id="cancelLogout">Cancel</button>
            </div>
        </div>
    </div>

    <script src="../SCRIPT/dashboard-script.js"></script>

    <script>
        // --- 1. CHARTS RENDERING ---
        const pieCtx = document.getElementById('pieBookings').getContext('2d');
        const pieDataRaw = <?php echo $js_pieData; ?>;

        new Chart(pieCtx, {
            type: 'doughnut',
            data: {
                labels: ['Check-ins', 'No-show', 'Cancelled'],
                datasets: [{
                    data: pieDataRaw,
                    backgroundColor: ['#10B981', '#F59E0B', '#EF4444'],
                    hoverBackgroundColor: ['#059669', '#D97706', '#DC2626'],
                    borderWidth: 0,
                    cutout: '75%',
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false, // Critical for fill
                layout: { padding: 20 }, // Manual adjustment for size if needed
                plugins: {
                    legend: { display: false },
                    tooltip: { enabled: true }
                }
            }
        });

        // ✅ UPDATED BAR CHART CONFIG ✅
        const barCtx = document.getElementById('barMonthly').getContext('2d');
        const barDataRaw = <?php echo $js_barData; ?>;
        new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Revenue ($)',
                    data: barDataRaw,
                    backgroundColor: '#B88E2F'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false, // Critical for filling height
                plugins: {
                    legend: { display: false }
                }
            }
        });

        // --- 2. LOGOUT MODAL ---
        document.getElementById('logoutBtn').onclick = (e) => { e.preventDefault(); document.getElementById('logoutModal').style.display = 'block'; };
        document.getElementById('cancelLogout').onclick = () => document.getElementById('logoutModal').style.display = 'none';
        document.getElementById('closeLogoutModal').onclick = () => document.getElementById('logoutModal').style.display = 'none';
        document.getElementById('confirmLogout').onclick = () => window.location.href = 'logout.php';


        // --- 3. CALENDAR LOGIC ---
        const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        let viewDate = new Date();
        const bookingsDB = <?php echo $js_calendarData; ?>;
        const totalRooms = 7;
        const allRoomIds = ['101', '102', '103', '104', '105', '201', '202'];

        function renderRealtimeCalendar() {
            const today = new Date();
            today.setHours(0, 0, 0, 0);

            const year = viewDate.getFullYear();
            const month = viewDate.getMonth();

            const isCurrentRealtimeMonth = (year === today.getFullYear() && month === today.getMonth());
            const isFutureMonth = (year > today.getFullYear()) || (year === today.getFullYear() && month > today.getMonth());
            document.getElementById('prevMonthBtn').disabled = (!isFutureMonth && isCurrentRealtimeMonth);

            document.getElementById('currentMonthYear').innerText = `${monthNames[month]} ${year}`;

            const firstDay = new Date(year, month, 1).getDay();
            const daysInMonth = new Date(year, month + 1, 0).getDate();
            const grid = document.getElementById('calendarRealtimeGrid');
            grid.innerHTML = "";

            for (let i = 0; i < firstDay; i++) {
                const cell = document.createElement('div');
                cell.className = 'cal-cell other-month';
                grid.appendChild(cell);
            }

            for (let i = 1; i <= daysInMonth; i++) {
                const cell = document.createElement('div');
                cell.className = 'cal-cell';
                cell.innerText = i;

                const d = new Date(year, month, i);
                const offset = d.getTimezoneOffset();
                const dStr = new Date(d.getTime() - (offset * 60 * 1000)).toISOString().split('T')[0];

                let isPastDate = false;
                if (isCurrentRealtimeMonth && i < today.getDate()) isPastDate = true;
                if (!isCurrentRealtimeMonth && !isFutureMonth) isPastDate = true;

                if (isPastDate) {
                    cell.classList.add('disabled-date');
                } else {
                    const dayData = bookingsDB[dStr] || [];
                    const bookedCount = dayData.length;

                    let hasBooked = false;
                    let hasInHouse = false;

                    dayData.forEach(b => {
                        if (b.type === 'in_house') hasInHouse = true;
                        if (b.type === 'future') hasBooked = true;
                    });

                    if (bookedCount >= totalRooms) {
                        cell.classList.add('status-full');
                    } else if (hasInHouse) {
                        cell.classList.add('status-inhouse');
                    } else if (hasBooked) {
                        cell.classList.add('status-booked');
                    }

                    cell.onclick = function () {
                        openRoomModal(dStr, dayData);
                    };
                }
                grid.appendChild(cell);
            }
        }

        // Helper function to format date like "Tue 29 April"
        function formatModalDate(dateStr) {
            const options = { weekday: 'short', day: 'numeric', month: 'long' };
            const d = new Date(dateStr);
            return d.toLocaleDateString('en-GB', options).replace(',', ''); 
        }

        function openRoomModal(dateStr, dayBookings) {
            // 1. Format Title: "May 6 - Rooms"
            const dateObj = new Date(dateStr);
            const titleDate = dateObj.toLocaleDateString('en-US', { month: 'long', day: 'numeric' });
            document.getElementById('calendarModalTitle').innerText = `${titleDate} - Rooms`;

            const body = document.getElementById('calendarModalBody');
            body.innerHTML = '';

            // 2. Loop through all rooms
            allRoomIds.forEach(roomId => {
                const booking = dayBookings.find(b => b.room_id == roomId || b.room_name.includes(roomId));
                
                // Create the row container
                const row = document.createElement('div');
                row.className = 'room-status-row';

                let numberBoxClass = '';
                let statusHtml = '';

                if (booking) {
                    const checkInFormatted = formatModalDate(booking.check_in);
                    const checkOutFormatted = formatModalDate(booking.check_out);

                    if (booking.type === 'in_house') {
                        // CASE: Occupied
                        numberBoxClass = 'box-occupied';
                        statusHtml = `Occupied until <b>${checkOutFormatted}</b>`;
                    } else {
                        // CASE: Reserved
                        numberBoxClass = 'box-reserved';
                        statusHtml = `Reserved from <b>${checkInFormatted}</b> to <b>${checkOutFormatted}</b>`;
                    }
                } else {
                    // CASE: Available
                    numberBoxClass = 'box-available';
                    statusHtml = `Available`;
                }

                // Inject HTML matching the screenshot design
                row.innerHTML = `
                    <div class="room-number-box ${numberBoxClass}">
                        ${roomId}
                    </div>
                    <div class="room-details-text">
                        ${statusHtml}
                    </div>
                `;

                body.appendChild(row);
            });

            document.getElementById('calendarModal').style.display = 'block';
        }

        document.getElementById('prevMonthBtn').addEventListener('click', () => {
            viewDate.setMonth(viewDate.getMonth() - 1);
            renderRealtimeCalendar();
        });

        document.getElementById('nextMonthBtn').addEventListener('click', () => {
            viewDate.setMonth(viewDate.getMonth() + 1);
            renderRealtimeCalendar();
        });

        document.getElementById('closeCalendarModal').onclick = () => document.getElementById('calendarModal').style.display = 'none';

        renderRealtimeCalendar();
    </script>
</body>

</html>