
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Font -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600%7CUbuntu:300,400,500,700" rel="stylesheet">

	<!-- CSS -->
	<link rel="stylesheet" href="css/bootstrap-reboot.min.css">
	<link rel="stylesheet" href="css/bootstrap-grid.min.css">
	<link rel="stylesheet" href="css/owl.carousel.min.css">
	<link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">
	<link rel="stylesheet" href="css/nouislider.min.css">
	<link rel="stylesheet" href="css/ionicons.min.css">
	<link rel="stylesheet" href="css/plyr.css">
	<link rel="stylesheet" href="css/photoswipe.css">
	<link rel="stylesheet" href="css/default-skin.css">
	<link rel="stylesheet" href="css/main.css">

	<!-- Favicons -->
	<link rel="icon" type="image/png" href="icon/favicon-32x32.png" sizes="32x32">
	<link rel="apple-touch-icon" href="icon/favicon-32x32.png">
	<link rel="apple-touch-icon" sizes="72x72" href="icon/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="114x114" href="icon/apple-touch-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="144x144" href="icon/apple-touch-icon-144x144.png">

	<meta name="description" content="">
	<meta name="keywords" content="">
	<meta name="author" content="Dmitry Volkov">
	<title>FlixGo – Online Movies</title>

</head>
<body class="body">

	
	<!-- header -->
	<header class="header">
		<div class="header__wrap">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<div class="header__content">
							<!-- header logo -->
							<a href="index.php" class="header__logo">
								<img src="img/logo.svg" alt="">
							</a>
							<!-- end header logo -->

							<!-- header nav -->
							<ul class="header__nav">
								<!-- dropdown -->
								<li class="header__nav-item">
									<a class="dropdown-toggle header__nav-link" href="index.php" role="button" id="dropdownMenuHome"  aria-haspopup="true" aria-expanded="false">Home</a>

						
								</li>
						

								<li class="header__nav-item">
									<a href="pricing.html" class="header__nav-link">Pricing Plan</a>
								</li>

								<li class="header__nav-item">
									<a href="faq.html" class="header__nav-link">Help</a>
								</li>

								<!-- dropdown -->
								<li class="dropdown header__nav-item">
									<a class="dropdown-toggle header__nav-link header__nav-link--more" href="#" role="button" id="dropdownMenuMore" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icon ion-ios-more"></i></a>

									<ul class="dropdown-menu header__dropdown-menu" aria-labelledby="dropdownMenuMore">
										<li><a href="about.html">About</a></li>
										<li><a href="signin.html">Sign In</a></li>
										<li><a href="signup.html">Sign Up</a></li>
										<li><a href="404.html">404 Page</a></li>
									</ul>
								</li>
								<!-- end dropdown -->
							</ul>
							<!-- end header nav -->

							<!-- header auth -->
							<div class="header__auth">
								<button class="header__search-btn" type="button">
									<i class="icon ion-ios-search"></i>
								</button>
								

								<a href="signin.html" class="header__sign-in">
									<i class="icon ion-ios-log-in"></i>
									<span>sign in</span>
								</a>
							</div>
							<!-- end header auth -->

							<!-- header menu btn -->
							<button class="header__btn" type="button">
								<span>dfdfdf</span>
								<span>dfd</span>
								<span>dff</span>
							</button>
							<!-- end header menu btn -->
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- header search -->
		<form method="GET" action="search.php" class="header__search">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="header__search-content">
                    <input type="text" class="form-control search-input" name="search" placeholder="Search for a movie, TV Series that you are looking for">
                    <button type="submit">search</button>
                </div>
            </div>
        </div>
    </div>
</form>


	
		<?php
