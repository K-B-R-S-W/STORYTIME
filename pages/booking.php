<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>STORYTIME</title>
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
            <div class="booking">
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Book</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                <form method="POST" action="" enctype="multipart/form-data">
                                  
                                  <div class="">
                                    <label for="recipient-name" class="col-form-label">Movie:</label>
                                    <input type="text" class="form-control" id="recipient-name" name="Movie">
                                  </div>
                                  <div class="">
                                    <label for="recipient-name" class="col-form-label">Name:</label>
                                    <input type="text" class="form-control" id="recipient-name" name="Name">
                                  </div>
                                  <div class="">
                                    <label for="recipient-name" class="col-form-label">Phonenumber:</label>
                                    <input type="text" class="form-control" id="recipient-name" name="Phonenumber">
                                  </div>
                                  <div class="">
                                    <label for="recipient-name" class="col-form-label">Date:</label>
                                    <input type="text" class="form-control" id="recipient-name" name="Date">
                                  </div>
                                  <div class="">
                                    <label for="recipient-name" class="col-form-label">Time:</label>
                                    <input type="text" class="form-control" id="recipient-name" name="Time">
                                  </div>
                                  <div class="">
                                    <label for="recipient-name" class="col-form-label">Ordernumber:</label>
                                    <input type="text" class="form-control" id="recipient-name" name=";Ordernumber">
                                  </div>
                                  <div class="">
                                    <label for="recipient-name" class="col-form-label">Amount:</label>
                                    <input type="text" class="form-control" id="recipient-name" name="Amount">
                                  </div>
                                  <div class="modal-footer">
                              </div>
                                </form>
                              </div>
                            </div>
                          </div>
                        </div>
                    </div>
                <div class="booking">
                    <table class="table table-responsive">
                        <thead>
                            <th>Movie</th>
                            <th>Name</th>
                            <th>Phonenumber</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Ordernumber</th>
                            <th>Amount</th>
                        </thead>
                        <tbody> 
                        <?php include 'conixion.php'; 
                                $requete = "SELECT * FROM booking";
                                $result = $con -> query($requete);

                                foreach($result as $value):
                            ?>

                            <tr> 
                                <td><?php echo $value['Movie'] ?></td>
                                <td><?php echo $value['Name'] ?></td>
                                <td><?php echo $value['Phonenumber'] ?></td>
                                <td><?php echo $value['Date'] ?></td>
                                <td><?php echo $value['Time'] ?></td>
                                <td><?php echo $value['Ordernumber'] ?></td>
                                <td><?php echo $value['Amount'] ?></td>
                            </tr>
                            
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            
            </div>
               
        </div>
        <!-- end content page -->
    </main>

    <script src="../js/script.js"></script>
    <script src="../js/bootstrap.bundle.js"></script>
</body>
</html>