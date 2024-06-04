<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
        integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
</head>
<body class="bg-content">
    <main class="dashboard d-flex">
        <!-- start sidebar -->

        <?php 
            include "component/sidebar.php";
            include 'conixion.php';
            $nbr_movie = $con->query("SELECT * FROM movie_list");
            $nbr_movie = $nbr_movie->rowCount();

            $nbr_cours = $con->query("SELECT * FROM booking");
            $nbr_cours = $nbr_cours->rowCount();


        ?>
        <!-- end sidebar -->

        <!-- start content page -->
        <div class="container-fluid px">
        <?php 
            include "component/header.php";
        ?>
            <div class="cards row gap-3 justify-content-center mt-5">
                <div class=" card__items card__items--blue col-md-3 position-relative">
                    <div class="card__Booking d-flex flex-column gap-2 mt-3">
                        <i class="far fa-video h3"></i>
                        <span>Movie</span>
                    </div>
                    <div class="card__nbr-movie">
                        <span class="h5 fw-bold nbr"><?php echo $nbr_movie; ?></span>
                    </div>
                </div>

                <div class=" card__items card__items--rose col-md-3 position-relative">
                    <div class="card__Course d-flex flex-column gap-2 mt-3">
                        <i class="fal fa-ticket me-2 h3"></i>
                        <span>Booking</span>
                    </div>
                    <div class="card__nbr-course">
                        <span class="h5 fw-bold nbr"><?php echo $nbr_cours; ?></span>
                    </div>
                </div>

                <div class=" card__items card__items--yellow col-md-3 position-relative">
                    <div class="card__payments d-flex flex-column gap-2 mt-3">
                        <i class="fal fa-comment me-2 h3"></i>
                        <span>Feedback</span>
                    </div>
                    <div class="card__payments">
                        <span class="h5 fw-bold nbr">0</span>
                    </div>
                </div>

                <div class="card__items card__items--gradient col-md-3 position-relative">
                    <div class="card__users d-flex flex-column gap-2 mt-3">
                        <i class="fal fa-user h3"></i>
                        <span>Users</span>
                    </div>
                    <span class="h5 fw-bold nbr">1</span>
                </div>
            </div>

        </div>
        <!-- end contentpage -->
    </main>
    <script src="../js/script.js"></script>
    <script src="/js/bootstrap.bundle.js"></script>
</body>

</html>