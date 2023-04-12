<?php

include 'config.php';
session_start();

if(isset($_POST['submit'])){

   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn, md5($_POST['password']));

   $select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE email = '$email' AND password = '$pass'") or die('A lekérdezés sikertelen!');

   if(mysqli_num_rows($select) > 0){
      $row = mysqli_fetch_assoc($select);
      $_SESSION['user_id'] = $row['id'];
      header('location:fiok.php');
   }
   else{
    $message[] = 'Hibás E-Mail vagy jelszó!';
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
   <h3>Bejelentkezés</h3>
   <?php
   if(isset($message)){
      foreach($message as $message){
         echo '<div class="message">'.$message.'</div>';
      }
   }
   ?>
   <input type="email" name="email" placeholder="E-Mail" class="input" required>
   <input type="password" name="password" placeholder="Jelszó" class="input" required>
   <input type="submit" name="submit" value="Bejelentkezés" class="btn" style="background-color:orange;  width: 100%; border-radius: 5px; padding:10px 30px; color:var(--white); display: block; text-align: center; cursor: pointer; font-size: 15px; margin-top: 10px;">
   <p style="margin-top: 0px; font-size: 20px; margin-bottom: 0px;">Még nincs fiókja?  <a href="reg.php" class="marvanfiokja"> Regisztrálj most!</a></p>
</form>

</div>

  
    
  </body>
  <footer>
    <p>&copy; 2023 SioZoo</p>
  </footer>
</html>