// Check if the search parameter is set
if (isset($_GET['search'])) {
    // Retrieve the search term from the GET request
    $searchTerm = $_GET['search'];

    // Connect to your MySQL database
    $dbHost = 'localhost';
    $dbUsername = 'root';
    $dbPassword = '';
    $dbName = 'flixgo';

    $conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

    // Check the database connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Perform the movie search query
    $sql = "SELECT * FROM movies WHERE title LIKE '%$searchTerm%' limit 1";
    $result = $conn->query($sql);

    // Display the search results
    if (!empty($result) && $result->num_rows > 0) {
        echo '<h3 style="color: white; margin-top: 40px; margin-left: 40px;">Search results for:</h3>';
        echo '<div class="result-container" style="height: 500px; overflow-y: auto; scrollbar-width: thin;">'; // Add container with fixed height and scrollable overflow
        echo '<div class="row" style="padding: 40px;">'; // Add padding to the row
        while ($row = $result->fetch_assoc()) {
            echo '<div class="col-6 col-sm-4 col-lg-3 col-xl-2" style="margin-bottom: 40px;">'; // Add margin to the columns
            echo '<div class="card">';
            echo '<div class="card__cover">';
            $imageUrl = $row["urls"];
            if (empty($imageUrl)) {
                $imageUrl = "img/covers/cover2.jpg"; // Set the path to the default image
            }
            echo "<img src='$imageUrl' alt=''>";
            echo "<a href='/flixgo/details.php?id={$row["movieid"]}' class='card__play'>";
            echo "<i class='icon ion-ios-play'></i>";
            echo "</a>";
            echo "</div>";
            echo "<div class='card__content'>";
            echo "<h3 class='card__title'>";
            echo "<a href='/flixgo/details.php?id={$row["movieid"]}'>";
            echo $row["title"];
            echo "</a>";
            echo "</h3>";
            echo "<span class='card__category'>";
            echo "<a href='#'>";
            $sql1 = "SELECT * FROM movies2directors WHERE movieid={$row["movieid"]}";
            $result1 = mysqli_query($conn, $sql1);

            if (mysqli_num_rows($result1) > 0) {
                // Output data of each row
                while ($row1 = mysqli_fetch_assoc($result1)) {
                    echo $row1["genre"];
                }
            }
            echo "</a>";
            echo "</span>";
            echo "<span class='card__rate'>";
            echo "<i class='icon ion-ios-star'></i>";
            echo rand(7, 9) . "." . rand(1, 9);
            echo "</span>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
        }
        echo "</div>";
        echo "</div>";
    } else {
        echo "<p>No results found.</p>";
    }
    // Close the database connection
    $conn->close();
}
?>




    </div>

		<!-- end header search -->
	</header>
	<!-- end header -->

	<!-- home -->
	<section class="home">
		<!-- home bg -->
		
		<div class="owl-carousel home__bg">
			
		</div>
		<!-- end home bg -->

		<div class="container">
			<div class="row">
				<div class="col-12">
					<h1 class="home__title">YOUR SEARCH RESULT IS:</h1>

					
				</div>

				

						
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- end home -->



	<!-- catalog -->


		
	



			</div>
		</div>
	</div>
	<!-- end catalog -->

	<!-- footer -->
	<footer class="footer">
		<div class="container">
			<div class="row">
				<!-- footer list -->
				<div class="col-12 col-md-3">
					<h6 class="footer__title">Download Our App</h6>
					<ul class="footer__app">
						<li><a href="#"><img src="img/Download_on_the_App_Store_Badge.svg" alt=""></a></li>
						<li><a href="#"><img src="img/google-play-badge.png" alt=""></a></li>
					</ul>
				</div>
				<!-- end footer list -->

				<!-- footer list -->
				<div class="col-6 col-sm-4 col-md-3">
					<h6 class="footer__title">Resources</h6>
					<ul class="footer__list">
						<li><a href="#">About Us</a></li>
						<li><a href="#">Pricing Plan</a></li>
						<li><a href="#">Help</a></li>
					</ul>
				</div>
				<!-- end footer list -->

				<!-- footer list -->
				<div class="col-6 col-sm-4 col-md-3">
					<h6 class="footer__title">Legal</h6>
					<ul class="footer__list">
						<li><a href="#">Terms of Use</a></li>
						<li><a href="#">Privacy Policy</a></li>
						<li><a href="#">Security</a></li>
					</ul>
				</div>
				<!-- end footer list -->

				<!-- footer list -->
				<div class="col-12 col-sm-4 col-md-3">
					<h6 class="footer__title">Contact</h6>
					<ul class="footer__list">
						<li><a href="tel:+39002345678">+39 (800) 234-5678</a></li>
						<li><a href="mailto:shanisukk@gmail.com">support@gmail.com</a></li>
					</ul>
					<ul class="footer__social">
						<li class="facebook"><a href="#"><i class="icon ion-logo-facebook"></i></a></li>
						<li class="instagram"><a href="#"><i class="icon ion-logo-instagram"></i></a></li>
						<li class="twitter"><a href="#"><i class="icon ion-logo-twitter"></i></a></li>
						<li class="vk"><a href="#"><i class="icon ion-logo-vk"></i></a></li>
					</ul>
				</div>
				<!-- end footer list -->

				
			</div>
		</div>
	</footer>
	<!-- end footer -->

	<!-- JS -->
	<script src="js/jquery-3.3.1.min.js"></script>
	<script src="js/bootstrap.bundle.min.js"></script>
	<script src="js/owl.carousel.min.js"></script>
	<script src="js/jquery.mousewheel.min.js"></script>
	<script src="js/jquery.mCustomScrollbar.min.js"></script>
	<script src="js/wNumb.js"></script>
	<script src="js/nouislider.min.js"></script>
	<script src="js/plyr.min.js"></script>
	<script src="js/jquery.morelines.min.js"></script>
	<script src="js/photoswipe.min.js"></script>
	<script src="js/photoswipe-ui-default.min.js"></script>
	<script src="js/main.js"></script>







</body>

</html>













































