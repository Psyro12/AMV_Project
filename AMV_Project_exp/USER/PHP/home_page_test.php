<?php
// Start the session
session_start();

require_once '../PHP/room_includes/includes/ImageManager.php';

$imageManager = new ImageManager();
//$image = $imageManager->getImage(5); // Replace 1 with the actual image ID you want to display


// Check if the user is logged in
if (!isset($_SESSION['user'])) {
  header('Location: login.php');
  exit();
}
// Ensure db_connect_2.php provides $conn for mysqli
// This is necessary for the initial Server-Side Render (SSR) of the room data.
require '../DB-CONNECTIONS/db_connect_2.php'; 

// Get user information from session
$user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>AMV Hotel</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="../STYLE/home_page.css">
  <link rel="stylesheet" href="../STYLE/utilities.css">
  <style>
    /* Add a smooth transition for realtime image updates */
    .room-image {
        transition: opacity 0.5s ease-in-out;
    }
  </style>
</head>

<body>
  <!-- Header -->
  <header>
    <!-- Left Side -->
    <div class="logo-container">
      <img src="../../IMG/5.png" alt="AMV Logo">
      <div class="logo-text">
        <span>AMV</span>
        <span>Hotel</span>
      </div>
    </div>

    <!-- Right Side -->
    <nav>
      <a href="#">Foods</a>
      <a href="#">Rooms</a>
      <a href="#">Event Place</a>
      <a href="#">Your Reservations</a>

      <!-- Normal Icons (Desktop) -->
      <div class="nav-icons desktop-icons">
        <div class="icon-circle" id="profileIcon"><i class="fa-solid fa-user"></i></div>
        <!-- <div class="icon-circle" id="messageIcon"><i class="fa-solid fa-envelope"></i></div> -->
        <!-- <div class="icon-circle" id="notificationIcon"><i class="fa-solid fa-bell"></i></div> -->
      </div>

      <!-- Burger Menu (Mobile) -->
      <div class="burger-menu">
        <i class="fa-solid fa-bars"></i>
        <div class="dropdown px-2">
          <a href="#"><i class="fa-solid fa-user"></i> Profile</a>
          <!-- <a href="#"><i class="fa-solid fa-envelope"></i> Messages</a> -->
          <!-- <a href="#"><i class="fa-solid fa-bell"></i> Notifications</a> -->
        </div>
      </div>
    </nav>

    <!-- Hidden dropdown content -->
    <div class="profile-menu" id="profileMenu">

      <div class="profile-picture">
        <?php
        $profilePic = !empty($user['picture']) ? $user['picture'] : '../../IMG/5.png';
        ?>
        <img src="<?php echo htmlspecialchars($profilePic); ?>" alt="Profile Picture">
      </div>
      <p><strong>Username:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
      <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
      <form action="../PHP/logout.php" method="POST">
        <button type="submit" class="btn logout-btn">Logout</button>
      </form>
    </div>

    <!-- Hidden message dropdown content -->
    <div class="message-menu" id="messageMenu">
      <div class="message-item">
        <i class="fa-solid fa-user-circle"></i>
        <div class="message-info">
          <p><strong>Ana</strong></p>
          <p>Hi! Is my booking confirmed?</p>
          <span class="time">2m ago</span>
        </div>
      </div>

      <div class="message-item">
        <i class="fa-solid fa-user-circle"></i>
        <div class="message-info">
          <p><strong>Mark</strong></p>
          <p>Thanks for the quick response!</p>
          <span class="time">15m ago</span>
        </div>
      </div>

      <a href="#" class="view-all">View All Messages</a>
    </div>

    <!-- Hidden notification dropdown content -->
    <div class="notification-menu" id="notificationMenu">
      <div class="notification-item">
        <i class="fa-solid fa-calendar-check"></i>
        <div class="notification-info">
          <p>Your room booking was approved.</p>
          <span class="time">5m ago</span>
        </div>
      </div>

      <div class="notification-item">
        <i class="fa-solid fa-gift"></i>
        <div class="notification-info">
          <p>Special offer: 20% off spa services this weekend!</p>
          <span class="time">30m ago</span>
        </div>
      </div>

      <div class="notification-item">
        <i class="fa-solid fa-bell"></i>
        <div class="notification-info">
          <p>You have a new reservation alert.</p>
          <span class="time">1h ago</span>
        </div>
      </div>

      <a href="#" class="view-all">View All Notifications</a>
    </div>
  </header>


  <!-- Hero Section -->
  <section class="hero">
    <div class="hero-content">
      <h1>Welcome to AMV Hotel</h1>
      <p>Experience comfort and luxury in the heart of the city. Book your stay with us today!</p>
      <a href="#rooms" class="btn">Book Now</a>
    </div>

    <!-- Scroll Down Indicator -->
    <div class="scroll-indicator">
      <i class="fa-solid fa-chevron-down"></i>
    </div>
  </section>




  <!-- Introduction Section -->
  <section class="intro">
    <div class="intro-content">
      <div class="intro-text">
        <h2>About AMV Hotel</h2>
        <p>
          At AMV Hotel, we combine luxury and comfort to provide a memorable stay for every guest.
          Located in the heart of the city, our hotel offers modern rooms, fine dining, and relaxing
          amenities to make you feel right at home. Whether you’re traveling for business or leisure,
          we are here to give you an exceptional experience.
        </p>
        <a href="#" class="btn">Learn More</a>
      </div>
      <div class="intro-image">
        <img src="../../IMG/intro.png" alt="AMV Hotel Overview">
      </div>
    </div>
  </section>

  <!-- Features Section -->
  <section class="features">
    <div class="feature">
      <i class="fa-solid fa-bed"></i>
      <h3>Luxury Rooms</h3>
      <p>Enjoy modern, comfortable, and fully furnished rooms with a breathtaking view.</p>
    </div>
    <div class="feature">
      <i class="fa-solid fa-utensils"></i>
      <h3>Fine Dining</h3>
      <p>Delight in world-class cuisine at our in-house restaurant and bar.</p>
    </div>
    <div class="feature">
      <i class="fa-solid fa-spa"></i>
      <h3>Spa & Wellness</h3>
      <p>Relax and rejuvenate with our premium spa and wellness facilities.</p>
    </div>
    <div class="feature">
      <i class="fa-solid fa-wifi"></i>
      <h3>Free Wi-Fi</h3>
      <p>Stay connected with complimentary high-speed internet throughout the hotel.</p>
    </div>
  </section>


  <!-- Foods Section -->
  <section class="foods">
    <h2 class="section-title">Our Specialties</h2>
    <p class="section-subtitle">Delight in our hotel’s signature dishes prepared by top chefs.</p>

    <div class="food-grid">
      <!-- First 4 visible foods (whole card is clickable) -->
      <a class="food-item" href="food_ordering.php?item=Grilled%20Salmon&price=450">
        <img src="../../IMG/food_1.jpg" alt="Grilled Salmon">
        <h3>Grilled Salmon</h3>
        <p>Freshly grilled salmon with herbs and lemon butter sauce.</p>
        <span class="price">₱450</span>
      </a>

      <a class="food-item" href="food_ordering.php?item=Steak%20%26%20Fries&price=850">
        <img src="../../IMG/food_2.jpg" alt="Steak & Fries">
        <h3>Steak & Fries</h3>
        <p>Juicy sirloin steak served with crispy golden fries.</p>
        <span class="price">₱850</span>
      </a>

      <a class="food-item" href="food_ordering.php?item=Pasta%20Primavera&price=380">
        <img src="../../IMG/food_3.jpg" alt="Pasta Primavera">
        <h3>Pasta Primavera</h3>
        <p>Italian-style pasta tossed with fresh vegetables and parmesan.</p>
        <span class="price">₱380</span>
      </a>

      <a class="food-item" href="food_ordering.php?item=Classic%20Cheesecake&price=250">
        <img src="../../IMG/food_4.JPG" alt="Cheesecake">
        <h3>Classic Cheesecake</h3>
        <p>Creamy cheesecake with a buttery crust and strawberry topping.</p>
        <span class="price">₱250</span>
      </a>

      <!-- Extra hidden foods -->
      <a class="food-item extra" href="food_ordering.php?item=Caesar%20Salad&price=300">
        <img src="../../IMG/food_5.jpg" alt="Caesar Salad">
        <h3>Caesar Salad</h3>
        <p>Crisp romaine lettuce with parmesan and creamy Caesar dressing.</p>
        <span class="price">₱300</span>
      </a>

      <a class="food-item extra" href="food_ordering.php?item=Chicken%20Adobo&price=280">
        <img src="../../IMG/food_6.jpg" alt="Chicken Adobo">
        <h3>Chicken Adobo</h3>
        <p>Classic Filipino dish simmered in soy sauce, vinegar, and garlic.</p>
        <span class="price">₱280</span>
      </a>

      <a class="food-item extra" href="food_ordering.php?item=Burger%20%26%20Fries&price=320">
        <img src="../../IMG/food_7.jpg" alt="Burger & Fries">
        <h3>Burger & Fries</h3>
        <p>Juicy beef burger with cheese, lettuce, and crispy fries.</p>
        <span class="price">₱320</span>
      </a>

      <a class="food-item extra" href="food_ordering.php?item=Chocolate%20Lava%20Cake&price=280">
        <img src="../../IMG/food_8.jpg" alt="Chocolate Lava Cake">
        <h3>Chocolate Lava Cake</h3>
        <p>Warm chocolate cake with a gooey molten center.</p>
        <span class="price">₱280</span>
      </a>
    </div>

    <!-- Button directly below food grid -->
    <div class="food-toggle">
      <button id="toggleFoodsBtn" class="btn">Show More</button>
    </div>
  </section>



  <!-- Rooms Section -->
  <section class="rooms" id="rooms">
    <h2 class="section-title">Our Rooms</h2>
    <p class="section-subtitle">Choose from our selection of comfortable and stylish rooms.</p>
    <div class="mt-3">
      <?php
      // Initial Server-Side Render (SSR) for SEO and first paint
      // Fetch all room images with their names and descriptions
      // Note: We are using room_image_details here, which is assumed to be the original view.
      $query = "SELECT file_path, image_name, description FROM room_image_details";
      $result = mysqli_query($conn, $query);

      $rooms = [];
      if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
          $rooms[] = $row;
        }
      }

      // We remove mysqli_close($conn); here to keep the connection open until the end of the script execution.
      // mysqli_close($conn); 
      ?>

      <?php if (count($rooms) > 0): ?>
        <div class="room-gallery">
          <?php foreach ($rooms as $index => $room): ?>
            <!-- 
                IMPORTANT: data-room-name is used by the JavaScript for matching the database record
                to the specific HTML card. The value is set using 'image_name'.
            -->
              <?php
                // Build href to pass room details to room_booking.php via query string
                $href = 'room_booking.php?room_name=' . urlencode($room['image_name'])
                . '&file=' . urlencode($room['file_path'])
                . '&desc=' . urlencode($room['description']);
              ?>
              <a id="room-<?php echo $index; ?>" 
                href="<?php echo $href; ?>"
                class="room-card<?php echo ($index >= 3) ? ' room-extra' : ''; ?>" 
                data-index="<?php echo $index; ?>" 
                data-room-name="<?php echo htmlspecialchars($room['image_name']); ?>">
              <?php
              // Construct proper image URL from file_path in database
              $imageUrl = '/image-storage/uploads/images/' . htmlspecialchars($room['file_path']);
              ?>
              <img src="<?php echo $imageUrl; ?>" 
                   alt="<?php echo htmlspecialchars($room['image_name']); ?>"
                   class="room-image">
              <div class="room-info">
                <div class="room-name"><?php echo htmlspecialchars($room['image_name']); ?></div>
                <div class="room-description"><?php echo htmlspecialchars($room['description']); ?></div>
                <div class="mt-3"> <button type="submit" class="book-text pb-3">Book Now</button></div>
              </div>

          </a>
          <?php endforeach; ?>
        </div>
      <?php else: ?>
        <p style="color: #666; font-size: 16px;">No rooms found in the database.</p>
      <?php endif; ?>
    </div>

    <!-- Button directly below room grid -->
    <!-- <div class="room-toggle">
      <button id="toggleRoomsBtn" class="btn">Show More</button>
    </div> -->
  </section>

  <!-- Event Place Section -->
  <section class="event-place">
    <h2 class="section-title">Event Place</h2>
    <p class="section-subtitle">Host your memorable events with us at AMV Hotel.</p>

    <div class="event-card">
      <img src="../../IMG/room_1.jpg" alt="Event Place">
      <div class="event-overlay">
        <h3>Grand Event Hall</h3>
        <p>
          Perfect for weddings, conferences, and special gatherings.
          Spacious, elegant, and equipped with modern facilities.
        </p>
        <p class="contact-number">📞 +63 912 345 6789</p>
        <a href="#" class="btn">Contact Us Now</a>
      </div>
    </div>
  </section>



  <!-- Footer -->
  <footer>
    <p>&copy; 2025 AMV Hotel. All rights reserved.</p>
  </footer>

  <!-- script for home -->
  <script src="../SCRIPT/home_page.js"></script>

  <!-- REALTIME UPDATE SCRIPT -->
  <script>
    // Configuration for image path prefix
    const IMG_BASE_PATH = '/image-storage/uploads/images/';

    function fetchRoomUpdates() {
      // Call API with timestamp to avoid cached responses
      fetch('fetch_room_updates.php?ts=' + Date.now(), { cache: 'no-store' })
        .then(response => {
          if (!response.ok) {
            console.error('API Error: Network response was not ok:', response.status, response.statusText);
            return null;
          }
          return response.json();
        })
        .then(data => {
          if (!data || data.error) {
            console.error("API Error:", data ? data.error : "Failed to parse JSON response.");
            return;
          }

          const rooms = Array.isArray(data) ? data : [];
          const fetchedNames = new Set(rooms.map(r => String(r.image_name)));

          const gallery = document.querySelector('.room-gallery');
          if (!gallery) {
            console.warn('Room gallery not found in DOM');
            return;
          }

          // 1) Remove DOM cards that were deleted from DB
          const existingCards = Array.from(document.querySelectorAll('.room-card'));
          existingCards.forEach(card => {
            const name = card.dataset.roomName;
            if (name && !fetchedNames.has(name)) {
              // Fade out then remove
              card.style.transition = 'opacity 0.35s ease, max-height 0.35s ease';
              card.style.opacity = 0;
              card.style.maxHeight = '0px';
              setTimeout(() => {
                if (card && card.parentNode) card.parentNode.removeChild(card);
              }, 380);
            }
          });

          // 2) Update existing cards and collect which ones exist
          const existingSet = new Set();
          rooms.forEach(room => {
            const id = String(room.image_name);
            const card = document.querySelector(`.room-card[data-room-name="${id}"]`);
            if (card) {
              existingSet.add(id);

              // Update description
              const descEl = card.querySelector('.room-description');
              if (descEl && descEl.textContent !== (room.description || '')) {
                descEl.textContent = room.description || '';
              }

              // Update href in case file or description changed
              try {
                const filePathSafe = room.file_path ? room.file_path.toString().trim() : '';
                const newHref = 'room_booking.php?room_name=' + encodeURIComponent(id)
                              + '&file=' + encodeURIComponent(filePathSafe)
                              + '&desc=' + encodeURIComponent(room.description || '');
                if (card.getAttribute('href') !== newHref) {
                  card.setAttribute('href', newHref);
                }
              } catch (e) {
                // ignore
              }

              // Update image if changed (compare base path)
              const imgEl = card.querySelector('.room-image');
              const filePath = room.file_path ? room.file_path.toString().trim() : '';
              const newBase = IMG_BASE_PATH + filePath;
              if (imgEl) {
                const currentSrc = imgEl.getAttribute('src') || '';
                const currentBase = currentSrc.split('?')[0];
                if (filePath && currentBase !== newBase) {
                  // Preload and swap with cache-bust
                  const temp = new Image();
                  temp.onload = () => {
                    imgEl.style.transition = 'opacity 0.35s ease-in-out';
                    imgEl.style.opacity = 0;
                    imgEl.src = newBase + '?v=' + Date.now();
                    setTimeout(() => { imgEl.style.opacity = 1; }, 60);
                  };
                  temp.onerror = () => { console.error('Failed to preload', newBase); };
                  temp.src = newBase;
                }
              }
            }
          });

          // 3) Insert new cards for rooms not in DOM yet
          rooms.forEach(room => {
            const id = String(room.image_name);
                if (!document.querySelector(`.room-card[data-room-name="${id}"]`)) {
                  // Create a new anchor card element with href to room_booking.php
                  const filePath = room.file_path ? room.file_path.toString().trim() : '';
                  const imgSrc = IMG_BASE_PATH + filePath + '?v=' + Date.now();
                  const href = 'room_booking.php?room_name=' + encodeURIComponent(id)
                               + '&file=' + encodeURIComponent(filePath)
                               + '&desc=' + encodeURIComponent(room.description || '');

                  const card = document.createElement('a');
                  card.className = 'room-card';
                  card.setAttribute('data-room-name', id);
                  card.setAttribute('href', href);
                  card.innerHTML = `
                    <img src="${imgSrc}" alt="${escapeHtml(id)}" class="room-image" style="opacity:0">
                    <div class="room-info">
                      <div class="room-name">${escapeHtml(id)}</div>
                      <div class="room-description">${escapeHtml(room.description || '')}</div>
                      <div class="mt-3"><button type="submit" class="book-text pb-3">Book Now</button></div>
                    </div>
                  `;

                  gallery.appendChild(card);
                  // Force reflow then fade in
                  void card.offsetWidth;
                  const img = card.querySelector('.room-image');
                  card.style.transition = 'opacity 0.35s ease';
                  card.style.opacity = 1;
                  if (img) setTimeout(() => { img.style.opacity = 1; }, 60);
                }
          });

        })
        .catch(error => console.error("Error polling rooms:", error));
    }

    // Utility: escape basic HTML in inserted strings
    function escapeHtml(str) {
      return String(str)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#39;');
    }

    // Start polling every 3 seconds (adjust frequency as needed)
    setInterval(fetchRoomUpdates, 3000);
  </script>
</body>

</html>