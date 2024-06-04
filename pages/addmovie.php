<?php 
    include 'conixion.php';
    if(isset($_POST['submit'])){
        
        $image = $_FILES['img']['name'];
        $tempname = $_FILES['img']['tmp_name'];  
        $folder = "../assets/img/".$image;
        
        if(move_uploaded_file($tempname,$folder)){
            echo 'images est uplade';
        }

        $Title = $_POST['Title'];
        $Genre = $_POST['Genre'];
        $Duration = $_POST['Duration'];
        $ReleaseDate = $_POST['ReleaseDate'];

        $requete = $con->prepare("INSERT INTO movie_list(img,Title,Genre,Duration,ReleaseDate) VALUES('$image','$Title','$Genre','$Duration','$ReleaseDate')");
        //$requete->execute(array($image,$Title,$Genre,$Duration,$ReleaseDate));
        $requete->execute();
    }
    header('location:movie_list.php')
    ?>