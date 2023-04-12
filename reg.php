<?php

include 'config.php';

if(isset($_POST['submit'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
   $cpass = mysqli_real_escape_string($conn, md5($_POST['cpassword']));
   $image = $_FILES['image']['name'];
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'kepek/'.$image;

   $select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE email = '$email' AND password = '$pass'") or die('A lekérdezés sikertelen!');

   if(mysqli_num_rows($select) > 0){
      $message[] = 'Ez a felhasználó már létezik!'; 
   }else{
      if($pass != $cpass){
         $message[] = 'A jelszavak nem egyeznek!';
      }elseif($image_size > 2000000){
         $message[] = 'A feltöltött kép mérete túl nagy!';
      }else{
         $insert = mysqli_query($conn, "INSERT INTO `user_form`(name, email, password, image) 
         VALUES('$name', '$email', '$pass', '$image')") or die('A lekérdezés sikertelen!');

         if($insert){
            move_uploaded_file($image_tmp_name, $image_folder);
            $message[] = 'Sikeres regisztráció!';
            header('location:bejelentkezes.php');
         }else{
            $message[] = 'Sikertelen regisztráció!';
         }
      }
   }

}
?>


<!DOCTYPE html>
<html lang="hu">
  <head>
    <meta charset="UTF-8">
    <title>SioZoo</title>
    <link rel="stylesheet" href="styles.css">
  </head>
  <body>
    <header>
      <a href="index.html" style="line-height: normal;">
      <img src="kepek/logo.svg" alt="SioZoo" id="logo" width="200" height="200"> </a>
      
      <nav id="linklista">
        <h2><a href="index.html">KEZDŐLAP</a></h2>
        <h2><a href="allatkertunk.html">ÁLLATKERTÜNK</a></h2>
        <h2><a href="latogatas.html">LÁTOGATÁS</a></h2>
        <h2><a href="programok.html">PROGRAMOK</a></h2>
        <h2><a href="kapcsolat.html">KAPCSOLAT</a></h2>
        <h2><a href="fiok.php">FIÓK</a></h2>
      </nav>
      <nav id="belepesregisztracionav">
        <ul id="belepesregisztracionavul">
            <li class="loginandregistration"><a href="bejelentkezes.php" class="belepesregisztracionaa">BELÉPÉS</a></li>
            <li class="loginandregistration"><a href="reg.php" class="belepesregisztracionaa">REGISZTRÁCIÓ</a></li>
           </ul>
      </nav>
    </header>
    <body>
      
    <div class="fiokmain">

<form action="" method="post" enctype="multipart/form-data" class="belepes">
   <h3>Regisztráció</h3>
   <?php
   if(isset($message)){
      foreach($message as $message){
         echo '<div class="message">'.$message.'</div>';
      }
   }
   ?>
   <input type="text" name="name" placeholder="Felhasználónév" class="input" required>
   <input type="email" name="email" placeholder="E-Mail" class="input" required>
   <input type="password" name="password" placeholder="Jelszó" class="input" required>
   <input type="password" name="cpassword" placeholder="Jelszó megerősítése" class="input" required>
   <input type="file" name="image" class="input" accept="image/jpg, image/jpeg, image/png">
   <input type="submit" name="submit" value="Regisztráció" style="background-color:orange;  width: 100%; border-radius: 5px; padding:10px 30px; color:var(--white); display: block; text-align: center; cursor: pointer; font-size: 15px; margin-top: 10px;">
   <p style="margin-top: 0px; font-size: 20px; margin-bottom: 0px;">Már van fiókja?  <a href="bejelentkezes.php" class="marvanfiokja"> Bejelentkezés</a></p>
</form>

</div>

  
    
  </body>
  <footer>
    <p>&copy; 2023 SioZoo</p>
  </footer>
</html>

