<?php
include_once("header.php");
  $var_value = $_SESSION['user_type'];
  $korisnik_id = $_SESSION['korisnik_id'];
  include_once("iwa_2019_vz_projekt.php");
  $veza = spojiSeNaBazu();

  if(isset($_POST['submit'])){
    $dodajRed = "INSERT INTO korisnik (tip_korisnika_id, korisnicko_ime, lozinka, ime, prezime, email, slika) 
    VALUES ($_POST[tip_korisnika], '$_POST[korime]', '$_POST[lozinka]', '$_POST[ime]', '$_POST[prezime]', '$_POST[email]',
    '$_POST[slika]')";
    echo $dodajRed;
    izvrsiUpit($veza,$dodajRed);
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

       <form action=dodajkorisnika.php method=post style="border: 3px solid black">
       <h2 style="text-align:center">Dodaj korisnika</h2>
       <hr>
       <?php
$veza = spojiSeNaBazu();
$getValuteQuery = "SELECT tip_korisnika_id, naziv FROM tip_korisnika";
$valuteRes = izvrsiUpit($veza, $getValuteQuery);


echo 'Tip korisnika: <select name="tip_korisnika" id="tip_korisnika">'; 

$count = 0;
while ($row = mysqli_fetch_array($valuteRes)) {
   echo '<option value="'.$row[ tip_korisnika_id].'">'.$row['naziv'].'</option>';
   zatvoriVezuNaBazu($veza);
 
}
echo '</select> <br>';

        ?>
        <strong> Korisničko ime:</strong> <input type="text" name="korime" style="width: 40%; height: 10px;" required > <br>
        <strong>Lozinka:</strong> <input type="text" name="lozinka" style="width: 40%; height: 10px;" required > <br>
        <strong>Ime:</strong> <input type="text" name="ime" style="width: 40%; height: 10px;" required > <br>
        <strong>Prezime:</strong> <input type="text" name="prezime" style="width: 40%; height: 10px;" required > <br>
        <strong> Email:</strong> <input type="text" name="email" style="width: 40%; height: 10px;" required > <br>
        <strong> Slika:</strong> <input type="text" name="slika" style="width: 40%; height: 10px;"> <br>
          <input type="submit" value="Dodaj" name="submit" id="submit" style="margin-bottom: 20px;" class="dodajiznosbtn">
       </form>




</body>