<?php
session_start();
include_once("header.php");
$err;

$var_value = $_SESSION['user_type'];
include_once("iwa_2019_vz_projekt.php");
  $veza = spojiSeNaBazu();
  date_default_timezone_set('Europe/Zagreb');

  $upit = "SELECT naziv, tecaj, slika FROM valuta";
  $rezultat = izvrsiUpit($veza, $upit);
  
  if(isset($_POST['szahtjeva'])){
    $sum = "SELECT sum(iznos) AS iznos FROM sredstva WHERE korisnik_id = $_SESSION[korisnik_id] AND valuta_id = $_POST[prodajna]";
    $rezultat = izvrsiUpit($veza, $sum);
    $row = mysqli_fetch_array($rezultat);
    if($row['iznos'] < $_POST['iznos']){
        

        $err=true;
    }else
        $err=false;



    if(!$err){

        $date_clicked = date("Y-m-d H:i:s");
        $dodajRed = "INSERT INTO zahtjev (korisnik_id, iznos, prodajem_valuta_id, kupujem_valuta_id, datum_vrijeme_kreiranja, prihvacen) VALUES ($_SESSION[korisnik_id],$_POST[iznos],$_POST[prodajna],$_POST[kupovna],'$date_clicked', 2)";
        izvrsiUpit($veza,$dodajRed);
    
    }
}
if(isset($_POST['szahtjeva']))
{
    $date_clicked = date('d.m.Y H:i:s');
}
  zatvoriVezuNaBazu($veza);




?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mjenjačnica</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    
</head>
<body>
    <header>
        
    </header>
<body>
<form action=slanjezahtjeva.php method=post>
<h2 style="text-align: center;">Slanje zahtjeva</h2>


        <strong> Iznos:</strong> <input type="text" name="iznos" style="width: 20%; height: 10px;" required>
         <br>
         <?php



$veza = spojiSeNaBazu();
$getValuteQuery = "SELECT valuta_id, naziv FROM valuta";
$valuteRes = izvrsiUpit($veza, $getValuteQuery);
echo '<strong>Prodajna</strong>: <select name="prodajna" id="prodajna">';
echo "<br>"; 



$count = 0;
while ($row = mysqli_fetch_array($valuteRes)) {
   echo '<option value="'.$row['valuta_id'].'">'.$row['naziv'].'</option>';
   zatvoriVezuNaBazu($veza);
 echo"<br>";
}


?>
<br>
         Iznos:<input type="text" name="iznoshidden" style="display:none;">
         <?php
$veza = spojiSeNaBazu();
$getValuteQuery = "SELECT valuta_id, naziv FROM valuta";
$valuteRes = izvrsiUpit($veza, $getValuteQuery);
echo '<strong>Kupovna</strong>: <select name="kupovna" id="kupovna">'; 


$count = 0;
while ($row = mysqli_fetch_array($valuteRes)) {
   echo '<option value="'.$row['valuta_id'].'">'.$row['naziv'].'</option>';
   zatvoriVezuNaBazu($veza);
 
}


?>
<?php

echo'<input type=submit name=szahtjeva value="Dodaj" id="szahtjeva">';

if(isset($err)){
    if($err){
        echo "</br><p style='color: red;'>Iznos koji prodajete ne može biti veći od trenutnog iznosa kojim raspolažete!</p>";
    } else {
        echo "</br><p style='color: green;'>Zahtjev je uspješno poslan!</p>";
    }

} 

?>
</form>
</body>
</html>