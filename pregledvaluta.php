<?php
session_start();
$var_value = $_SESSION['user_type'];
  include_once("iwa_2019_vz_projekt.php");
  $veza = spojiSeNaBazu();

  $upit = "SELECT valuta_id,naziv, tecaj, slika, zvuk FROM valuta";
  $rezultat = izvrsiUpit($veza, $upit);
  
  zatvoriVezuNaBazu($veza);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anonimni korisnik</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
<?php include 'header.php';?>
    
    <div class="img-gallery">
      <?php

      $i = 1;
        if(isset($rezultat)){
          echo "<table border=0>";
          while($red = mysqli_fetch_array($rezultat)){
            
            if($i==1){
              echo "<tr>";
            }
            echo "<td style='text-align:center'>";
            echo "<div class='container'><a href='https://www.hnb.hr/' target='_blank'><img src ={$red['slika']}></a>
            <div id='divValutaId{$red["valuta_id"]}' style='display: none;'>
            <div><strong>Valuta:</strong> {$red["naziv"]} </div> 
            <div><strong>Tečaj:</strong> {$red["tecaj"]} </div> 
            </div></div><br>";
            echo '<button id="btnVal'.$red["valuta_id"].'" class="showBtn" style="width:100%" onclick="showInfo('.$red["valuta_id"].','.$red["valuta_id"].','.$red["tecaj"].', \''.$red["zvuk"].'\' )">&nbsp;'.$red["naziv"].'</button>';
            echo "</td>";
            if($i==5){
              $i=0;
              echo "</tr>";
            }

            $i++;

          }
        }
        echo "</table>";
      ?>
    </div>

        
    <script>

  function showInfo(id, naziv, tecaj, anthem){

    if($("#divValutaId"+id).is(":visible")){
      $("#divValutaId"+id).hide();
    }else{

      if(anthem!=""){
        var sound = new Audio(anthem);
      if(sound.paused) {sound.currentTime=0;sound.play()}
                   else  sound.pause();


      }

      $("#divValutaId"+id).show();
    }
  }

  </script>

  
</body>




</html>


