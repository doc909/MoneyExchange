<?php
include_once("header.php");
$var_value = $_SESSION['user_type'];
  $korisnik_id = $_SESSION['korisnik_id'];
  $korisnickoIme = $_SESSION['ime'];
  $var_value = $_SESSION['user_type'];
  include_once("iwa_2019_vz_projekt.php");
  $veza = spojiSeNaBazu();

$upitKorisnik = "SELECT tip_korisnika_id, naziv FROM tip_korisnika";
  
$rezultatKorisnik = izvrsiUpit($veza, $upitKorisnik);

if(isset($_POST['azuriraj'])){
  $azurirajUpit = "UPDATE tip_korisnika SET tip_korisnika_id=$_POST[tip_korisnika_id],
  naziv='$_POST[naziv]' WHERE tip_korisnika_id = $_POST[hidden]  ";
 


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
      echo "<h1 style='text-align:center;'>Pregled vrsta korisnika</h1>";
      echo "<hr>";
        echo "<table border=2>
        <thead>
            <tr>
               <th>Tip korisnika_ID</th>
               <th>Naziv</th>
               <th>Ažuriraj</th>
            </tr>
        </thead>
        ";

        if(isset($rezultatKorisnik)){
            while($red = mysqli_fetch_array($rezultatKorisnik)){
                echo "<form action=administracijavrsta.php method=post>";
                echo "<tr>";
                echo "<td>" . "<input type=text style=text-align: center;  name=tip_korisnika_id value=" . $red['tip_korisnika_id'] .  "> </td>";
                echo "<td>" . "<input type=text style=text-align: center;  name=naziv id=naziv value=" . $red['naziv'] .  " </td>";
                echo "<td>" . "<input type=submit name=azuriraj value=Azuriraj  " . " ></td>";
                echo "<td style=display:none;>" . "<input type=hidden name=hidden value=" . $red['tip_korisnika_id'] . " </td>";
                echo "</tr>";
                
                echo "</form>";
               
            }
              
        }
     
      ?>
</body>
</html>
