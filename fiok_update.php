<?php
include 'config.php';
session_start();

$user_id = $_SESSION['user_id'];

if(isset($_POST['update_profile'])){

    $update_name = mysqli_real_escape_string($conn, $_POST['update_name']);
    $update_email = mysqli_real_escape_string($conn, $_POST['update_email']);
 
    mysqli_query($conn, "UPDATE `user_form` SET name = '$update_name', email = '$update_email' WHERE id = '$user_id'") or die('A lekérdezés sikertelen!');
 
    $old_pass = $_POST['old_pass'];
    $update_pass = mysqli_real_escape_string($conn, md5($_POST['update_pass']));
    $new_pass = mysqli_real_escape_string($conn, md5($_POST['new_pass']));
    $confirm_pass = mysqli_real_escape_string($conn, md5($_POST['confirm_pass']));
 
    if(!empty($update_pass) || !empty($new_pass) || !empty($confirm_pass)){
       if($update_pass != $old_pass){
          $message[] = 'Régi jelszó nem egyezik!';
       }elseif($new_pass != $confirm_pass){
          $message[] = 'Megerősítő jelszó nem egyezik!';
       }else{
          mysqli_query($conn, "UPDATE `user_form` SET password = '$confirm_pass' WHERE id = '$user_id'") or die('A lekérdezés sikertelen!');
          $message[] = 'Jelszava sikeresen megváltozott!';
       }
    }
 
    $update_image = $_FILES['update_image']['name'];
    $update_image_size = $_FILES['update_image']['size'];
    $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
    $update_image_folder = 'kepek/'.$update_image;
 
    if(!empty($update_image)){
       if($update_image_size > 2000000){
          $message[] = 'A kép túl nagy!';
       }else{
          $image_update_query = mysqli_query($conn, "UPDATE `user_form` SET image = '$update_image' WHERE id = '$user_id'") or die('A lekérdezés sikertelen!');
          if($image_update_query){
             move_uploaded_file($update_image_tmp_name, $update_image_folder);
          }
          $message[] = 'Profilképe sikeresen megváltozott!';
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
    <main class="fiokmain">
    <div class="update-profile">
    <?php
    $select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE id = '$user_id'") or die('A lekérdezés sikertelen!');
    if(mysqli_num_rows($select) > 0){
        $fetch = mysqli_fetch_assoc($select);
    }
    
    ?>
  <div class="fiokupdate_body">
  <form action="" method="post" enctype="multipart/form-data">
        <?php
        if($fetch['image'] == ''){
            echo '<img src="kepek/default-avatar.png">';
          }
          else{
            echo '<img src="kepek/'.$fetch['image'].'">';
          }
        
        ?>
    <div class="flex">
        <div class="inputBox">
            <span>Felhasználónév: </span>
            <input type="text" name="update_name" value="<?php echo $fetch['name']?>" class="box">

            <span>E-Mail: </span>
            <input type="email" name="update_email" value="<?php echo $fetch['email']?>" class="box">

            <span>Kép megváltoztatása: </span>
            <input type="file" name="update_image" accept="image/jpg, image/jpeg, image/png" class="box">
        </div>
        <div class="inputBox">
        <input type="hidden" name="old_pass" value="<?php echo $fetch['password']?>">
        <span>Régi jelszó: </span>

        <input type="password" name="update_pass" placeholder="Adja meg régi jelszavát " class="box">

        <span>Új jelszó: </span>

        <input type="password" name="new_pass" placeholder="Adja meg új jelszavát " class="box">

        <span>Új jelszó mégegyszer: </span>

        <input type="password" name="confirm_pass" placeholder="Adja meg új jelszavát " class="box">
        </div>
    </div>
    
    <?php
    if(isset($_POST['delete_profile'])){

      $mail = $_POST['update_email'];
      mysqli_query($conn, "DELETE FROM `user_form` WHERE email = '$mail'");
      $message[] = 'Fiókja sikeresen törlődött!';
      session_destroy();
      header('location:bejelentkezes.php');
    }
    ?>
    
    <input type="submit" value="Profil frissítése" name="update_profile" class="fiokbtnUpdate">
    <button href="fiok.php" id="torles" class="fiokbtnUpdate" name="delete_profile">Profil törlése</button>
    <button href="fiok.php" class="fiokbtnUpdate">Vissza</button>
    </form>
    </div>
  </div>
    
    </main>
  </body>
  <footer>
    <p>&copy; 2023 SioZoo</p>
  </footer>
</html>