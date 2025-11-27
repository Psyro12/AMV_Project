<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}
$user = $_SESSION['user'];
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
</head>

<body>
    <div class="dashboard-container">
        <!-- Sidebar Navigation -->
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
                <li class="nav-item active" data-page="dashboard">
                    <a href="#" class="nav-link">
                        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                            <polyline points="9,22 9,12 15,12 15,22" />
                        </svg>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item" data-page="calendar">
                    <a href="#" class="nav-link">
                        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                            <line x1="16" y1="2" x2="16" y2="6" />
                            <line x1="8" y1="2" x2="8" y2="6" />
                            <line x1="3" y1="10" x2="21" y2="10" />
                        </svg>
                        <span>Calendar</span>
                    </a>
                </li>
                <li class="nav-item" data-page="guests">
                    <a href="#" class="nav-link">
                        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                            <circle cx="9" cy="7" r="4" />
                        </svg>
                        <span>Guests</span>
                    </a>
                </li>
                <li class="nav-item" data-page="bookings">
                    <a href="#" class="nav-link">
                        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20" />
                            <path d="M20 22H6.5A2.5 2.5 0 0 1 4 19.5V5a2 2 0 0 1 2-2h10l6 6v10a3 3 0 0 1-3 3z" />
                        </svg>
                        <span>Bookings</span>
                    </a>
                </li>

                <!-- ✅ New Food Ordered Nav -->
                <li class="nav-item" data-page="food-ordered">
                    <a href="#" class="nav-link">
                        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path d="M4 3h16v2H4z" />
                            <path d="M6 7h12v13H6z" />
                            <path d="M9 7V5a3 3 0 0 1 6 0v2" />
                        </svg>
                        <span>Food Ordered</span>
                    </a>
                </li>
                <!-- ✅ End of new nav -->

                <li class="nav-item" data-page="transactions">
                    <a href="#" class="nav-link">
                        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <rect x="2" y="5" width="20" height="14" rx="2" ry="2" />
                            <line x1="2" y1="10" x2="22" y2="10" />
                        </svg>
                        <span>Transactions</span>
                    </a>
                </li>
                <li class="nav-item" data-page="settings">
                    <a href="#" class="nav-link">
                        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <circle cx="12" cy="12" r="3" />
                            <path
                                d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z" />
                        </svg>
                        <span>Settings</span>
                    </a>
                </li>
            </ul>
            <div class="sidebar-footer">
                <a href="#" class="logout-btn" id="logoutBtn">
                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                        <polyline points="16,17 21,12 16,7" />
                        <line x1="21" y1="12" x2="9" y2="12" />
                    </svg>
                    <span>Logout</span>
                </a>
            </div>
        </nav>

        <!-- Main Content Area -->
        <main class="main-content">
            <!-- Top Header -->
            <header class="top-header">
                <div class="header-left">
                    <h1 class="page-title ml-2 fs-md">Dashboard</h1>
                </div>
                <div class="header-right">
                    <div class="top-icons">
                        <button class="icon-btn" id="messagesBtn" title="Messages">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                            </svg>
                            <span class="badge" id="messagesBadge">3</span>
                        </button>
                        <button class="icon-btn" id="notificationsBtn" title="Notifications">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path d="M18 8a6 6 0 1 0-12 0c0 7-3 9-3 9h18s-3-2-3-9" />
                                <path d="M13.73 21a2 2 0 0 1-3.46 0" />
                            </svg>
                            <span class="badge" id="notificationsBadge">5</span>
                        </button>
                    </div>

                    <!-- Message Modal Dropdown -->
                    <div class="icon-modal" id="messagesModal">
                        <div class="modal-content-icon p-3">
                            <div class="modal-header">
                                <h4>Messages</h4>
                                <button class="modal-close" id="closeMessagesModal">✕</button>
                            </div>
                            <div class="px-2">
                                <!-- Card for each message -->
                                <div class="header-card" id="message1">
                                    <div class="header-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                                        </svg>
                                    </div>
                                    <div class="header-details" onclick="toggleExpand('message1')">
                                        <div class="header-name">John Doe</div>
                                        <div class="header-text">Can I check in
                                            early?</div>
                                        <div class="expanded-message">Sure, you can check in early! Let us know your
                                            expected arrival time, and we will prepare the room.</div>
                                    </div>
                                    <div class="header-time">2m ago</div>
                                </div>
                                <div class="header-card" id="message2">
                                    <div class="header-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                                        </svg>
                                    </div>
                                    <div class="header-details" onclick="toggleExpand('message2')">
                                        <div class="header-name">Jane Smith</div>
                                        <div class="header-text">Please confirm my
                                            booking.</div>
                                        <div class="expanded-message">Your booking has been confirmed. We look forward
                                            to your stay!</div>
                                    </div>
                                    <div class="header-time">10m ago</div>
                                </div>
                                <div class="header-card" id="message3">
                                    <div class="header-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                                        </svg>
                                    </div>
                                    <div class="header-details" onclick="toggleExpand('message3')">
                                        <div class="header-name">Guest</div>
                                        <div class="header-text">Thank you for the
                                            great service!</div>
                                        <div class="expanded-message">We're thrilled that you enjoyed your stay. We hope
                                            to host you again soon!</div>
                                    </div>
                                    <div class="header-time">1h ago</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Notification Modal Dropdown -->
                    <div class="icon-modal" id="notificationsModal">
                        <div class="modal-content-icon p-3">
                            <div class="modal-header">
                                <h4>Notifications</h4>
                                <button class="modal-close" id="closeNotificationsModal">✕</button>
                            </div>
                            <div class="px-2">
                                <!-- Card for each notification -->
                                <div class="header-card">
                                    <div class="header-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                            <path d="M18 8a6 6 0 1 0-12 0c0 7-3 9-3 9h18s-3-2-3-9" />
                                            <path d="M13.73 21a2 2 0 0 1-3.46 0" />
                                        </svg>
                                    </div>
                                    <div class="header-details g-1">
                                        <div class="header-name">Check-in</div>
                                        <div class="header-text">Guest John Doe checked in.</div>
                                    </div>
                                    <div class="header-time">5m ago</div>
                                </div>
                                <div class="header-card">
                                    <div class="header-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                            <path d="M18 8a6 6 0 1 0-12 0c0 7-3 9-3 9h18s-3-2-3-9" />
                                            <path d="M13.73 21a2 2 0 0 1-3.46 0" />
                                        </svg>
                                    </div>
                                    <div class="header-details g-1">
                                        <div class="header-name">Payment</div>
                                        <div class="header-text">Payment received.</div>
                                    </div>
                                    <div class="header-time">20m ago</div>
                                </div>
                                <div class="header-card">
                                    <div class="header-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                            <path d="M18 8a6 6 0 1 0-12 0c0 7-3 9-3 9h18s-3-2-3-9" />
                                            <path d="M13.73 21a2 2 0 0 1-3.46 0" />
                                        </svg>
                                    </div>
                                    <div class="header-details g-1">
                                        <div class="header-name">New booking</div>
                                        <div class="header-text">Room 301, June 21-23.</div>
                                    </div>
                                    <div class="header-time">1h ago</div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </header>

            <!-- Page Content Container -->
            <div class="page-content">
                <!-- Dashboard Page (Default) -->
                <div class="page active" id="dashboard">
                    <div class="stats-grid g-3 mb-3">
                        <div class="stat-card d-flex">
                            <div class="stat-icon orders-icon">📦</div>
                            <div class="stat-content">
                                <h3 class="stat-number p-1 fs-md" id="totalBookings">00</h3>
                                <p class="stat-label fs-xs">Total Bookings</p>
                                <!-- <span class="stat-change positive">+4.1%</span> -->
                            </div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-icon revenue-icon">💰</div>
                            <div class="stat-content">
                                <h3 class="stat-number p-1 fs-md" id="totalRevenue">00</h3>
                                <p class="stat-label fs-xs">Total Revenue</p>
                                <!-- <span class="stat-change positive">+7.9%</span> -->
                            </div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-icon users-icon">🧾</div>
                            <div class="stat-content">
                                <h3 class="stat-number p-1 fs-md" id="totalOrders">00</h3>
                                <p class="stat-labe fs-xs">Total Orders</p>
                                <!-- <span class="stat-change negative">-1.2%</span> -->
                            </div>
                        </div>
                    </div>

                    <!-- Donut Chart -->
                    <div class="charts-grid g-3 charts-grid-dashboard" style="display: flex; gap: 1rem;">
                        <div class="chart-card" style="flex: 0 1 300px; max-width: 320px; min-width: 220px;">
                            <h3 class="chart-title fs-sm">Monthly Bookings Breakdown</h3>
                            <div class="chart-container p-3">
                                <canvas id="pieBookings"></canvas>
                                <!-- <div id="centerText" class="center-text">0</div> Placeholder for animated text -->
                            </div>
                            <div class="progress-legend">
                                <div class="progress-row">
                                    <span class="progress-label">Check-ins</span>
                                    <div class="progress-bar"><span class="progress-fill checkin" id="pbCheckin"
                                            style="width: 0%"></span></div>
                                    <span class="progress-value" id="pvCheckin">0%</span>
                                </div>
                                <div class="progress-row">
                                    <span class="progress-label">No-show</span>
                                    <div class="progress-bar"><span class="progress-fill noshow" id="pbNoShow"
                                            style="width: 0%"></span></div>
                                    <span class="progress-value" id="pvNoShow">0%</span>
                                </div>
                                <div class="progress-row">
                                    <span class="progress-label">Cancelled</span>
                                    <div class="progress-bar"><span class="progress-fill cancelled" id="pbCancelled"
                                            style="width: 0%"></span></div>
                                    <span class="progress-value" id="pvCancelled">0%</span>
                                </div>
                            </div>
                        </div>

                        <!-- Bar Graph -->
                        <div class="chart-card" style="flex: 1 1 600px; min-width: 400px; max-width: 100%;">
                            <div style="display:flex;align-items:center;justify-content:space-between;">
                                <button class="cal-btn" id="barPrevBtn" title="Previous months">◀</button>
                                <h3 class="chart-title" id="barMonthLabel" style="margin:0;">Jan - Mar</h3>
                                <button class="cal-btn" id="barNextBtn" title="Next months">▶</button>
                            </div>
                            <div class="chart-container">
                                <canvas id="barMonthly"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Calendar Page -->
                <div class="page" id="calendar">
                    <div class="calendar-wrapper">
                        <div class="calendar-header">
                            <button class="cal-btn" id="prevMonth">◀</button>
                            <h3 id="calendarTitle">Month YYYY</h3>
                            <button class="cal-btn" id="nextMonth">▶</button>
                        </div>
                        <div class="legend">
                            <span><i class="legend-box available"></i> Available</span>
                            <span><i class="legend-box reserved"></i> Reserved</span>
                            <span><i class="legend-box occupied"></i> Occupied</span>
                            <span><i class="legend-box full"></i> Fully Booked</span>
                        </div>
                        <div class="calendar-grid" id="calendarGrid"></div>

                        <!-- Calendar Modal -->
                        <div class="modal" id="calendarModal">
                            <div class="modal-content-calendar">
                                <div class="d-flex justify-end pr-3 pt-2">
                                    <button class="modal-close" id="closeCalendarModal">✕</button>
                                </div>
                                <div class="modal-header px-4 pb-4">
                                    <h3 class="fs-md" id="calendarModalTitle">Room Status for Date</h3>
                                </div>
                                <div class="modal-body px-5" id="calendarModalBody">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Guests Page -->
                <div class="page" id="guests">
                    <!-- <h2 class="page-heading">Guests</h2>
                    <p class="page-description">Browse all guests, booking details and history.</p> -->
                    <div class="users-content">
                        <div class="users-table">
                            <div class="table-header">
                                <h3 class="fs-md pl-2">Guests</h3>
                                <input type="search" class="setting-input fs-sm"
                                    style="padding: 0.5rem; border-radius: 5px; border: 1.5px solid #D9D9D9;"
                                    placeholder="Search guests...">
                            </div>
                            <div class="table-container">
                                <table class="fs-xs" id="guestsTable">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Last Booking</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                            data-guest='{"name":"John Doe","email":"john@example.com","phone":"+63 900 123 4567","history":["2024-06-02 Room 204 - Completed","2024-02-11 Room 105 - Cancelled"]}'>
                                            <td>John Doe</td>
                                            <td>john@example.com</td>
                                            <td>2024-06-02</td>
                                            <td><span class="status active">Active</span></td>
                                            <td><button class="action-btn edit view-guest">View</button></td>
                                        </tr>
                                        <tr
                                            data-guest='{"name":"Jane Smith","email":"jane@example.com","phone":"+63 922 555 8990","history":["2024-05-19 Room 301 - Completed"]}'>
                                            <td>Jane Smith</td>
                                            <td>jane@example.com</td>
                                            <td>2024-05-19</td>
                                            <td><span class="status pending">Pending</span></td>
                                            <td><button class="action-btn edit view-guest">View</button></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal" id="guestModal">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h3 id="guestModalTitle">Guest Details</h3>
                                <button class="modal-close" data-close>✕</button>
                            </div>
                            <div class="modal-body" id="guestModalBody"></div>
                        </div>
                    </div>
                </div>
                <!-- Bookings Page -->
                <div class="page" id="bookings">
                    <!-- <h2 class="page-heading">Bookings</h2>
                    <p class="page-description">Incoming, active, and walk-in bookings. Add bookings directly.</p> -->
                    <div class="tabs">
                        <button class="tab-btn active" data-tab="incoming">Incoming</button>
                        <button class="tab-btn" data-tab="active">Active</button>
                        <button class="tab-btn" data-tab="walkin">Walk-in</button>
                        <button class="add-booking-btn" id="openAddBooking">+ Add Booking</button>
                    </div>

                    <!-- Add Booking Button -->
                    <!-- <button class="add-booking-btn" id="openAddBooking">+ Add Booking</button> -->

                    <!-- Modal for Room List -->
                    <div class="modal o-hidden" id="roomModal">
                        <div class="modal-content p-3 px-4 w-50 h-70">
                            <div class="">
                                <button class="modal-close-x" id="closeRoomModal">✕</button>
                                <h4>Select a Room</h4>
                            </div>
                            <div class="room-list py-2">
                                <!-- Room Buttons (201-207) -->
                                <button class="room-card w-full mb-1" data-room="201">Room 201</button>
                                <button class="room-card w-full mb-1" data-room="202">Room 202</button>
                                <button class="room-card w-full mb-1" data-room="203">Room 203</button>
                                <button class="room-card w-full mb-1" data-room="204">Room 204</button>
                                <button class="room-card w-full mb-1" data-room="205">Room 205</button>
                                <button class="room-card w-full mb-1" data-room="206">Room 206</button>
                                <button class="room-card w-full mb-1" data-room="207">Room 207</button>
                            </div>

                        </div>
                    </div>

                    <!-- Modal for Booking Form -->
                    <div class="modal o-hidden" id="bookingModal">
                        <div class="modal-content w-60 h-70">
                            <div class="d-grid place-items-end pr-3 pt-2">
                                <button class="modal-close" id="closeBookingModal">✕</button>
                            </div>
                            <div class="modal-header">
                                <h4>Booking Form for Room <span id="selectedRoom"></span></h4>
                            </div>
                            <form class="booking-form p-3 px-5">
                                <div class="d-flex g-2">
                                    <input type="text" id="firstname" class="p-3 pl-4" name="firstname"
                                        placeholder="Firstname" required />
                                    <input type="text" id="lastname" class="p-3 pl-4" name="lastname"
                                        placeholder="Lastname" required />
                                </div>

                                <input type="text" id="address" class="p-3 pl-4" name="address" placeholder="Address"
                                    required />

                                <div class="d-flex g-2">
                                    <input type="text" id="contact" class="p-3 pl-4" name="contact"
                                        placeholder="Contact Number" required />
                                    <input type="email" id="email" class="p-3 pl-4" name="email"
                                        placeholder="Email Address" required />
                                </div>

                                <div class="d-flex g-2">
                                    <!-- <label for="checkin">Check-in Date</label> -->
                                    <input type="date" class="p-3 pl-4" id="checkin" name="checkin" required />

                                    <!-- <label for="checkout">Check-out Date</label> -->
                                    <input type="date" class="p-3 pl-4" id="checkout" name="checkout" required />
                                </div>

                                <div class="d-grid grid-cols-3 g-2">

                                    <!-- <div class="d-flex g-2"> -->
                                    <!-- <label for="adult">Number of Adults</label> -->
                                    <select id="adult" class="pl-3" name="adult" aria-placeholder="Adult" required>
                                        <option value="" hidden>Adult</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                    </select>

                                    <!-- <label for="child">Number of Children</label> -->
                                    <select id="child" class="pl-3" name="child" required>
                                        <option value="" hidden>Child</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                    <!-- </div> -->

                                    <!-- <select id="child" name="child" required>
                                    <option value="" hidden>breakfast</option>
                                    <option value="1"></option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                </select>        -->
                                    <div class="d-grid grid-cols-2">
                                        <span>
                                            <input type="checkbox" class="w-1 h-1" name="breakfast" /> <span
                                                class="">With Breakfast</span>
                                        </span>

                                        <span>
                                            <input type="checkbox" class="w-1 h-1" name="extraBed" /> <span
                                                class="">With Extra Bed</span>
                                        </span>
                                    </div>
                                </div>


                                <div class="d-grid grid-cols-2 g-2">
                                    <select id="payment" name="payment" class="pl-3" required>
                                        <option value="gcash">Gcash</option>
                                        <option value="cash">Cash</option>
                                    </select>

                                    <button class="" type="submit">Add Booking</button>
                                </div>

                            </form>
                        </div>
                    </div>
                    <div class="tab-panels">
                        <div class="tab-panel active" id="incoming">
                            <table class="booking-table fs-xs">
                                <thead>
                                    <tr>
                                        <th>Booking #</th>
                                        <th>Date</th>
                                        <th>Room</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>A-4312</td>
                                        <td>Jun 20-21</td>
                                        <td>204</td>
                                        <td>Reserved</td>
                                    </tr>
                                    <tr>
                                        <td>A-4313</td>
                                        <td>Jun 21-23</td>
                                        <td>301</td>
                                        <td>Reserved</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-panel" id="active">
                            <table class="booking-table fs-xs">
                                <thead>
                                    <tr>
                                        <th>Booking #</th>
                                        <th>Date</th>
                                        <th>Room</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>A-4201</td>
                                        <td>Jun 17-19</td>
                                        <td>105</td>
                                        <td>Occupied</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-panel" id="walkin">
                            <table class="booking-table fs-xs">
                                <thead>
                                    <tr>
                                        <th>Booking #</th>
                                        <th>Date</th>
                                        <th>Room</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>W-120</td>
                                        <td>Jun 18-19</td>
                                        <td>102</td>
                                        <td>Occupied</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal" id="bookingModal">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h3>Add Booking</h3>
                                <button class="modal-close" data-close>✕</button>
                            </div>
                            <div class="modal-body">
                                <form id="addBookingForm" class="form form-grid">
                                    <label>
                                        Guest Name
                                        <input type="text" class="setting-input" required
                                            style="padding: 0.5rem; border-radius: 5px; border: 1.5px solid #D9D9D9; background: #f8fafc;">
                                    </label>
                                    <label>
                                        Room
                                        <select class="setting-input" required
                                            style="padding: 0.5rem; border-radius: 5px; border: 1.5px solid #D9D9D9; background: #f8fafc;">
                                            <option>101</option>
                                            <option>102</option>
                                            <option>204</option>
                                            <option>301</option>
                                        </select>
                                    </label>
                                    <label>
                                        Check-in
                                        <input type="date" class="setting-input" required
                                            style="padding: 0.5rem; border-radius: 5px; border: 1.5px solid #D9D9D9; background: #f8fafc;">
                                    </label>
                                    <label>
                                        Check-out
                                        <input type="date" class="setting-input" required
                                            style="padding: 0.5rem; border-radius: 5px; border: 1.5px solid #D9D9D9; background: #f8fafc;">
                                    </label>
                                    <label>
                                        Type
                                        <select class="setting-input" required
                                            style="padding: 0.5rem; border-radius: 5px; border: 1.5px solid #D9D9D9; background: #f8fafc;">
                                            <option>Incoming</option>
                                            <option>Active</option>
                                            <option>Walk-in</option>
                                        </select>
                                    </label>
                                    <div class="form-actions">
                                        <button type="submit" class="save-btn">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Food Ordered Page -->
                <div class="page" id="food-ordered">

                    <div class="users-content">
                        <div class="users-table">
                            <div class="table-header">
                                <h3 class="fs-md pl-2">Food Orders</h3>
                                <select id="statusFilter" class="setting-input fs-sm pl-5">
                                    <option value="all">All Orders</option>
                                    <option value="pending">Pending</option>
                                    <option value="completed">Completed</option>
                                </select>
                            </div>

                            <div class="table-container">
                                <table class="fs-xs" id="guestsTable">
                                    <thead>
                                        <tr>
                                            <th>Ref</th>
                                            <th>Name</th>
                                            <th>Item</th>
                                            <th>Amount</th>
                                            <th>Method</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>T-98311</td>
                                            <td>John Doe</td>
                                            <td>Burger</td>
                                            <td>$180.00</td>
                                            <td>Card</td>
                                            <td><span class="status completed">Completed</span></td>
                                            <td>2024-06-17</td>
                                        </tr>
                                        <tr>
                                            <td>T-98312</td>
                                            <td>Jane Smith</td>
                                            <td>Fries</td>
                                            <td>$240.00</td>
                                            <td>Cash</td>
                                            <td><span class="status pending">Pending</span></td>
                                            <td>2024-06-18</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Transactions Page -->
                <div class="page" id="transactions">

                    <div class="users-content">
                        <div class="users-table">
                            <div class="table-header">
                                <h3 class="fs-md pl-2">Transactions</h3>
                                <select id="statusFilter" class="setting-input fs-sm pl-5">
                                    <option value="all">All Transactions</option>
                                    <option value="pending">Pending</option>
                                    <option value="completed">Paid</option>
                                </select>
                            </div>

                            <div class="table-container">
                                <table class="fs-xs" id="guestsTable">
                                    <thead>
                                        <tr>
                                            <th>Ref</th>
                                            <th>Guest</th>
                                            <th>Amount</th>
                                            <th>Method</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>T-98311</td>
                                            <td>John Doe</td>
                                            <td>$180.00</td>
                                            <td>Card</td>
                                            <td><span class=" status active">Paid</span></td>
                                            <td>2024-06-17</td>
                                        </tr>
                                        <tr>
                                            <td>T-98312</td>
                                            <td>Jane Smith</td>
                                            <td>$240.00</td>
                                            <td>Cash</td>
                                            <td><span class="status pending">Pending</span></td>
                                            <td>2024-06-18</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Settings Page -->
                <div class="page" id="settings">
                    <div class="settings-content">
                        <div class="settings-section p-3">
                            <h3>Profile</h3>
                            <div class="setting-item">
                                <label>Admin Name</label>
                                <input type="text" value="<?php echo htmlspecialchars($user['name']); ?>"
                                    class="setting-input w-50"
                                    style="padding: 0.5rem; border-radius: 5px; border: 1.5px solid #D9D9D9; background: #f8fafc;">
                            </div>
                            <div class="setting-item">
                                <label>Admin Email</label>
                                <input type="text" value="<?php echo htmlspecialchars($user['email']); ?>"
                                    class="setting-input w-50"
                                    style="padding: 0.5rem; border-radius: 5px; border: 1.5px solid #D9D9D9; background: #f8fafc;">
                            </div>
                            <div class="setting-item">
                                <label>Change Password</label>
                                <input type="password" class="setting-input w-50" placeholder="New password"
                                    style="padding: 0.5rem; border-radius: 5px; border: 1.5px solid #D9D9D9; background: #f8fafc;">
                            </div>
                            <div class="d-flex justify-end mt-2">
                                <button class="save-btn px-6">Save Changes</button>
                            </div>
                        </div>
                        <div class="settings-section p-3">
                            <h3>Terms and Conditions</h3>
                            <textarea class="terms-box" rows="6"
                                style="padding: 0.5rem; border-radius: 5px; border: 1.5px solid #D9D9D9; background: #f8fafc;">Default hotel terms and conditions...</textarea>
                            <div class="d-flex justify-end settings-actions mt-2">
                                <button class="save-btn px-6">Save Changes</button>
                            </div>
                        </div>
                        <!-- <div class="settings-section">
                        <h3>Account</h3>
                        <div class="setting-item">
                            <label>Logout</label>
                            <a class="logout-btn" href="#" id="logoutBtn2">Logout</a>
                        </div>
                    </div> -->
                    </div>
                </div>
            </div>
    </div>
    </main>
    </div>
    <!-- Logout Modal -->
    <div id="logoutModal" class="modal">
        <div class="modal-content py-3">
            <button class="modal-close-x" id="closeLogoutModal">✕</button>
            <div class="modal-icon">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <path
                            d="M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z"
                            stroke="#323232" stroke-width="2"></path>
                        <path d="M12 8L12 13" stroke="#323232" stroke-width="2" stroke-linecap="round"></path>
                        <path d="M12 16V15.9888" stroke="#323232" stroke-width="2" stroke-linecap="round"></path>
                    </g>
                </svg>
            </div>
            <h2>Confirm Logout</h2>
            <p class="fs-sm">Are you sure you want to log out?</p>
            <div class="modal-buttons">
                <button id="confirmLogout">Yes, Logout</button>
                <button id="cancelLogout">Cancel</button>
            </div>
        </div>
    </div>
    <script src="../SCRIPT/dashboard-script.js"></script>
    <script>
        // Logout modal logic for both logout buttons
        function showLogoutModal(e) {
            e.preventDefault();
            document.getElementById('logoutModal').style.display = 'block';
        }
        document.getElementById('logoutBtn').onclick = showLogoutModal;
        var logoutBtn2 = document.getElementById('logoutBtn2');
        if (logoutBtn2) logoutBtn2.onclick = showLogoutModal;
        document.getElementById('cancelLogout').onclick = function () {
            document.getElementById('logoutModal').style.display = 'none';
        };
        document.getElementById('closeLogoutModal').onclick = function () {
            document.getElementById('logoutModal').style.display = 'none';
        };
        document.getElementById('confirmLogout').onclick = function () {
            window.location.href = 'logout.php';
        };
        window.onclick = function (event) {
            var modal = document.getElementById('logoutModal');
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        };
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
                document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
                btn.classList.add('active');
                document.getElementById(btn.getAttribute('data-tab')).classList.add('active');
            });
        });
    </script>
</body>

</html>