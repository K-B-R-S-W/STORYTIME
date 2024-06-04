<?php 
    include 'conixion.php';
    $id = $_GET['Id'];

    if(isset($id)){
        $stmt = $con ->prepare("DELETE FROM movie_list WHERE Id=$id");
        $stmt -> execute();

    }
    header('location:movie_list.php');
?>