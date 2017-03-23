<?php
    require_once('./connect.php');
    Class Nested extends Connect  {
        Public $conn;
        Public $parent;
        Public function __construct(){
            $this->conn = $this->connectDB();
        }
        // CreateDB
        Public function createDB(){
            $createDB = "CREATE DATABASE nested";
            $this->conn->query($createDB);
        }
        // Create Table
        Public function createTable(){
            $createTable = "CREATE TABLE Categories (
                id INT(6) auto_increment Primary Key,
                Category_name Varchar(30) Not Null,
                Category_parent_id INT(6) ,
                Category_left INT(6) ,
                Category_right INT(6) ,
                Category_date TIMESTAMP
                )";
            $this->conn->query($createTable);
        }
        // Drop Table
        Public function DropTable(){
            $dropTable = "DROP Table Categories";
            $this->conn->query($dropTable);
        }
        // Select ($Category_parent_id)
        Public function selectParent($id = 1){
            $selectParent = "SELECT * FROM Categories WHERE Category_parent_id = '$id' ORDER BY Category_left DESC";
            $result = $this->conn->query($selectParent);
            return $result;
        }
        // Select ($id)
        Public function selectID($id){
            $selectID = 'SELECT * FROM Categories WHERE id = '. $id;
            $result = $this->conn->query($selectID);
            $row = $result->fetch_assoc();
            return $row;
        }
        // Select All
        Public function selectAll(){
            $selectAll = 'SELECT * FROM Categories ORDER BY Category_left ASC';
            $result = $this->conn->query($selectAll);
            return $result;
        }
        // Insert (Right)
        Public function insertRight($data , $parent = 0){
            $parentInfo = $this->selectID($parent);
            $parentRight = $parentInfo['Category_right'];

            $updateleft = 'UPDATE Categories SET Category_left = Category_left + 2 WHERE Category_left > '.$parentRight;
            $this->conn->query($updateleft);

            $updateright = 'UPDATE Categories SET Category_right = Category_right + 2 WHERE Category_right >= '.$parentRight;
            $this->conn->query($updateright);

            $left = $parentRight;
            $right = $parentRight + 1;
            $insert = "INSERT INTO Categories (Category_name , Category_parent_id , Category_left , Category_right) VALUES ('$data' , '$parent' , '$left' ,'$right')";
            $this->conn->query($insert);
        }
        // Insert (Left)
        Public function insertLeft($data, $parent = 0){
            $parentInfo = $this->selectID($parent);
            $parentLeft = $parentInfo['Category_left'];

            $updateleft = 'UPDATE Categories SET Category_left = Category_left + 2 WHERE Category_left > '.$parentLeft;
            $this->conn->query($updateleft);

            $updateright = 'UPDATE Categories SET Category_right = Category_right + 2 WHERE Category_right > '.$parentLeft;
            $this->conn->query($updateright);

            $left = $parentLeft + 1;
            $right = $parentLeft + 2;
            $insert = "INSERT INTO Categories (Category_name, Category_parent_id, Category_left, Category_right) VALUES ('$data','$parent','$left','$right')";
            $this->conn->query($insert);
        }
        // Insert After
        Public function insertAfter($data,$parent = 0,$brother = 0){
            $brotherInfo = $this->selectID($brother);

            $updateleft = 'UPDATE Categories SET Category_left = Category_left + 2 WHERE Category_left > '.$brotherInfo['Category_right'];
            $this->conn->query($updateleft);

            $updateright = 'UPDATE Categories SET Category_right = Category_right + 2 WHERE Category_right > '.$brotherInfo['Category_right'];
            $this->conn->query($updateright);

            $left = $brotherInfo['Category_right'] + 1;
            $right = $brotherInfo['Category_right'] + 2;
            $insert = "INSERT INTO Categories (Category_name, Category_parent_id, Category_left, Category_right) VALUES ('$data','$parent','$left','$right')";
            $this->conn->query($insert);
        }
        // InsertBefore
        Public function insertBefore($data,$parent = 0,$brother = 0){
            $brotherInfo = $this->selectID($brother);

            $updateleft = 'UPDATE Categories SET Category_left = Category_left + 2 WHERE Category_left >= '.$brotherInfo['Category_left'];
            $this->conn->query($updateleft);

            $updateright = 'UPDATE Categories SET Category_right = Category_right + 2 WHERE Category_right >= '.($brotherInfo['Category_left'] + 1);
            $this->conn->query($updateright);

            $left = $brotherInfo['Category_left'];
            $right = $brotherInfo['Category_left'] + 1;
            $insert = "INSERT INTO Categories (Category_name, Category_parent_id, Category_left, Category_right ) VALUES ('$data','$parent','$left','$right')";
            $this->conn->query($insert);
        }
        // Remove Branch
        Public function removeBranch($id){
            $removeInfo = $this->selectID($id);
            $removerRight = $removeInfo['Category_right'];
            $removerLeft = $removeInfo['Category_left'];
            $remove = $removerRight - $removerLeft + 1;

            $delete  = "DELETE FROM Categories WHERE Category_left BETWEEN '$removerLeft' AND '$removerRight'";
            $this->conn->query($delete);

            $updateleft = "UPDATE Categories SET Category_left = (Category_left - '$remove') WHERE Category_left > ".$removerRight;
            $this->conn->query($updateleft);

            $updateright = "UPDATE Categories SET Category_right = (Category_right - '$remove') WHERE Category_right >".$removerRight;
            $this->conn->query($updateright);
        }
        // Move (Before)
        Public function moveBefore($id,$parent = 0,$brother = 0){
            $moveInfo = $this->selectID($id);
            $moveLeft = $moveInfo['Category_left'];
            $moveRight = $moveInfo['Category_right'];
            $move = $moveRight - $moveLeft + 1;

            $sqlReset = "UPDATE Categories SET Category_right = (Category_right - '$moveRight') ,
            Category_left = (Category_left - '$moveLeft' ) WHERE Category_left BETWEEN '$moveLeft' AND '$moveRight'";
            $this->conn->query($sqlReset);

            $updateright = "UPDATE Categories SET Category_right = (Category_right - '$move' ) WHERE Category_right > ".$moveRight;
            $this->conn->query($updateright);

            $updateleft = "UPDATE Categories SET Category_left = ( Category_left - '$move' ) WHERE Category_left > ".$moveRight;
            $this->conn->query($updateleft);

            $brotherInfo = $this->selectID($brother);
            $brotherLeft = $brotherInfo['Category_left'];

            $sqlupdateLeft = "UPDATE Categories SET Category_left = (Category_left + '$move') WHERE Category_left >= '$brotherLeft' AND Category_right > 0 ";
            $this->conn->query($sqlupdateLeft);

            $sqlupdateRight = "UPDATE Categories SET Category_right = (Category_right + '$move' ) WHERE Category_right >= ".$brotherLeft;
            $this->conn->query($sqlupdateRight);

            $parentInfo = $this->selectID($parent);
            $newParent = $parentInfo['id'];
            $newLeft = $brotherInfo['Category_left'];
            $newRight = $brotherInfo['Category_left'] + $move - 1;

            $updateParent = "UPDATE Categories SET Category_parent_id = '$newParent' , Category_left = '$newLeft' , Category_right = '$newRight' WHERE id = ".$id;
            $this->conn->query($updateParent);

            $updateNote = "UPDATE Categories SET Category_right = (Category_right + '$newRight') , Category_left = (Category_left + '$newLeft') WHERE Category_right < 0";
            $this->conn->query($updateNote);
        }
        // Move (After)
        Public function moveAfter($id,$parent = 0,$brother = 0){
            $moveInfo = $this->selectID($id);
            $moveLeft = $moveInfo['Category_left'];
            $moveRight = $moveInfo['Category_right'];
            $move = $moveRight - $moveLeft + 1;

            $sqlReset = "UPDATE Categories SET Category_right = (Category_right - '$moveRight') ,
            Category_left = (Category_left - '$moveLeft') WHERE Category_right BETWEEN '$moveLeft' AND '$moveRight'";
            $this->conn->query($sqlReset);

            $updateright = "UPDATE Categories SET Category_right = (Category_right - '$move') WHERE Category_right > ".$moveRight;
            $this->conn->query($updateright);

            $updateleft = "UPDATE Categories SET Category_left = (Category_left - '$move') WHERE Category_left > ".$moveRight;
            $this->conn->query($updateleft);

            $brotherInfo = $this->selectID($brother);
            $brotherRight = $brotherInfo['Category_right'];

            $sqlupdateRight = "UPDATE Categories SET Category_right = (Category_right + '$move') WHERE Category_right > ".$brotherRight;
            $this->conn->query($sqlupdateRight);

            $sqlupdateLeft = "UPDATE Categories SET Category_left = (Category_left + '$move') WHERE Category_left > '$brotherRight' AND Category_right > 0";
            $this->conn->query($sqlupdateLeft);

            $parentInfo = $this->selectID($parent);
            $newParent = $parentInfo['id'];
            $newLeft = $brotherInfo['Category_right'] + 1;
            $newRight = $brotherInfo['Category_right'] + $move;

            $updateParent = "UPDATE Categories SET Category_parent_id = '$newParent', Category_left = '$newLeft', Category_right = '$newRight' WHERE id = ".$id;
            $this->conn->query($updateParent);

            $updateNote = "UPDATE Categories SET Category_right = (Category_right + '$newRight') , Category_left = (Category_left + '$newLeft') WHERE Category_right < 0";
            $this->conn->query($updateNote);
        } // Move (Left)
        Public function moveLeft($id,$parent){
            $moveInfo = $this->selectID($id);
            $moveLeft = $moveInfo['Category_left'];
            $moveRight = $moveInfo['Category_right'];
            $move = $moveRight - $moveLeft + 1;

            $sqlReset = "UPDATE Categories SET Category_right = (Category_right - '$moveRight') , Category_left = (Category_left - '$moveLeft') WHERE Category_left BETWEEN '$moveLeft' AND '$moveRight'";
            $this->conn->query($sqlReset);

            $updateright = "UPDATE Categories SET Category_right = (Category_right - '$move') WHERE Category_right > ".$moveRight;
            $this->conn->query($updateright);

            $updateleft = "UPDATE Categories SET Category_left = (Category_left - '$move') WHERE Category_left > ".$moveRight;
            $this->conn->query($updateleft);

            $parentInfo = $this->selectID($parent);
            $parentLeft = $parentInfo['Category_left'];

            $sqlupdateLeft = "UPDATE Categories SET Category_left = (Category_left + '$move') WHERE Category_left > '$parentLeft' AND Category_right > 0";
            $this->conn->query($sqlupdateLeft);

            $sqlupdateright = "UPDATE Categories SET Category_right = (Category_right + '$move') WHERE Category_right > ".$parentLeft;
            $this->conn->query($sqlupdateright);

            $newParent = $parentInfo['id'];
            $newLeft = $parentInfo['Category_left'] + 1;
            $newRight = $parentInfo['Category_left'] + $move;

            $updateParent = "UPDATE Categories SET Category_parent_id = '$newParent', Category_left = '$newLeft', Category_right = '$newRight' WHERE id = ".$id;
            $this->conn->query($updateParent);

            $updateNote = "UPDATE Categories SET Category_right = (Category_right + '$newRight'), Category_left = (Category_left + '$newLeft') WHERE Category_right < 0";
            $this->conn->query($updateNote);
        }
        // Move (Right)
        Public function moveRight($id,$parent){
            $moveInfo = $this->selectID($id);
            $moveRight = $moveInfo['Category_right'];
            $moveLeft = $moveInfo['Category_left'];
            $move = $moveRight - $moveLeft + 1;

            $sqlReset = "UPDATE Categories SET Category_right = (Category_right - '$moveRight') , Category_left = (Category_left - '$moveLeft') WHERE Category_left BETWEEN '$moveLeft' AND '$moveRight'";
            $this->conn->query($sqlReset);

            $updateright = "UPDATE Categories SET Category_right = (Category_right - '$move') WHERE Category_right > ".$moveRight;
            $this->conn->query($updateright);

            $updateleft = "UPDATE Categories SET Category_left = (Category_left - '$move') WHERE Category_left > ".$moveRight;
            $this->conn->query($updateleft);

            $parentInfo = $this->selectID($parent);
            $parentRight = $parentInfo['Category_right'];

            $sqlupdateRight = "UPDATE Categories SET Category_right = (Category_right + '$move') WHERE Category_right >= ".$parentRight;
            $this->conn->query($sqlupdateRight);

            $sqlupdateLeft = "UPDATE Categories SET Category_left = (Category_left + '$move') WHERE Category_left >= '$parentRight' AND Category_right > 0";
            $this->conn->query($sqlupdateLeft);

            $newParent = $parentInfo['id'];
            $newRight = $parentInfo['Category_right'] + $move - 1;
            $newLeft = $parentInfo['Category_right'];

            $updateParent = "UPDATE Categories SET Category_parent_id = '$newParent', Category_left = '$newLeft' , Category_right = '$newRight' WHERE id =".$id;
            $this->conn->query($updateParent);

            $updateNote = "UPDATE Categories SET Category_right = (Category_right + '$newRight') , Category_left = (Category_left + '$newLeft') WHERE Category_right < 0";
            $this->conn->query($updateNote);
        }
    }
