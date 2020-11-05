<?php
session_start();
  $var_value = $_SESSION['user_type'];
  $korisnik_id = $_SESSION['korisnik_id'];
  $korisnickoIme = $_SESSION['ime'];
$var_value = $_SESSION['user_type'];
include_once("iwa_2019_vz_projekt.php");
  $veza = spojiSeNaBazu();

  $upitKorisnik = "SELECT z.iznos, z.prodajem_valuta_id, z.kupujem_valuta_id, z.datum_vrijeme_kreiranja, prihvacen, v.naziv AS valutakup, vprod.naziv as valutaprod  
  FROM zahtjev z, valuta v , valuta vprod
  WHERE z.kupujem_valuta_id=v.valuta_id AND z.prodajem_valuta_iD = vprod.valuta_id AND korisnik_id IN ('$korisnik_id')";
  $rezultatKorisnik = izvrsiUpit($veza, $upitKorisnik);
  
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
      echo "<h1 style='text-align:center;'>Zahtjevi korisnika $korisnickoIme</h1>";
      echo "<hr>";
        echo "<table border=2>
        <thead>
            <tr>
               <th>Iznos</th>
               <th>Prodajna valuta</th>
               <th>Kupovna valuta</th>
               <th>Datum i vrijeme</th>
               <th>Prihvaćen</th>
            </tr>
        </thead>
        ";

        if(isset($rezultatKorisnik)){
            while($red = mysqli_fetch_array($rezultatKorisnik)){
                echo "<form action=upravljanjeiznosima.php method=post>";
                echo "<tr>";
                echo "<td>" . $red['iznos'] . " </td>";
                echo "<td>" . $red['valutaprod'] . " </td>";
                echo "<td>" . $red['valutakup'] . " </td>";
                echo "<td>" .date_format(date_create($red['datum_vrijeme_kreiranja']),'d.m.Y H:i:s') . " </td>";
                echo "<td>" . $red['prihvacen'] . " </td>";
                echo "</tr>";
                echo "</form>";
               
            }
              
        }
     
      ?>
</body>
</html>
