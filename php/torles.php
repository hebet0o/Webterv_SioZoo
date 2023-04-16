<?php
      if ($conn->connect_error) {
        die("Sikertelen kapcsolódás az adatbázishoz: " . $conn->connect_error);
      }

      $sql = "DELETE FROM fiokok WHERE id = $id";

     if ($conn->query($sql) === TRUE) {
       echo "A fiók sikeresen törölve lett!";
     } else {
        echo "Hiba történt a fiók törlésekor: " . $conn->error;
     } 
    
    ?>