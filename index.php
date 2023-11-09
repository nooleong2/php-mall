<?php
// SESSION
include "./assets/admin/inc/session.php";

// DATABASE
include "./assets/database/database.php";

// CLASS
include "./assets/admin/class/category_manager.php";
$cm = new CategoryManager($conn);
$categorys = $cm -> getCategoryAll();

// HEADER
$css_array = ["./css/carousel.css"];
include "./inc/inc_header.php";
?>

    <main>
    
        <div id="myCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="active" aria-current="true"
                    aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div style="width:100%; height:32rem; background-image:url(./images/banner1.jpg); background-size: cover; background-position: center;"></div>
    
                    <div class="container">
                        <div class="carousel-caption text-start">
                            <h1>Example headline.</h1>
                            <p>Some representative placeholder content for the first slide of the carousel.</p>
                            <p><a class="btn btn-lg btn-primary" href="./product.php?ccode=C1">Sign up today</a></p>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                <div style="width:100%; height:32rem; background-image:url(./images/banner2.jpg); background-size: cover; background-position: center;"></div>
    
                    <div class="container">
                        <div class="carousel-caption">
                            <h1>Another example headline.</h1>
                            <p>Some representative placeholder content for the second slide of the carousel.</p>
                            <p><a class="btn btn-lg btn-primary" href="./product.php?ccode=C2">Learn more</a></p>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                <div style="width:100%; height:32rem; background-image:url(./images/banner3.jpg); background-size: cover; background-position: center;"></div>
    
                    <div class="container">
                        <div class="carousel-caption text-end">
                            <h1>One more for good measure.</h1>
                            <p>Some representative placeholder content for the third slide of this carousel.</p>
                            <p><a class="btn btn-lg btn-primary" href="./product.php?ccode=C3">Browse gallery</a></p>
                        </div>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    
        </div><!-- /.container -->
    
        <!-- FOOTER -->
        <footer class="container">
                <p class="float-end"><a href="#">Back to top</a></p>
                <p>&copy; 2017–2022 Company, Inc. &middot; <a href="#">Privacy</a> &middot; <a href="#">Terms</a></p>
        </footer>
    </main>
  </body>
</html>