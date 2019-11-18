<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body data-spy="scroll" data-target=".fixed-top" style="background-color: black;">



    <!-- Testimonials -->
    <div class="slider-1">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">

                    <!-- Card Slider -->
                    <div class="slider-container">
                        <div class="swiper-container card-slider">
                            <div id="list-of-reviews" class="swiper-wrapper">

                            </div>
                            <!-- end of swiper-wrapper -->

                            <!-- Add Arrows -->
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                            <!-- end of add arrows -->

                        </div>
                        <!-- end of swiper-container -->
                    </div>
                    <!-- end of slider-container -->
                    <!-- end of card slider -->

                </div>
                <!-- end of col -->
            </div>
            <!-- end of row -->
        </div>
        <!-- end of container -->
    </div>
    <!-- end of slider-1 -->
    <!-- end of testimonials -->


    
    <script>
        function addReview(reviewText, reviewStars) {
            var listOfReviews = document.getElementById('list-of-reviews');
            if (typeof listOfReviews !== 'undefined') {
                var swiperSlide = document.createElement('div');
                swiperSlide.classList.add("swiper-slide");

                var card = document.createElement('div');
                card.classList.add("card");

                var cardBody = document.createElement('div');
                cardBody.classList.add("card-body");

                var testimonialText = document.createElement('p');
                testimonialText.classList.add("testimonial-text");
                testimonialText.innerText = reviewText.toString();

                cardBody.appendChild(testimonialText);
                card.appendChild(cardBody);

                var reviewStasr = document.createElement('div');
                reviewStasr.classList.add("review-stasr");
                for (i = 0; i < reviewStars; i++) {
                    var fafaStar = document.createElement('i');
                    fafaStar.classList.add("fa", "fa-star");
                    reviewStasr.appendChild(fafaStar);
                }
                card.appendChild(reviewStasr);

                swiperSlide.appendChild(card);

                if (listOfReviews.children.length > 0) {
                    listOfReviews.insertBefore(swiperSlide, listOfReviews.children[0]);
                } else {
                    listOfReviews.appendChild(swiperSlide);
                }
            }
        }
    </script>









    <?php 
        header('Content-Type: text/html; charset=utf-8');

        function executeJavaScript($javaScriptToExecute) {
            echo '<script>' . $javaScriptToExecute . '</script>';
        }
        function phpAlert($message) {
            executeJavaScript('alert("' . $message . '");');
        }

        $servername = "sachinsshahcom.ipagemysql.com";
        $username = "muetube";
        $password = "muetube";
        $database = "muetube";

        $conn = mysqli_connect($servername, $username, $password, $database);

        if(!$conn){
            phpAlert('error');
        }
        else {
            //UPDATE REVIEWS
            $sqlSelectReviewsQuery = "SELECT * FROM muetube_landing_reviews ORDER BY review_position DESC, review_id DESC";
            $resultFromSelectReviewsQuery = mysqli_query($conn,$sqlSelectReviewsQuery);
            if (!$resultFromSelectReviewsQuery) {
                phpAlert("no reviews");
                die('Invalid reviews query: ' . mysql_error());
            }
            else{
                while($row = $resultFromSelectReviewsQuery->fetch_assoc()) {
                    executeJavaScript('addReview("'.$row["review_text"].'",'.$row["review_stars"].');');                    
                }
            }
            //UPDATE REVIEWS


        } 
        $conn->close();
    ?>


</body>

</html>