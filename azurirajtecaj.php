<?php
include_once("header.php");
include_once("iwa_2019_vz_projekt.php");
$veza = spojiSeNaBazu();
$korisnik_id = $_SESSION['korisnik_id'];
  $upit = "SELECT * FROM valuta WHERE moderator_id = $korisnik_id;";
  $rezultat = izvrsiUpit($veza, $upit);
  
  if(isset($_POST['azuriraj'])){
    $err;
    $tecaj = $_POST['tecaj'];   
    $valutaid = $_POST['valuta_id'];
    $date = date("Y-m-d");
    
if($date == $_POST["datum_azuriranja"]){
    $err = "Samo jednom dnevno moguće ažuriranje tečaja!";
}

    if(!isset( $err)){
      $azurirajUpit ="UPDATE valuta SET tecaj=$tecaj, datum_azuriranja = '$date'  WHERE valuta_id=$valutaid;";
      mysqli_query($veza,$azurirajUpit);

      $rezultat = izvrsiUpit($veza, $upit);
    }
 
}  

  zatvoriVezuNaBazu($veza);
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
      echo "<h1 style='text-align:center;'>Ažuriranje tečaja</h1>";

      if(isset($err) ){
        echo "<div style=color:red>$err</div>";
        $err = null;
      }

      echo "<hr>";
        echo "<table border=1>
        <thead>
            <tr>
               <th>Valuta</th>
               <th>Tečaj</th>
               <th>Datum ažuriranja</th>
               <th>Ažuriraj</th>
            </tr>
          
        </thead>
        ";

        if(isset($rezultat)){
        
            while($red = mysqli_fetch_array($rezultat)){
              
              

                echo "<form action=azurirajtecaj.php method=post>";
 
                  echo "<tr>";
   
            
                echo "<td>"   . $red['naziv'] . " </td>";
                echo "<td>" . "<input type=number required style=width:75% name=tecaj step =0.000001 value=" . $red['tecaj'].'>' ;
                echo "<td>" .date_format(date_create($red['datum_azuriranja']),'d.m.Y H:i:s') . " </td>";

                echo  "</td>";
                echo "<input type=hidden name=valuta_id value=" . $red['valuta_id'] . ">";
                echo "<input type=hidden name=datum_azuriranja value=" . $red['datum_azuriranja'] . ">";
                echo "<td>" . "<input type=submit name=azuriraj value=Azuriraj  " . " </td>";
                echo "</tr>";
                echo "</form>";
               
            }
              
        }
     
      ?>
</body>
</html>