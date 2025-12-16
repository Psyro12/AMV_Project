<?php
session_start();
require '../DB-CONNECTIONS/db_connect_2.php'; 

// 1. Capture Data
$checkin = isset($_GET['checkin']) ? $_GET['checkin'] : '';
$checkout = isset($_GET['checkout']) ? $_GET['checkout'] : '';
$adults = isset($_GET['adults']) ? $_GET['adults'] : 1;
$children = isset($_GET['children']) ? $_GET['children'] : 0;

// 2. Calculate Nights & Format Dates
$nights = 0;
$formatted_checkin = "Select Date";
$formatted_checkout = "Select Date";

if ($checkin && $checkout) {
    try {
        $date1 = new DateTime($checkin);
        $date2 = new DateTime($checkout);
        $interval = $date1->diff($date2);
        $nights = $interval->days;
        $formatted_checkin = $date1->format('M d, Y');
        $formatted_checkout = $date2->format('M d, Y');
    } catch (Exception $e) {}
}

// 3. FETCH AVAILABLE ROOMS
$available_rooms = [];

if ($checkin && $checkout) {
    $checkin_safe = $conn->real_escape_string($checkin);
    $checkout_safe = $conn->real_escape_string($checkout);

    // Query the VIEW (which now excludes view_type)
    $query = "
        SELECT * FROM room_details.room_image_details 
        WHERE room_id NOT IN (
            SELECT br.room_id 
            FROM amv_db.booking_rooms br
            JOIN amv_db.bookings b ON br.booking_id = b.id
            WHERE b.status = 'confirmed' 
            AND (
                ('$checkin_safe' < b.check_out) AND ('$checkout_safe' > b.check_in)
            )
        )
    ";

    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            // Explode amenities if stored as comma-separated string
            $row['amenities'] = !empty($row['amenities']) ? explode(',', $row['amenities']) : [];
            $available_rooms[] = $row;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Rooms - AMV Hotel</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <style>
        /* --- CSS STYLES --- */
        body { font-family: 'Montserrat', sans-serif; background-color: #f5f5f5; margin: 0; color: #333; }
        header { position: fixed; top: 0; width: 100%; padding: 15px 5%; display: flex; justify-content: space-between; align-items: center; z-index: 1000; background-color: #fff; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        
        /* LOGO */
        .logo-container { display: flex; align-items: center; gap: 10px; }
        
        /* STEPPER */
        .booking-stepper { margin-top: 80px; background-color: #fff; padding: 20px 0; display: flex; justify-content: center; gap: 50px; border-bottom:1px solid #eee; }
        .step-item { display: flex; flex-direction: column; align-items: center; color: #ccc; font-size: 0.85rem; font-weight: 500; text-transform: uppercase; letter-spacing: 1px; }
        .step-item.active { color: #9e8236; font-weight: 700; }
        .step-icon { width: 40px; height: 40px; border-radius: 50%; border: 2px solid #ccc; display: flex; align-items: center; justify-content: center; margin-bottom: 10px; font-size:1.2rem; }
        .step-item.active .step-icon { border-color: #9e8236; background-color: #9e8236; color: #fff; }
        .step-item.completed .step-icon { border-color: #333; background-color: #333; color: #fff; }
        .step-item.completed { color: #333; }

        /* LAYOUT */
        .main-container { max-width: 1200px; margin: 40px auto; padding: 0 20px; display: grid; grid-template-columns: 2.5fr 1fr; gap: 30px; }
        
        /* ROOM CARD */
        .room-card { background: #fff; border-radius: 8px; box-shadow: 0 3px 15px rgba(0,0,0,0.05); display: flex; margin-bottom: 30px; border: 1px solid transparent; overflow: hidden; transition:0.2s; }
        .room-card:hover { transform:translateY(-3px); box-shadow:0 10px 25px rgba(0,0,0,0.1); }
        .room-card.selected-card { border: 1px solid #9e8236; background-color: #fffaea; }
        .room-image { width: 35%; object-fit: cover; min-height: 250px; }
        .room-details { padding: 25px; flex: 1; display: flex; flex-direction: column; }
        .room-title { font-size: 1.4rem; font-weight: 700; margin: 0 0 10px 0; color:#333; }
        
        .room-specs { display: flex; gap: 15px; font-size: 0.85rem; color: #666; margin-bottom: 15px; }
        .room-specs i { color: #9e8236; margin-right: 5px; }
        
        .amenity-tag { font-size: 0.75rem; background: #f0f0f0; padding: 5px 10px; border-radius: 4px; margin-right: 5px; color: #666; display:inline-block; margin-bottom:5px; }
        
        .room-footer { display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #eee; padding-top: 20px; margin-top: auto; }
        .price-amount { font-size: 1.4rem; font-weight: 700; color: #9e8236; }
        
        .btn-select { padding: 12px 25px; border: 1px solid #9e8236; background: transparent; color: #9e8236; font-weight: 600; cursor: pointer; border-radius: 4px; transition: 0.3s; }
        .btn-select:hover, .btn-select.active { background: #9e8236; color: #fff; }

        /* SIDEBAR */
        .sidebar { position: sticky; top: 100px; height: fit-content; }
        .summary-box { background: #fff; padding: 25px; border-radius: 8px; box-shadow: 0 3px 15px rgba(0,0,0,0.05); border-top: 4px solid #9e8236; }
        .summary-row { display: flex; justify-content: space-between; margin-bottom: 15px; font-size: 0.9rem; }
        .btn-next { width: 100%; background-color: #333; color: #fff; border: none; padding: 15px; font-weight: 700; cursor: pointer; border-radius: 4px; margin-top: 20px; transition:0.3s; }
        .btn-next:hover { background-color:#555; }
        .btn-next:disabled { background-color: #ccc; cursor: not-allowed; }

        @media (max-width: 900px) {
            .main-container { grid-template-columns: 1fr; }
            .room-card { flex-direction: column; }
            .room-image { width: 100%; height: 200px; }
        }
    </style>
</head>

<body>
    <header>
        <div class="logo-container" style="display:flex; align-items:center; gap:10px;">
            <img src="../../IMG/5.png" alt="AMV Logo" style="height:40px;">
            <div style="font-weight:700; line-height:1;">
                <span style="display:block; color:#9e8236; font-size:20px;">AMV</span>
                <span style="display:block; font-size:12px; letter-spacing:1px; color:#333;">Hotel</span>
            </div>
        </div>
        <nav style="display:flex; align-items:center;">
            <a href="about_us.php" style="color:#333; text-decoration:none; margin-right:20px; text-transform:uppercase; font-size:0.8rem; font-weight:600;">About</a>
            <div style="width:35px; height:35px; border-radius:50%; border:1px solid #ddd; display:flex; align-items:center; justify-content:center; color:#555;"><i class="fa-solid fa-user"></i></div>
        </nav>
    </header>

    <div class="booking-stepper">
        <div class="step-item completed"><div class="step-icon"><i class="fa-regular fa-calendar-check"></i></div>Dates</div>
        <div class="step-item active"><div class="step-icon"><i class="fa-solid fa-bed"></i></div>Select Rooms</div>
        <div class="step-item"><div class="step-icon"><i class="fa-regular fa-id-card"></i></div>Guest Info</div>
        <div class="step-item"><div class="step-icon"><i class="fa-solid fa-check"></i></div>Confirmation</div>
    </div>

    <div class="main-container">
        <div class="room-list-container">
            <h2 style="margin-bottom: 20px;">Available Rooms</h2>
            
            <?php if(empty($available_rooms)): ?>
                <div style="background:#fff; padding:40px; text-align:center; border-radius:8px;">
                    <h3>No rooms available for these dates.</h3>
                    <p style="color:#666;">Please try selecting different check-in/out dates.</p>
                    <a href="check_availability.php" style="display:inline-block; margin-top:15px; color:#9e8236; font-weight:700;">Change Dates</a>
                </div>
            <?php else: ?>
                <?php foreach($available_rooms as $room): ?>
                    <div class="room-card" id="card-<?php echo $room['room_id']; ?>">
                        
                        <?php $imagePath = '/image-storage/uploads/images/' . $room['file_path']; ?>
                        <img src="<?php echo $imagePath; ?>" alt="<?php echo $room['image_name']; ?>" class="room-image">
                        
                        <div class="room-details">
                            <h3 class="room-title"><?php echo $room['image_name']; ?></h3>
                            
                            <div class="room-specs">
                                <span><i class="fa-solid fa-user-group"></i> <?php echo $room['capacity']; ?> Guests</span>
                                <span><i class="fa-solid fa-ruler-combined"></i> <?php echo $room['size']; ?></span>
                                <span><i class="fa-solid fa-bed"></i> <?php echo $room['bed_type']; ?></span>
                            </div>

                            <p style="font-size:0.9rem; color:#555;"><?php echo $room['description']; ?></p>
                            
                            <div style="margin-bottom:15px;">
                                <?php foreach($room['amenities'] as $amenity): ?>
                                    <span class="amenity-tag"><?php echo trim($amenity); ?></span>
                                <?php endforeach; ?>
                            </div>
                            
                            <div class="room-footer">
                                <div><span class="price-amount">$<?php echo $room['price']; ?></span> <span style="font-size:0.8rem;">/ night</span></div>
                                <button class="btn-select" id="btn-<?php echo $room['room_id']; ?>" onclick="toggleRoom(<?php echo $room['room_id']; ?>, '<?php echo addslashes($room['image_name']); ?>', <?php echo $room['price']; ?>)">SELECT</button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <div class="sidebar">
            <div class="summary-box">
                <div style="font-weight:700; margin-bottom:20px; padding-bottom:15px; border-bottom:1px solid #eee;">Booking Summary</div>
                <div class="summary-row"><span>Check-in</span> <b><?php echo $formatted_checkin; ?></b></div>
                <div class="summary-row"><span>Check-out</span> <b><?php echo $formatted_checkout; ?></b></div>
                <div class="summary-row"><span>Guests</span> <b><?php echo $adults; ?> Adult, <?php echo $children; ?> Child</b></div>
                
                <div id="selected-rooms-list" style="margin:15px 0; border-top:1px dashed #ddd; padding-top:10px;"></div>
                
                <div class="summary-row" style="margin-top:15px; font-size:1.2rem;"><span>TOTAL</span> <b style="color:#9e8236;" id="total-price">$0</b></div>
                
                <form action="guest_info.php" method="POST" id="roomsForm">
                    <input type="hidden" name="checkin" value="<?php echo $checkin; ?>">
                    <input type="hidden" name="checkout" value="<?php echo $checkout; ?>">
                    <input type="hidden" name="adults" value="<?php echo $adults; ?>">
                    <input type="hidden" name="children" value="<?php echo $children; ?>">
                    <input type="hidden" name="total_price" id="input-total-price" value="0">
                    <input type="hidden" name="selected_rooms" id="input-selected-rooms" value="">
                    <button type="button" onclick="submitRooms()" id="btn-next-step" class="btn-next" disabled>NEXT STEP</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        const nights = <?php echo $nights; ?>;
        let selectedRooms = [];

        function toggleRoom(id, name, price) {
            const index = selectedRooms.findIndex(room => room.id === id);
            const btn = document.getElementById(`btn-${id}`);
            const card = document.getElementById(`card-${id}`);

            if (index === -1) {
                selectedRooms.push({ id, name, price });
                btn.classList.add('active');
                card.classList.add('selected-card');
                btn.innerText = 'REMOVE';
            } else {
                selectedRooms.splice(index, 1);
                btn.classList.remove('active');
                card.classList.remove('selected-card');
                btn.innerText = 'SELECT';
            }
            updateSidebar();
        }

        function updateSidebar() {
            const listEl = document.getElementById('selected-rooms-list');
            const totalEl = document.getElementById('total-price');
            const nextBtn = document.getElementById('btn-next-step');
            
            listEl.innerHTML = '';
            let total = 0;

            selectedRooms.forEach(room => {
                total += room.price * nights;
                listEl.innerHTML += `<div style="display:flex; justify-content:space-between; font-size:0.85rem; margin-bottom:5px;"><span>${room.name}</span><span>$${room.price * nights}</span></div>`;
            });

            totalEl.innerText = '$' + total;
            document.getElementById('input-total-price').value = total;
            document.getElementById('input-selected-rooms').value = JSON.stringify(selectedRooms);
            
            nextBtn.disabled = selectedRooms.length === 0;
        }

        function submitRooms() {
            document.getElementById('roomsForm').submit();
        }
    </script>
</body>
</html>