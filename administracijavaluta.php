<?php
include_once("header.php");
  $var_value = $_SESSION['user_type'];
  $korisnik_id = $_SESSION['korisnik_id'];
  $korisnickoIme = $_SESSION['ime'];
  $var_value = $_SESSION['user_type'];
  include_once("iwa_2019_vz_projekt.php");
  $veza = spojiSeNaBazu();


  $upitKorisnik = "SELECT valuta_id, moderator_id, naziv, tecaj, slika, zvuk, aktivno_od, aktivno_do, 
  datum_azuriranja  FROM valuta ";
  
  $moderatoriUpit = "SELECT korisnik_id, CONCAT(ime, ' ', prezime) AS korisnikime FROM korisnik WHERE tip_korisnika_id = 1 ORDER BY ime, prezime";
  
  $rezultatKorisnik = izvrsiUpit($veza, $upitKorisnik);

if(isset($_POST['azuriraj'])){

  $valutaid=$_POST['valuta_id'];

  $azurirajUpit = "UPDATE valuta SET valuta_id=$_POST[valuta_id], moderator_id=$_POST[moderator_id], naziv='$_POST[naziv]',
  tecaj=$_POST[tecaj], slika='$_POST[slika]', zvuk='$_POST[zvuk]', aktivno_od='$_POST[aktivno_od]', aktivno_do='$_POST[aktivno_do]' WHERE valuta_id = $valutaid";
 
  mysqli_query($veza,$azurirajUpit);

  $rezultatKorisnik = izvrsiUpit($veza, $upitKorisnik);


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
<?php
    echo "<div style =text-align:-webkit-center>";
      echo "<h1 style='text-align:center;'>Pregled valuta</h1>";
      echo "<hr>";
        echo "<table border=2>
        <thead>
            <tr>
               <th>Moderator_ID</th>
               <th>Naziv</th>
               <th>Tecaj</th>
               <th>Slika</th>
               <th>Zvuk</th>
               <th>Aktivno od</th>
               <th>Aktivno do</th>
               <th>Ažuriraj</th>
            </tr>
        </thead>
        ";

        if(isset($rezultatKorisnik)){
            while($red = mysqli_fetch_array($rezultatKorisnik)){
                echo "<form action=administracijavaluta.php method=post>";
                echo "<tr>";
                echo "<td> <select name='moderator_id' id='moderator_id'>"; 

                $moderatori = izvrsiUpit($veza, $moderatoriUpit);
while ($row = mysqli_fetch_array($moderatori)) {

    if($row['korisnik_id'] == $red['moderator_id'])
    echo '<option selected value="'.$row['korisnik_id'].'">'.$row['korisnikime'].'</option>';
    else
   echo '<option value="'.$row['korisnik_id'].'">'.$row['korisnikime'].'</option>';
  
 
}
echo '</select> ';  " </td>";
              
                echo "<td>" . "<input type=text required style=text-align: center;  name=naziv  value='" . $red['naziv'] .  "'></td>";
                echo "<td>" . "<input type=text required style=text-align: center;  name=tecaj  value=" . $red['tecaj'] .  " ></td>";
                echo "<td>" . "<input type=text required style=text-align: center;  name=slika  value=" . $red['slika'] .  " ></td>";
                echo "<td>" . "<input type=text style=text-align: center;  name=zvuk  value=" . $red['zvuk'] .  " ></td>";
                echo "<td>" . "<input type=text required style=text-align: center;  name=aktivno_od  value=" . $red['aktivno_od'] .  " ></td>";
                echo "<td>" . "<input type=text required style=text-align: center;  name=aktivno_do  value=" . $red['aktivno_do'] .  " ></td>";
                echo "<td>" . "<input type=submit name=azuriraj value=Azuriraj  " . " ></td>";
                echo "<input type=hidden name=valuta_id value=" . $red['valuta_id'] . ">";
                echo "<td style=display:none;>" . "<input type=hidden name=hidden value=" . $red['moderator_id'] . " </td>";
                echo "</tr>";
                
                echo "</form>";
               
            }
              
        }
     
      ?>
</body>

