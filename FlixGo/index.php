
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
    // $sql = "SELECT * FROM movies WHERE movieid IN (SELECT movieid FROM ratings WHERE rank = (SELECT MAX(rank) FROM ratings)) like  '%$searchTerm%'
	// ";
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
					<h1 class="home__title">Latest Movies</h1>

					<button class="home__nav home__nav--prev" type="button">
						<i class="icon ion-ios-arrow-round-back"></i>
					</button>
					<button class="home__nav home__nav--next" type="button">
						<i class="icon ion-ios-arrow-round-forward"></i>
					</button>
				</div>

				<div class="col-12">
					<div class="owl-carousel home__carousel">
					

<?php
		$servername = "localhost";
		$username = "root";
		$password = "";
		$dbname = "flixgo";

		// Create connection
		$conn = mysqli_connect($servername, $username, $password, $dbname);
		// Check connection
		if (!$conn) {
			die("Connection failed: " . mysqli_connect_error());
		}

		$sql = "SELECT * FROM movies limit 10";
		$result = mysqli_query($conn, $sql);

		if (mysqli_num_rows($result) > 0) {
			// output data of each row
			while($row = mysqli_fetch_assoc($result)) {
				//  echo "id: " . $row["movieid"]. " - Name: " . $row["title"]. " " . $row["year"]. "<br>";

	

?>
						<div class="item">
							<!-- card -->
							<div class="card card--big">
								<div class="card__cover">
								<?php
            $imageUrl = $row["urls"];
            if (empty($imageUrl)) {
                $imageUrl = "img/covers/cover2.jpg"; // Set the path to the default image
            }
            ?>
            <img src="<?php echo $imageUrl; ?>" alt="">
            <a href="/flixgo/details.php?id=<?php echo $row["movieid"]; ?>" class="card__play">
                <i class="icon ion-ios-play"></i>
            </a>
								</div>
								<div class="card__content">
									<h3 class="card__title"><a href="/flixgo/details.php?id=<?php echo  $row["movieid"];?>"><?php echo $row["title"]; ?></a></h3>
									<span class="card__category">
										<a href="#"><?php
										$sql1 = "SELECT * FROM movies2directors where movieid=".$row["movieid"];
										$result1 = mysqli_query($conn, $sql1);
								
										if (mysqli_num_rows($result1) > 0) {
											// output data of each row
											while($row1 = mysqli_fetch_assoc($result1)) {
										
												echo $row1["genre"];
										
										} }	?></a>
									</span>
									<?php
										$sql2 = "SELECT * FROM ratings where movieid=".$row["movieid"];
										$result2 = mysqli_query($conn, $sql2);
								
										if (mysqli_num_rows($result2) > 0) {
											// output data of each row
											while($row2 = mysqli_fetch_assoc($result2)) {
										
												
										?>
												<span class="card__rate"><i class="icon ion-ios-star"></i><?php echo $row2["rank"];?></span>
												<?php

										} }	?>
									
								</div>
							</div>
							<!-- end card -->
						</div>
				<?php	}
				} 
				mysqli_close($conn);
				?>

						
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- end home -->



	<!-- catalog -->


		
	
	<!-- <hr style="margin: 100px;"> -->
	<hr class="my-5"  >





