<?php
include 'conn.php';
if(isset($_POST['add_students'])){
    

    $firstName = $_POST['fname'];
    $lastName = $_POST['lname'];
    $contactNumber = $_POST['cnumber'];


    if($firstName == "" || empty($firstName)){
        header('location:index.php? message=You need to fill in the first name!');
    }
    elseif($lastName == "" || empty($lastName)){
        header('location:index.php? message=You need to fill in the last name!');
    }
    elseif($contactNumber == "" || empty($contactNumber)){
        header('location:index.php? message=You need to fill in the contact number!');
    }
    else{


        $query= "INSERT INTO  `sample` (`firstName`, `lastName`, `contactNumber`) 
                 VALUES ('$firstName', '$lastName', '$contactNumber')";

        $result = mysqli_query($conn,$query);

        if(!$result){   
            die("Query Failed!" . mysqli_error($conn));
        }
        else{
            header('location:index.php?insert_msg=Your data has been added successfully');
        }
    }
}

?>

