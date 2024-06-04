<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
  <?php
    session_start();
    include 'conixion.php';
    $_SESSION["id"]= $_GET['Id'];
    $id = $_SESSION["id"];
    $statement = $con -> prepare("SELECT * FROM movie_list WHERE Id = $id");
    $statement->execute();
    $table = $statement -> fetch();

  ?>
<div class="container w-50">


<form method="POST" action="update.php" enctype="multipart/form-data">
                                  <div class="">
                                    <label for="recipient-name" class="col-form-label">img:</label>
                                    <input type="file" class="form-control" id="recipient-name" accept=".jpg,.png,.jpeg" name="img">
                                  </div>
                                  <div class="">
                                    <label for="recipient-name" class="col-form-label">Title:</label>
                                    <input type="text" class="form-control" id="recipient-name" name="Title" value="<?php echo $table['Title']?>">
                                  </div>
                                  <div class="">
                                    <label for="recipient-name" class="col-form-label">Genre:</label>
                                    <input type="text" class="form-control" id="recipient-name" name="Genre" value="<?php echo $table['Genre']?>">
                                  </div>
                                  <div class="">
                                    <label for="recipient-name" class="col-form-label">Duration:</label>
                                    <input type="text" class="form-control" id="recipient-name" name="Duration" value="<?php echo $table['Duration']?>">
                                  </div>
                                  <div class="">
                                    <label for="recipient-name" class="col-form-label">Release Date:</label>
                                    <input type="date" class="form-control" id="recipient-name" name="ReleaseDate" value="<?php echo $table['ReleaseDate']?>">
                                  </div>
                                  <div class="modal-footer">
                                <button type="submit" name="submit" class="btn btn-primary">Update movie</button>
                              </div>
                                </form>
</div>
    <script src="../js/script.js"></script>
    <script src="../js/bootstrap.bundle.js"></script>
</body>
</html>