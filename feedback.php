<?php 
include 'conixion.php';
include 'connectionn.php';

if (isset($_POST['submit'])) {
    $Name = $_POST['Name'];
    $Email = $_POST['Email'];
    $Description = $_POST['Description'];
    $Phonenumber = $_POST['Phonenumber'];

    try {
        $requete = $con->prepare("INSERT INTO feedback(Name, Email, Description, Phonenumber) VALUES (?, ?, ?, ?)");
        $requete->bindParam(1, $Name);
        $requete->bindParam(2, $Email);
        $requete->bindParam(3, $Description);
        $requete->bindParam(4, $Phonenumber);
        $requete->execute();
        // Redirect on success
        header('location: contatus.php');
        exit;
    } catch (Exception $e) {
        // Handle the error gracefully, e.g., log it and show an error message
        echo "An error occurred: " . $e->getMessage();
    }
}


    ?>