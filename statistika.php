<?php
session_start();
$var_value = $_SESSION['user_type'];
include_once("iwa_2019_vz_projekt.php");
  $veza = spojiSeNaBazu();
  $var_value = $_SESSION['user_type'];
  $korisnik_id = $_SESSION['korisnik_id'];
  $korisnickoIme = $_SESSION['ime'];


  $datumod="";
  $datumdo="";
  $moderatorid=0;

  include_once("header.php");

  $upitModerator = "SELECT korisnik_id, CONCAT(ime,' ', prezime)as korisnik_naziv FROM korisnik WHERE tip_korisnika_id=1 ORDER BY ime, prezime";
  
  $rezultatModerator = izvrsiUpit($veza, $upitModerator);


  if(isset($_POST['dohvati'])){

    $datumod=$_POST['datum_od'];
    $datumdo=$_POST['datum_do'];
    $moderatorid=$_POST['moderator'];
    
    $query = "SELECT v.naziv, sum(z.iznos) as iznos FROM `zahtjev` z 
    inner join valuta v ON v.valuta_id = z.prodajem_valuta_id 
    WHERE prihvacen=1 AND v.moderator_id=".$_POST['moderator'] ;
    $query = $query." AND datum_vrijeme_kreiranja BETWEEN '".$_POST['datum_od']."' AND '".$_POST['datum_do']."'";
    $query = $query." GROUP BY v.naziv ORDER BY iznos DESC;";

    $rezultatStatistika = izvrsiUpit($veza, $query);
  }



  ?>
  <!DOCTYPE html>
  <html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      
  </head>
  <body>
  <?php
      echo "<form action=statistika.php method=post>";

echo "<div style =text-align:-webkit-center>";
      echo "<h1 style='text-align:center;'>Statistika prodaje</h1>";
      echo "<hr>";

      echo "<table>";
      echo "<tr><td>Moderator:</td><td><select name='moderator'>";

      if(isset($rezultatModerator)){
        while($red = mysqli_fetch_array($rezultatModerator)){

            echo "<option value=".$red['korisnik_id'];

           if($moderatorid==$red['korisnik_id']){
                echo " selected ";
            }
                


            echo ">".$red['korisnik_naziv']."</option>";
        }
      }

      echo "</select></td></tr>";
      echo "<tr><td>Datum od:</td><td><input type='text' required name='datum_od' value='".$datumod."'></td></tr>";
      echo "<tr><td>Datum do:</td><td><input type='text' required name='datum_do' value='".$datumdo."'></td></tr>";
      echo "<tr><td colspan=2><input type='submit' value='Dohvati' name='dohvati'></td></tr>";
      echo "<tr><td colspan=2>&nbsp;</td></tr>";
      echo "</table>";
      echo "<table>";
        echo "<table border=2>
        <thead>
            <tr>
               <th>Valuta</th>
               <th>Iznos</th>
            </tr>
        </thead>
        
        ";
        $total=0;
        if(isset($rezultatStatistika)){
            while($red = mysqli_fetch_array($rezultatStatistika)){
               
                echo "<tr>";
                echo "<td>".$red['naziv']."</td>";
                echo "<td style='text-align:right'>".$red['iznos']."</td>";
                echo "</tr>";
                
                $total = $total+$red['iznos'];
               
            }
              
        }
        echo "<tfoot>";
        echo "<tr>";
        echo "<td>Ukupno:</td><td style='text-align:right'>".$total."</td>";
        echo "</tr>";
        echo "</tfoot>";
        echo "</form>";
      ?>
  </body>
  </html>