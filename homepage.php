<?php
session_start();
if(!isset($_SESSION['email'])){
    header('Location: index.php');
    exit();
}
include("connect.php");

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<!-- Navigation -->
  <header>
    <nav class="navbar">
      <div class="logo">Fuelpump</div>
      <ul class="nav-links">
        <li><a href="#home">Home</a></li>
        <li><a href="#features">Features</a></li>
        <li><a href="#pricing">Pricing</a></li>
        <li><a href="#contact">Contact</a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </nav>
  </header>

  <!-- Hero Section -->
  <section id="home" class="hero">
    <div class="hero-text">
      <p class="tagline">Smart Fuel Price Finder</p>
      <h1>Find the Lowest Gas Prices Near You</h1>
      <p>
        Fuelpump helps drivers compare nearby gas station prices, discover the best deals,
        and enjoy premium perks like priority service upon arrival.
      </p>
      <div class="hero-buttons">
        <a href="#pricing" class="btn primary">View Plans</a>
        <a href="#features" class="btn secondary">Explore Features</a>
      </div>
    </div>

    <div class="hero-card">
      <h3>Nearby Stations</h3>
      <div class="station">
        <div>
          <h4>Petron</h4>
          <p>1.2 km away</p>
        </div>
        <span>XCS ₱58.20/L</span>
        <span>Blade 100 ₱58.20/L</span>
        <span>Leaded ₱58.20/L</span>
      </div>
      <div class="station">
        <div>
          <h4>Shell</h4>
          <p>2.0 km away</p>
        </div>
        <span> Regular ₱57.80/L</span>
        <span> Plus ₱58.20/L</span>
        <span> Diesel ₱58.20/L</span>
        <span> V Power Nitro ₱58.20/L</span>
      </div>
      <div class="station">
        <div>
          <h4>Caltex</h4>
          <p>3.5 km away</p>
        </div>
        <span>With Techron ₱57.80/L</span>
        <span>Silver Leaded  ₱58.20/L</span>
        <span>Gold Leaded ₱58.20/L</span>
        <span>Platinum Diesel ₱58.20/L</span>
      </div>
    </div>
  </section>

  <!-- Features -->
  <section id="features" class="features">
    <h2>Key Features</h2>
    <p class="section-text">Designed to help customers save money, save time, and choose the best gas station experience.</p>

    <div class="feature-grid">
      <div class="feature-box">
        <h3>Lowest Price Finder</h3>
        <p>Compare fuel prices from multiple gas stations and instantly find the most affordable option.</p>
      </div>
      <div class="feature-box">
        <h3>Nearby Station Locator</h3>
        <p>Locate gas stations near your area and choose based on distance, price, and availability.</p>
      </div>
      <div class="feature-box">
        <h3>Priority Upon Arrival</h3>
        <p>Premium users can enjoy a priority lane or faster service at partner gas stations upon arrival.</p>
      </div>
      <div class="feature-box">
        <h3>Price Alerts</h3>
        <p>Receive notifications when fuel prices drop in your favorite or nearest stations.</p>
      </div>
    </div>
  </section>

  <!-- Pricing -->
  <section id="pricing" class="pricing">
    <h2>Choose Your Plan</h2>
    <p class="section-text">Flexible options for everyday drivers and premium users.</p>

    <div class="pricing-grid">
      <div class="price-box">
        <h3>Free Plan</h3>
        <p>Perfect for basic fuel price checking.</p>
        <h4>₱0/month</h4>
        <ul>
          <li>View nearby gas stations</li>
          <li>Compare fuel prices</li>
          <li>Basic station details</li>
          <li>Save favorite stations</li>
        </ul>
      </div>

      <div class="price-box premium">
        <span class="badge">MOST POPULAR</span>
        <h3>Premium Plan</h3>
        <p>For users who want extra savings and convenience.</p>
        <h4>₱149/month</h4>
        <ul>
          <li>Everything in Free Plan</li>
          <li>Priority service upon arrival</li>
          <li>Exclusive fuel discounts</li>
          <li>Real-time fuel price alerts</li>
          <li>Partner station promos and rewards</li>
        </ul>
      </div>
    </div>
  </section>

  <!-- Contact -->
  <section id="contact" class="contact">
    <h2>Ready to Save on Fuel?</h2>
    <p>
      FuelFinder makes it easier for drivers to locate the best fuel prices
      while enjoying smarter, faster gas station experiences.
    </p>

    <div class="contact-form">
      <input type="email" id="emailInput" placeholder="Enter your email">
      <button onclick="joinWaitlist()">Join Waitlist</button>
    </div>
  </section>

  <!-- Footer -->
  <footer>
    <p>© 2026 FuelFinder. Built for Technopreneurship Project.</p>
  </footer>

  <script src="script.js"></script>
    <!-- <div style="text-align:center; padding:15%;">
      <p  style="font-size:50px; font-weight:bold;">
       <?php 
       if(isset($_SESSION['email'])){
        $email=$_SESSION['email'];
        $query=mysqli_query($conn, "SELECT users.* FROM `users` WHERE users.email='$email'");
        while($row=mysqli_fetch_array($query)){
            
        }
       }
       ?>
       :)
      </p>
      <a href="logout.php">Logout</a>
    </div> -->
</body>
</html>