<div class="catalog">
    <div class="container">
        <h5 class="home__title" style="margin-bottom: 20px;">Featured Movies</h5>

        <div class="row">
            <?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "flixgo";

            // Create connection
            $conn = mysqli_connect($servername, $username, $password, $dbname);
            // Check connection
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            // Calculate total number of pages
            $sql = "SELECT COUNT(*) AS total FROM movies";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            $totalPages = ceil($row['total'] / 12); // Assuming 12 items per page

            // Get current page from query parameter or default to 1
            $page = isset($_GET['page']) ? $_GET['page'] : 1;

            // Validate and adjust page number
            if ($page < 1) {
                $page = 1;
            } elseif ($page > $totalPages) {
                $page = $totalPages;
            }

            // Calculate the offset for pagination
            $offset = ($page - 1) * 12;

            $sql = "SELECT * FROM movies LIMIT $offset, 12";
            $result = mysqli_query($conn, $sql);

            // Array of image URLs
            $imageUrls = [
                "img/covers/cover.jpg",
                "img/covers/cover2.jpg",
                "img/covers/cover3.jpg",
                "img/covers/cover4.jpg",
                "img/covers/cover5.jpg",
                "img/covers/cover6.jpg",
				"img/covers/3-iron.jpg",
                "img/covers/13-assassins-poster-movie.jpg",
                // "img/covers/24.jpg",
                "img/covers/A_Quiet_Place.jpg",
                "img/covers/kiss.jpg",
			
                "img/covers/David_Attenborough.jpg",
                // "img/covers/Dhakaad.jpg",
                "img/covers/Dirty_Money.jpg",
                "img/covers/Attack.jpg",
           

                // Add more image URLs as needed
            ];

            if (mysqli_num_rows($result) > 0) {
                // Output data of each row
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <div class="col-6 col-sm-4 col-lg-3 col-xl-2">
                        <div class="card">
                            <div class="card__cover">
                                <?php
                                // Get a random image URL from the array
                                $imageUrl = $imageUrls[array_rand($imageUrls)];
                                ?>
                                <img src="<?php echo $imageUrl; ?>" alt="">
                                <a href="/flixgo/details.php?id=<?php echo $row["movieid"]; ?>" class="card__play">
                                    <i class="icon ion-ios-play"></i>
                                </a>
                            </div>
                            
                            <div class="card__content">
                                <h3 class="card__title">
                                    <a href="/flixgo/details.php?id=<?php echo $row["movieid"]; ?>">
                                        <?php echo $row["title"]; ?>
                                    </a>
                                </h3>
                                <span class="card__category">
                                    <a href="#">
                                        <?php
                                        $sql1 = "SELECT * FROM movies2directors WHERE movieid=" . $row["movieid"];
                                        $result1 = mysqli_query($conn, $sql1);

                                        if (mysqli_num_rows($result1) > 0) {
                                            // Output data of each row
                                            while ($row1 = mysqli_fetch_assoc($result1)) {
                                                echo $row1["genre"];
                                            }
                                        }
                                        ?>
                                    </a>
                                </span>
                                <span class="card__rate">
                                    <i class="icon ion-ios-star"></i>
                                    <?php echo (rand(7, 9)); echo "."; echo (rand(1, 9)); ?>
                                </span>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            mysqli_close($conn);
            ?>
        </div>
        
        <!-- Pagination -->
		<div class="col-12">
        <ul class="paginator">
            <?php
            if ($page > 1) {
                echo '<li class="paginator__item paginator__item--prev">
                        <a href="?page=' . ($page - 1) . '"><i class="icon ion-ios-arrow-back"></i></a>
                    </li>';
            }

            if ($page > 2) {
                echo '<li class="paginator__item">
                        <a href="?page=1">1</a>
                    </li>';
                if ($page > 3) {
                    echo '<li class="paginator__item paginator__item--ellipsis" style="color: white;">...</li>';
                }
            }

            $startPage = max(1, $page - 2);
            $endPage = min($startPage + 4, $totalPages);

            for ($i = $startPage; $i <= $endPage; $i++) {
                $activeClass = ($page == $i) ? 'paginator__item--active' : '';
                echo '<li class="paginator__item ' . $activeClass . '">
                        <a href="?page=' . $i . '">' . $i . '</a>
                    </li>';
            }

            if ($page < $totalPages - 1) {
                if ($page < $totalPages - 2) {
                    echo '<li class="paginator__item paginator__item--ellipsis" style="color: white;">...</li>';
                }
                echo '<li class="paginator__item">
                        <a href="?page=' . $totalPages . '">' . $totalPages . '</a>
                    </li>';
            }

            if ($page < $totalPages) {
                echo '<li class="paginator__item paginator__item--next">
                        <a href="?page=' . ($page + 1) . '"><i class="icon ion-ios-arrow-forward"></i></a>
                    </li>';
            }
            ?>
        </ul>
    </div>
        <!-- ... -->
        
    </div>
</div>



			</div>
		</div>
	</div>
	<!-- end catalog -->


	<!-- partners -->
	<section class="section">
		<div class="container">
			<div class="row">
				<!-- section title -->
				<div class="col-12">
					<h2 class="section__title section__title--no-margin">Our Partners</h2>
				</div>
				<!-- end section title -->

				<!-- section text -->
				<div class="col-12">
					<p class="section__text section__text--last-with-margin">It is a long <b>established</b> fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using.</p>
				</div>
				<!-- end section text -->

				<!-- partner -->
				<div class="col-6 col-sm-4 col-md-3 col-lg-2">
					<a href="#" class="partner">
						<img src="img/partners/themeforest-light-background.png" alt="" class="partner__img">
					</a>
				</div>
				<!-- end partner -->

				<!-- partner -->
				<div class="col-6 col-sm-4 col-md-3 col-lg-2">
					<a href="#" class="partner">
						<img src="img/partners/audiojungle-light-background.png" alt="" class="partner__img">
					</a>
				</div>
				<!-- end partner -->

				<!-- partner -->
				<div class="col-6 col-sm-4 col-md-3 col-lg-2">
					<a href="#" class="partner">
						<img src="img/partners/codecanyon-light-background.png" alt="" class="partner__img">
					</a>
				</div>
				<!-- end partner -->

				<!-- partner -->
				<div class="col-6 col-sm-4 col-md-3 col-lg-2">
					<a href="#" class="partner">
						<img src="img/partners/photodune-light-background.png" alt="" class="partner__img">
					</a>
				</div>
				<!-- end partner -->

				<!-- partner -->
				<div class="col-6 col-sm-4 col-md-3 col-lg-2">
					<a href="#" class="partner">
						<img src="img/partners/activeden-light-background.png" alt="" class="partner__img">
					</a>
				</div>
				<!-- end partner -->

				<!-- partner -->
				<div class="col-6 col-sm-4 col-md-3 col-lg-2">
					<a href="#" class="partner">
						<img src="img/partners/3docean-light-background.png" alt="" class="partner__img">
					</a>
				</div>
				<!-- end partner -->
			</div>
		</div>
	</section>
	<!-- end partners -->

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