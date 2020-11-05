<?php
session_start();
$var_value = $_SESSION['user_type'];
include_once("iwa_2019_vz_projekt.php");
  $veza = spojiSeNaBazu();
  $var_value = $_SESSION['user_type'];
  $korisnik_id = $_SESSION['korisnik_id'];
  $korisnickoIme = $_SESSION['ime'];
  
 
  


  $upitKorisnik = "SELECT z.zahtjev_id, z.korisnik_id, z.iznos, z.prodajem_valuta_id, z.kupujem_valuta_id, z.datum_vrijeme_kreiranja, prihvacen ,
    vkup.naziv AS nazivvkup, vprod.naziv AS nazivprod, CONCAT (k.ime, ' ', k.prezime) AS korisnikime, vprod.aktivno_od, vprod.aktivno_do
  FROM zahtjev z, valuta vkup, valuta vprod, korisnik k 
  WHERE z.kupujem_valuta_id=vkup.valuta_id AND z.prodajem_valuta_id=vprod.valuta_id AND z.korisnik_id = k.korisnik_id ";

  if($_SESSION['user_type']==1)
    $upitKorisnik = $upitKorisnik." AND (vkup.moderator_id = $korisnik_id OR vprod.moderator_id=$korisnik_id)";

  $rezultatKorisnik = izvrsiUpit($veza, $upitKorisnik);

  if(isset($_POST['azuriraj'])){
    $err;
    $prihvacen = $_POST['prihvacen'];   
    $zahtjevid = $_POST['hidden'];
    $kupujemvaluta = $_POST['kupujem_valuta_id'];
    $iznos = $_POST['iznos'];
    
    $start = strtotime(date('Y-m-d').' '.$_POST['aktivno_od']);
    $end = strtotime(date('Y-m-d').' '.$_POST['aktivno_do']);

  if(time() >= $start && time() <= $end) {
    
    $err = null;
  } else {
    
    $err ="Vrijeme nije u rasponu definiranom od strane administratora!";
  }

    if(!isset( $err)){
      $azurirajUpit ="UPDATE zahtjev SET prihvacen=$prihvacen WHERE zahtjev_id=$zahtjevid;";
      mysqli_query($veza,$azurirajUpit);
      if($prihvacen == 1){
      $azurirajUpit = "INSERT INTO sredstva (valuta_id, korisnik_id, iznos) VALUES ($kupujemvaluta, $korisnik_id, $iznos);";
      mysqli_query($veza,$azurirajUpit);
      }

      $rezultatKorisnik = izvrsiUpit($veza, $upitKorisnik);
    }
 
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
    <?php
    echo "<div style =text-align:-webkit-center>";
      echo "<h1 style='text-align:center;'>Zahtjevi svih korisnika</h1>";

      if(isset($err) ){
        echo "<div style=color:red>$err</div>";
        $err = null;
      }

      echo "<hr>";
        echo "<table border=1>
        <thead>
            <tr>
            <th>Zahtjev_ID</th>
               <th>Korisnik_ID</th>
               <th>Iznos</th>
               <th>Prodajna valuta_ID</th>
               <th>Kupovna valuta_ID</th>
               <th>Datum i vrijeme</th>
               <th>Prihvaćen</th>
               <th>Ažuriraj</th>
            </tr>
          
        </thead>
        ";

        if(isset($rezultatKorisnik)){
          $isOk = false;
            while($red = mysqli_fetch_array($rezultatKorisnik)){
              $start1 = strtotime(date('Y-m-d').' '.$red['aktivno_od']);
              $end1 = strtotime(date('Y-m-d').' '.$red['aktivno_do']);
              

                echo "<form action=pregledsvihzahtjeva.php method=post>";
                if(time() >= $start1 && time() <= $end1) {
                  echo "<tr style=background-color:#32CD32>";
                }                 
                else{
                  echo "<tr>";
                }

                
                echo "<td>"   . $red[0] . " </td>";
                echo "<td>"   . $red['korisnikime'] . " </td>";
                echo "<td>" .  $red['iznos'] . " </td>";
                echo "<td>"  . $red['nazivprod'] . " </td>";
                echo "<td>" . $red['nazivvkup'] . " </td>";
                echo "<td>" .date_format(date_create($red['datum_vrijeme_kreiranja']),'d.m.Y H:i:s') . " </td>";
                echo "<td>" . "<input type=text style=width:25% name=prihvacen required value=" . $red['prihvacen'].' onblur="javascript: return validateStastus(this);">' ;

                echo  "</td>";
                echo "<input type=hidden name=hidden value=" . $red['zahtjev_id'] . ">";
                echo "<input type=hidden name=kupujem_valuta_id value=" . $red['kupujem_valuta_id'] . ">";
                echo "<td style=display:none;>" . "<input type=hidden name=iznos value=" . $red['iznos'] . " </td>";
                echo "<td style=display:none;>" . "<input type=hidden name=aktivno_od value=" .$red['aktivno_od'] . " </td>";
                echo "<td style=display:none;>" . "<input type=hidden name=aktivno_do value=" . $red['aktivno_do'] . " </td>";
                echo "<td>" . "<input type=submit name=azuriraj value=Azuriraj  " . " </td>";
                echo "</tr>";
                echo "</form>";
               
            }
              
        }
     
      ?>

      <script>
      function validateStastus(obj){
       if(obj.value<0 || obj.value>2){
         alert("Pogrešan status. Upišite 0, 1 ili 2");
         
        return false;
       }
       return true;
        
      }
      
      </script>
</body>