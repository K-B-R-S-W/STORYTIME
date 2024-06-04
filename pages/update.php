<?php
session_start();
$id = $_SESSION['id'];
include 'conixion.php';
if (isset($_POST['submit'])){
    $Title = $_POST['Title'];
    $Genre = $_POST['Genre'];
    $Duration = $_POST['Duration'];
    $ReleaseDate = $_POST['ReleaseDate'];
    $requete = $con -> prepare("UPDATE movie_list 
    SET 
    Title = '$Title',
    Genre = '$Genre',
    Duration = '$Duration',
    ReleaseDate = '$ReleaseDate'
    WHERE Id = $id");
    $res = $requete -> execute();
    header("location:movie_list.php");
}
?>