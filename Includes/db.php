<?php 

        $con = mysqli_connect("localhost","root","root","farming");
      
        if (mysqli_connect_errno()) {
                echo "Failed to connect to MySql " . mysqli_connect_error();
        }
