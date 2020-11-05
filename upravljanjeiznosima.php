<?php
  session_start();
  $var_value = $_SESSION['user_type'];
  $korisnik_id = $_SESSION['korisnik_id'];
  $korisnickoIme = $_SESSION['ime'];
  include_once("iwa_2019_vz_projekt.php");
  $veza = spojiSeNaBazu();

  $upitAnonimni = "SELECT naziv, tecaj, slika FROM valuta";
  $rezultatAnonimni = izvrsiUpit($veza, $upitAnonimni);
  
 
  $upitKorisnik = "SELECT s.iznos, v.naziv, s.valuta_id, s.sredstva_id FROM sredstva s, valuta v 
  WHERE s.valuta_id=v.valuta_id AND korisnik_id IN ('$korisnik_id')";
  $rezultatKorisnik = izvrsiUpit($veza, $upitKorisnik);
 
  if(isset($_POST['azuriraj'])){
      $azurirajUpit = "UPDATE sredstva SET sredstva_id='$_POST[sredstvaid]', valuta_id='$_POST[valutaid]', iznos='$_POST[iznos]' WHERE sredstva_id='$_POST[hidden]' ";
      mysqli_query($veza,$azurirajUpit);
  }  
  if(isset($_POST['submit'])){
      $dodajRed = "INSERT INTO sredstva (korisnik_id, valuta_id, iznos) VALUES ($_SESSION[korisnik_id],$_POST[valute],$_POST[dodajiznos])";
      izvrsiUpit($veza,$dodajRed);

      $rezultatKorisnik = izvrsiUpit($veza, $upitKorisnik);
  }
  zatvoriVezuNaBazu($veza);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrirani korisnik</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    
</head>
<body style="text-align: -webkit-center">
<?php include 'header.php';?>
    
      <?php
      echo "<h1 style='text-align:center;'>Iznosi korisnika $korisnickoIme</h1>";
      echo "<hr>";
        echo "<table border=1>
        <thead>
            <tr>
              
               <th>Valuta</th>
               <th>Iznos</th>
               <th>Ažuriraj</th>
            </tr>
        </thead>
        ";

        if(isset($rezultatKorisnik)){
            while($red = mysqli_fetch_array($rezultatKorisnik)){
                echo "<form action=upravljanjeiznosima.php method=post>";
                echo "<tr>";
                
                echo "<td>" . "<input type=text disabled required name=valuta value='" . $red['naziv'] . "' </td>";
                echo "<td>" . "<input type=text required name=iznos value=" . $red['iznos'] . " </td>";
                echo "<input type=hidden name=hidden value=" . $red['sredstva_id'] . ">";
                echo "<td>" . "<input type=submit name=azuriraj value=Azuriraj " . " </td>";
                echo "</tr>";
                echo "</form>";
               
            }
              
        }
       
      ?>
      <h2 style="margin-bottom: 20px;">Dodaj iznos</h2>
       <form action=upravljanjeiznosima.php method=post style="border: 3px solid black">
         Valuta:
         <?php
$veza = spojiSeNaBazu();
$getValuteQuery = "SELECT valuta_id, naziv FROM valuta";
$valuteRes = izvrsiUpit($veza, $getValuteQuery);


echo '<select name="valute" id="valute">'; 

$count = 0;
while ($row = mysqli_fetch_array($valuteRes)) {
   echo '<option value="'.$row['valuta_id'].'">'.$row['naziv'].'</option>';
   zatvoriVezuNaBazu($veza);
 
}



echo '</select> <br>';
echo "";
        ?>
         Iznos: <input type="text" name="dodajiznos" style="width: 10%; height: 10px;" required> <br>
          <input type="submit" value="Dodaj" name="submit" id="submit" style="margin-bottom: 20px;" class="dodajiznosbtn">
       </form>


     

   
   






<script>
  function hideEu() {
  var x = document.getElementById("EMU - EUR");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}
function hideUsa() {
  var x = document.getElementById("SAD - USD");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}
function hideCh() {
  var x = document.getElementById("Švicarska - CHF");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}
function hideJp() {
  var x = document.getElementById("Japan - JPY");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}

function hideGb() {
  var x = document.getElementById("Velika Britanija - GBP");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}

function hideHr() {
  var x = document.getElementById("Hrvatska - HRK");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}

var usaAnthem = new Audio('National-Anthem-Of-The-United-States.mp3');
    function generateUsa() {
        
        if(usaAnthem.paused) {usaAnthem.currentTime=0;usaAnthem.play()}
                   else  usaAnthem.pause();
    }

var chAnthem = new Audio('ch.mp3');
    function generateCh() {
        
        if(chAnthem.paused) {chAnthem.currentTime=0;chAnthem.play()}
                   else  chAnthem.pause();
    }

 var jpAnthem = new Audio('Japan.mp3');
    function generateJp() {
        
        if(jpAnthem.paused) {jpAnthem.currentTime=0;jpAnthem.play()}
                   else  jpAnthem.pause();
    }
 </script>

  
</body>




</html>
