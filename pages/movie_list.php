<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie_list</title>
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
        ?>
        <!-- end sidebar -->

        <!-- start content page -->
        <div class="container-fluid px-4">
        <?php 
            include "component/header.php";
        ?>
          
        
            <!-- start table -->
            <div class="movie-list-header d-flex justify-content-between align-items-center py-2">
                <div class="title h6 fw-bold">Movie List</div>
                <div class="btn-add d-flex gap-3 align-items-center">
                    <div class="short">
                        <i class="far fa-sort"></i>
                    </div>
                    <?php include 'component/popupadd.php'; ?>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table movie_list table-borderless">
                    <thead>
                        <tr class="align-middle">
                            <th class="opacity-0">vide</th>
                            <th>Title</th>
                            <th>Genre</th>
                            <th>Duration</th>
                            <th>Release Date</th>
                            <th class="opacity-0">list</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                          include 'conixion.php';
                          $result = $con -> query("SELECT * FROM movie_list");
                          foreach($result as $value):
                        ?>
                      <tr class="bg-white align-middle">
                        <td><img src="../assets/img/<?php echo $value['img'] ?>" alt="img" height="50" with="50"></td>
                                <td><?php echo $value['Title'] ?></td>
                                <td><?php echo $value['Genre'] ?></td>
                                <td><?php echo $value['Duration'] ?></td>
                                <td><?php echo $value['ReleaseDate'] ?></td>
                                <td class="d-md-flex gap-3 mt-3">
                                  <a href="modifier.php?Id=<?php echo $value['Id']?>"><i class="far fa-pen"></i></a>
                                  <a href="remove.php?Id=<?php echo $value['Id']?>"><i class="far fa-trash"></i></a>
                                </td>
                        </tr> 

                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <!-- end table -->
        </div>
        <!-- end content page -->
    </main>
    <script src="../js/script.js"></script>
    <script src="../js/bootstrap.bundle.js"></script>
</body>

</html>