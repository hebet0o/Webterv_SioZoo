<?php

include 'config.php';
session_start();
$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
  header('location:bejelentkezes.php');
};

if(isset($_GET['kijelentkezes'])){
  unset($user_id);
  session_destroy();
  header('location:bejelentkezes.php');
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
    
    <div class="profile">
    <?php
    $select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE id = '$user_id'") or die('A lekérdezés sikertelen!');
    if(mysqli_num_rows($select) > 0){
        $fetch = mysqli_fetch_assoc($select);
    }
    if($fetch['image'] == ''){
      echo '<img src="kepek/default-avatar.png">';
    }
    else{
      echo '<img src="kepek/'.$fetch['image'].'">';
    }
    
    ?>
    <h2 style="text-align: center;"><?php echo $fetch['name'];?></h2>
    <a href="fiok_update.php" class="btn">
    Fiók szerkesztése</a>
    <a href="fiok.php?kijelentkezes=<?php echo $user_id;?>" class="btn">
    Kijelentkezés</a>
    </div>


  </div>
  </body>
  <footer>
    <p>&copy; 2023 SioZoo</p>
  </footer>
</html>