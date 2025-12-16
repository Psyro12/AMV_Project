<?php
session_start();

require_once '../DB-CONNECTIONS/db_connect.php';

// --- 2. PROCESS FORM SUBMISSION ---
$booking_reference = "";
$success = false;
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Get Data from POST
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 1; // Default to 1 if no user logged in (for testing)
    
    $checkin = $_POST['checkin'];
    $checkout = $_POST['checkout'];
    $total_price = $_POST['total_price'];
    $payment_method = $_POST['payment_method'];
    $selected_rooms = json_decode($_POST['selected_rooms'], true);

    // Guest Info
    $salutation = $_POST['salutation'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['contact_number'];
    $nationality = $_POST['nationality'];
    $gender = $_POST['gender'];
    $birthdate = $_POST['birthdate'];
    $address = $_POST['address'];
    $arrival_time = $_POST['arrival_time'];
    $special_requests = $_POST['requests'];
    $adults = $_POST['adults'];
    $children = $_POST['children'];

    // Generate Unique Reference (e.g., AMV-65A12B)
    $booking_reference = 'AMV-' . strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 6));

    // --- TRANSACTION START ---
    $conn->begin_transaction();

    try {
        // A. Insert into 'bookings' table
        $stmt1 = $conn->prepare("INSERT INTO bookings (user_id, check_in, check_out, total_price, payment_method, booking_reference, status) VALUES (?, ?, ?, ?, ?, ?, 'confirmed')");
        $stmt1->bind_param("issdss", $user_id, $checkin, $checkout, $total_price, $payment_method, $booking_reference);
        $stmt1->execute();
        $booking_id = $conn->insert_id; // Get the ID of the new booking
        $stmt1->close();

        // B. Insert into 'booking_guests' table
        $stmt2 = $conn->prepare("INSERT INTO booking_guests (booking_id, salutation, first_name, last_name, email, phone, nationality, gender, birthdate, address, arrival_time, special_requests, adults_count, children_count) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt2->bind_param("isssssssssssii", $booking_id, $salutation, $first_name, $last_name, $email, $phone, $nationality, $gender, $birthdate, $address, $arrival_time, $special_requests, $adults, $children);
        $stmt2->execute();
        $stmt2->close();

        // C. Insert into 'booking_rooms' table (Loop through selected rooms)
        if (!empty($selected_rooms)) {
            $stmt3 = $conn->prepare("INSERT INTO booking_rooms (booking_id, room_id, room_name, price_per_night) VALUES (?, ?, ?, ?)");
            foreach ($selected_rooms as $room) {
                $stmt3->bind_param("iisd", $booking_id, $room['id'], $room['name'], $room['price']);
                $stmt3->execute();
            }
            $stmt3->close();
        }

        // Commit Transaction
        $conn->commit();
        $success = true;

    } catch (Exception $e) {
        $conn->rollback();
        $error_message = "Error: " . $e->getMessage();
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation - AMV Hotel</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body { font-family: 'Montserrat', sans-serif; background-color: #f5f5f5; margin: 0; color: #333; }
        
        /* HEADER */
        header { position: fixed; top: 0; width: 100%; padding: 15px 5%; display: flex; justify-content: space-between; align-items: center; z-index: 1000; background-color: #fff; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05); }
        .logo-container { display: flex; align-items: center; gap: 10px; }
        .logo-text span { color: #333; font-weight: 700; display: block; line-height: 1; }
        .logo-text span:first-child { font-size: 20px; color: #9e8236; }
        .logo-text span:last-child { font-size: 12px; letter-spacing: 1px; }
        nav { display: flex; align-items: center; }
        nav a { color: #333; text-decoration: none; margin-right: 25px; text-transform: uppercase; font-size: 0.8rem; font-weight: 600; letter-spacing: 1px; transition: color 0.3s; }
        
        /* CONTAINER */
        .confirm-container {
            max-width: 800px;
            margin: 120px auto 60px;
            background: #fff;
            padding: 50px;
            border-radius: 8px;
            box-shadow: 0 5px 25px rgba(0,0,0,0.05);
            text-align: center;
        }

        .success-icon {
            font-size: 4rem;
            color: #4CAF50;
            margin-bottom: 20px;
        }

        .confirm-title {
            font-size: 2rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 10px;
        }

        .confirm-sub {
            color: #666;
            margin-bottom: 30px;
        }

        .ref-box {
            background-color: #f9f9f9;
            border: 2px dashed #9e8236;
            padding: 20px;
            display: inline-block;
            margin-bottom: 30px;
            border-radius: 4px;
        }

        .ref-label {
            font-size: 0.8rem;
            text-transform: uppercase;
            color: #888;
            margin-bottom: 5px;
            display: block;
        }

        .ref-number {
            font-size: 1.5rem;
            font-weight: 700;
            color: #9e8236;
            letter-spacing: 2px;
        }

        .details-grid {
            text-align: left;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
            padding: 20px;
            background: #fcfcfc;
            border-radius: 4px;
        }

        .detail-item strong { display: block; font-size: 0.8rem; color: #888; text-transform: uppercase; }
        .detail-item span { font-weight: 600; color: #333; }

        .btn-home {
            background-color: #333;
            color: #fff;
            padding: 15px 40px;
            text-decoration: none;
            font-weight: 700;
            text-transform: uppercase;
            border-radius: 4px;
            transition: 0.3s;
            display: inline-block;
        }
        .btn-home:hover { background-color: #555; }
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
            <a href="index.php">Home</a>
            <div class="icon-circle"><i class="fa-solid fa-user"></i></div>
        </nav>
    </header>

    <div class="confirm-container">
        <?php if ($success): ?>
            <div class="success-icon"><i class="fa-regular fa-circle-check"></i></div>
            <h1 class="confirm-title">Booking Confirmed!</h1>
            <p class="confirm-sub">Thank you for choosing AMV Hotel. Your reservation has been successfully saved.</p>

            <div class="ref-box">
                <span class="ref-label">Booking Reference</span>
                <span class="ref-number"><?php echo $booking_reference; ?></span>
            </div>

            <div class="details-grid">
                <div class="detail-item">
                    <strong>Guest Name</strong>
                    <span><?php echo $salutation . " " . $first_name . " " . $last_name; ?></span>
                </div>
                <div class="detail-item">
                    <strong>Total Amount</strong>
                    <span style="color:#9e8236;">$<?php echo number_format($total_price, 2); ?></span>
                </div>
                <div class="detail-item">
                    <strong>Check-in</strong>
                    <span><?php echo date('M d, Y', strtotime($checkin)); ?></span>
                </div>
                <div class="detail-item">
                    <strong>Check-out</strong>
                    <span><?php echo date('M d, Y', strtotime($checkout)); ?></span>
                </div>
                <div class="detail-item">
                    <strong>Payment Method</strong>
                    <span><?php echo $payment_method; ?></span>
                </div>
            </div>

            <a href="testing.php" class="btn-home">Back to Home</a>

        <?php else: ?>
            <div style="color:red; margin-bottom:20px;">
                <i class="fa-solid fa-circle-exclamation" style="font-size:3rem;"></i>
                <h2>Booking Failed</h2>
                <p>Sorry, something went wrong while processing your booking.</p>
                <p><?php echo $error_message; ?></p>
            </div>
            <a href="check_availability.php" class="btn-home">Try Again</a>
        <?php endif; ?>
    </div>

</body>
</html>