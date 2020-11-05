<?php
session_start();
  $var_value = $_SESSION['user_type'];
  $korisnik_id = $_SESSION['korisnik_id'];
  $korisnickoIme = $_SESSION['ime'];
  $var_value = $_SESSION['user_type'];
  include_once("iwa_2019_vz_projekt.php");
  $veza = spojiSeNaBazu();

  $upitKorisnik = "SELECT k.korisnik_id, k.tip_korisnika_id, korisnicko_ime, lozinka, ime, prezime, email, slika FROM korisnik k, tip_korisnika t
  WHERE k.tip_korisnika_id=t.tip_korisnika_id";
  $rezultatKorisnik = izvrsiUpit($veza, $upitKorisnik);

  if(isset($_POST['azuriraj'])){
    $azurirajUpit = "UPDATE korisnik SET tip_korisnika_id=$_POST[tip_korisnika_id],
    korisnicko_ime='$_POST[korisnicko_ime]', lozinka = '$_POST[lozinka]', ime ='$_POST[ime]', 
    prezime ='$_POST[prezime]',
    email ='$_POST[email]', slika ='$_POST[slika]'
    WHERE korisnik_id = $_POST[korisnik_id]";
     
     
    
    mysqli_query($veza,$azurirajUpit);

    $rezultatKorisnik = izvrsiUpit($veza, $upitKorisnik);
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
<?php include 'header.php';?>
    
<body>
<?php
    echo "<div style =text-align:-webkit-center>";
      echo "<h1 style='text-align:center;'>Pregled korisnika</h1>";
      echo "<hr>";
        echo "<table border=2>
        <thead>
            <tr>
               <th>Tip korisnika_ID</th>
               <th>Korisničko ime</th>
               <th>Lozinka</th>
               <th>Ime</th>
               <th>Prezime</th>
               <th>Email</th>
               <th>Slika</th>
               <th>Ažuriraj</th>
            </tr>
        </thead>
        ";

        if(isset($rezultatKorisnik)){
            while($red = mysqli_fetch_array($rezultatKorisnik)){
                echo "<form action=adminkorisnika.php method=post>";
                echo "<tr>";
                echo "<td>" . "<input type=text required style=text-align: center;  name=tip_korisnika_id value=" . $red['tip_korisnika_id'] .  "> </td>";
                echo "<td>" . "<input type=text required style=text-align: center;  name=korisnicko_ime id=korisnicko_ime value=" . $red['korisnicko_ime'] .   "> </td>";
                echo "<td>" . "<input type=text required style=text-align: center;  name=lozinka id=korisnicko_ime value=" . $red['lozinka'] .  " ></td>";
                echo "<td>" . "<input type=text required style=text-align: center;  name=ime id=ime value=" . $red['ime'] .  "> </td>";
                echo "<td>" . "<input type=text required style=text-align: center;  name=prezime value=" . $red['prezime'] .  " ></td>";
                echo "<td>" . "<input type=text required style=text-align: center;  name=email id=email value=" . $red['email'] .  " ></td>";
                
                if($red['slika']!=""){
                  echo "<td>" . "<img src='".$red['slika']."'></td>";
                }else{
                  echo "<td>nema slike</td>";
                }
                
                echo "<td>" . "<input type=submit name=azuriraj value=Azuriraj  " . " ></td>";
                echo "<input type=hidden name=korisnik_id value=" . $red['korisnik_id'] . ">";
                echo "<td style=display:none;>" . "<input type=hidden name=hidden value=" . $red['tip_korisnika_id'] . " </td>";
                echo "</tr>";
                
                echo "</form>";
               
            }
              
        }
     
      ?>
</body>
</html>
