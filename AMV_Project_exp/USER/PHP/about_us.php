<?php
session_start();

// Check if the user is logged in (optional, remove if public page)
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}
require '../DB-CONNECTIONS/db_connect_2.php';
$user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - AMV Hotel</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="../STYLE/home_page.css">
    <link rel="stylesheet" href="../STYLE/utilities.css">
    <style>
        /* Reuse Header Styles from Home */
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #fff;
            margin: 0;
            color: #333;
        }

        /* --- HEADER & NAV --- */
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
            color: #333;
        }

        .logo-text span:last-child {
            color: #333;
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

        .icon-circle:hover {
            background: #9e8236;
            color: #fff;
            border-color: #9e8236;
        }

        /* --- HERO SECTION --- */
        .about-hero {
             /* margin-top: 80px;  */
            /* Offset for fixed header */
            background-image: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('../../IMG/food_7.jpg');
            /* Reuse existing image */
            background-size: cover;
            background-position: center;
            height: 300px;
            display: grid;
            align-items: center;
            justify-content: center;
            text-align: center;
            /* color: white; */
            padding-top: 120px;
            /* Space for fixed header */
            padding-bottom: 60px;
            text-align: center;
            background-color: #fcfcfc;
            border-bottom: 1px solid #eee;
        }

        .about-hero h1 {
            font-size: 3rem;
            color: #fff;
            /* Gold/Bronze */
            text-transform: uppercase;
            letter-spacing: 3px;
            font-weight: 700;
            margin: 0;
        }

        .breadcrumb {
            margin-top: 10px;
            font-size: 0.9rem;
            color: #888;
        }

        /* --- MAIN CONTENT GRID (Who We Are + Facilities) --- */
        .about-grid-section {
            padding: 80px 7%;
            display: grid;
            grid-template-columns: 1.2fr 0.8fr;
            /* Left column slightly wider */
            gap: 60px;
        }

        /* LEFT COLUMN */
        .about-text-content h2 {
            font-size: 2.2rem;
            color: #333;
            margin-bottom: 30px;
            font-weight: 400;
        }

        .about-text-content p {
            line-height: 1.8;
            color: #666;
            margin-bottom: 20px;
            font-size: 1rem;
            text-align: justify;
        }

        /* Award Badges Row */
        .awards-row {
            display: flex;
            gap: 20px;
            margin-top: 40px;
            flex-wrap: wrap;
        }

        .award-badge {
            width: 100px;
            height: 100px;
            background-color: #f9f9f9;
            border: 1px solid #eee;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            font-size: 10px;
            color: #9e8236;
            font-weight: bold;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .award-badge i {
            font-size: 24px;
            margin-bottom: 5px;
            display: block;
            color: #9e8236;
        }

        /* RIGHT COLUMN (Facilities List) */
        .facilities-col h3 {
            font-size: 1.5rem;
            color: #9e8236;
            margin-bottom: 25px;
            font-weight: 600;
            border-bottom: 2px solid #eee;
            padding-bottom: 10px;
            display: inline-block;
        }

        .facilities-list {
            list-style: none;
            padding: 0;
            margin: 0 0 40px 0;
        }

        .facilities-list li {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            color: #555;
            font-size: 1rem;
        }

        .facilities-list li i {
            width: 30px;
            color: #9e8236;
            font-size: 1.1rem;
            margin-right: 10px;
        }

        /* --- SIGNATURE ELEMENTS (Alternating Layout) --- */
        .signature-section {
            background-color: #f9f9f9;
            padding: 80px 7%;
        }

        .section-center-title {
            text-align: center;
            font-size: 2.5rem;
            color: #333;
            margin-bottom: 60px;
            font-weight: 400;
        }

        .sig-row {
            display: flex;
            align-items: center;
            gap: 50px;
            margin-bottom: 80px;
        }

        .sig-row:nth-child(even) {
            flex-direction: row-reverse;
        }

        .sig-img {
            flex: 1;
            height: 400px;
            overflow: hidden;
            border-radius: 4px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .sig-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s;
        }

        .sig-img:hover img {
            transform: scale(1.05);
        }

        .sig-text {
            flex: 1;
        }

        .sig-text h3 {
            font-size: 1.8rem;
            color: #9e8236;
            margin-bottom: 20px;
        }

        .sig-text p {
            line-height: 1.8;
            color: #666;
        }

        /* --- LOCATION / CONTACT --- */
        .location-section {
            padding: 80px 7%;
            display: flex;
            flex-wrap: wrap;
            gap: 40px;
        }

        .contact-details {
            flex: 1;
            min-width: 300px;
        }

        .contact-details h2 {
            font-size: 2.5rem;
            margin-bottom: 30px;
            color: #333;
        }

        .contact-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 25px;
        }

        .contact-item i {
            font-size: 1.5rem;
            color: #9e8236;
            margin-right: 20px;
            margin-top: 5px;
        }

        .contact-item div h4 {
            margin: 0 0 5px 0;
            font-size: 1.1rem;
        }

        .contact-item div p {
            margin: 0;
            color: #666;
            line-height: 1.6;
        }

        .map-container {
            flex: 1;
            min-width: 300px;
            height: 400px;
            background: #eee;
            border-radius: 8px;
            overflow: hidden;
        }

        /* Ensure iframe fits container via CSS since attributes were removed */
        .map-container iframe {
            width: 100%;
            height: 100%;
            border: 0;
        }

        /* RESPONSIVE */
        @media (max-width: 992px) {
            .about-grid-section {
                grid-template-columns: 1fr;
            }

            .sig-row,
            .sig-row:nth-child(even) {
                flex-direction: column;
            }

            .sig-img {
                width: 100%;
                height: 300px;
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
            <a href="testing.php">Home</a>
            <a href="#">Rooms</a>
            <a href="#">Dining</a>
            <div class="nav-icons">
                <div class="icon-circle"><i class="fa-solid fa-user"></i></div>
            </div>
        </nav>
    </header>

    <section class="about-hero">
        <h1>About Us</h1>
        <div class="breadcrumb">Home > About Us</div>
    </section>

    <section class="about-grid-section">
        <div class="about-text-content">
            <h2>Who We Are</h2>
            <p>
                AMV Hotel has received a prestigious nomination for Best Urban Hotel in 2024 by Asia Spa awards,
                a regional platform that credits properties that push the envelope and evolve this increasingly
                sophisticated industry. It is also known for its uncompromised independence, transparency, and
                objectivity.
            </p>
            <p>
                AMV Hotel is a property of many firsts — It is the first 5-star hotel in the Poblacion district of
                Mamburao
                and houses the first Onsen Spa in the Philippines, also the largest urban spa property in the country.
                It is exceptionally located with close proximity to malls and a mere 800m away from the Makati CBD.
            </p>

            <div class="awards-row">
                <div class="award-badge">
                    <div>
                        <i class="fa-solid fa-shield-halved"></i>
                        Safety Seal<br>Certified
                    </div>
                </div>
                <div class="award-badge">
                    <div>
                        <i class="fa-solid fa-trophy"></i>
                        Travelers'<br>Choice
                    </div>
                </div>
                <div class="award-badge">
                    <div>
                        <i class="fa-solid fa-spa"></i>
                        AsiaSpa<br>Awards
                    </div>
                </div>
                <div class="award-badge">
                    <div>
                        <i class="fa-solid fa-certificate"></i>
                        Great Place<br>To Work
                    </div>
                </div>
            </div>
        </div>

        <div class="facilities-col">
            <h3>Hotel Facilities</h3>
            <ul class="facilities-list">
                <li><i class="fa-solid fa-spa"></i> AMV Onsen Spa</li>
                <li><i class="fa-solid fa-water"></i> Acrylic-bottom Infinity Pool</li>
                <li><i class="fa-solid fa-hot-tub-person"></i> Wellness Suites (Onsen, Steam, Sauna)</li>
                <li><i class="fa-solid fa-car"></i> Car Parking</li>
                <li><i class="fa-solid fa-dumbbell"></i> Fitness Centre</li>
                <li><i class="fa-solid fa-users"></i> Conference Facilities</li>
            </ul>

            <h3>Room Facilities</h3>
            <ul class="facilities-list">
                <li><i class="fa-solid fa-shirt"></i> Laundry Facilities in Suite Rooms</li>
                <li><i class="fa-solid fa-mug-hot"></i> Tea & Coffee Making Facilities</li>
                <li><i class="fa-solid fa-utensils"></i> Full Kitchen in Suite Rooms</li>
            </ul>
        </div>
    </section>

    <section class="signature-section">
        <h2 class="section-center-title">Signature Elements & Facilities</h2>

        <div class="sig-row">
            <div class="sig-img">
                <img src="../../IMG/room_1.jpg" alt="Infinity Pool">
            </div>
            <div class="sig-text">
                <h3>Acrylic-Bottomed Infinity Pool</h3>
                <p>
                    Swimming is an elevated and sensorial experience at AMV Hotel. The infinity pool is an iconic
                    element
                    of the property. It can be seen upon entering the lobby as one looks up because it is
                    acrylic-bottomed,
                    hence serving as an interactive medium between guests who are swimming and guests who are just about
                    to enter.
                </p>
            </div>
        </div>

        <div class="sig-row">
            <div class="sig-img">
                <img src="../../IMG/food_7.jpg" alt="Dining">
            </div>
            <div class="sig-text">
                <h3>World-Class Dining</h3>
                <p>
                    Experience a culinary journey like no other. Our signature restaurants offer a fusion of local
                    Filipino
                    flavors and international cuisine, prepared by award-winning chefs. Whether it's a casual breakfast
                    or a romantic dinner, the ambiance and taste will leave a lasting impression.
                </p>
            </div>
        </div>
    </section>

    <section class="location-section">
        <div class="contact-details">
            <h2>How To Get There</h2>

            <div class="contact-item">
                <i class="fa-solid fa-location-dot"></i>
                <div>
                    <h4>Address</h4>
                    <p>Mamburao, Occidental Mindoro, Philippines</p>
                </div>
            </div>

            <div class="contact-item">
                <i class="fa-solid fa-phone"></i>
                <div>
                    <h4>Phone</h4>
                    <p>+6321 7755 7888</p>
                </div>
            </div>

            <div class="contact-item">
                <i class="fa-solid fa-envelope"></i>
                <div>
                    <h4>Email</h4>
                    <p>info@amvhotel.com / reservations@amvhotel.com</p>
                </div>
            </div>
        </div>

        <<div class="map-container">
            <iframe width="100%" height="100%" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"
                src="https://maps.google.com/maps?q=AMV+Hotel,+Events+Place+%26+Restaurant,+Mamburao,+Occidental+Mindoro&t=&z=15&ie=UTF8&iwloc=&output=embed">
            </iframe>
            </div>
    </section>

    <footer>
        <div style="background:#333; color:#fff; padding:30px; text-align:center;">
            <p>© 2025 AMV Hotel. All rights reserved.</p>
        </div>
    </footer>

</body>

</html>