<?php include('conn.php'); ?>


<?php

    if(isset($_GET['id'])){
        $id = $_GET['id'];
    
    $query = "delete from `sample` where `id` = '$id'";
    $result = mysqli_query($conn, $query);

    if(!$result){
        die("QUERY FAILED." . mysqli_error($conn));
    }
    else{
        header('location:index.php?delete_msg=Data is deleted successfully');
    }

}

?>