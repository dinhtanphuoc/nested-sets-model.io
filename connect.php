<?php

    Class Connect {
        Public function connectDB(){
            $servername = "localhost";
            $username = "root";
            $password = "l0v3k3n";
            $dbname = "nested";
            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);
            // Check connection
            // if ($conn->connect_error) {
            //     die("Connection failed: " . $conn->connect_error);
            // }
            // echo "Connected successfully <br /><br />";
            return $conn;
        }
    }
