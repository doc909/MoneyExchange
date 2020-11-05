<?php
include_once("header.php");
  $err=null;
  $var_value = $_SESSION['user_type'];
  $korisnik_id = $_SESSION['korisnik_id'];
  include_once("iwa_2019_vz_projekt.php");
  $veza = spojiSeNaBazu();

  if(isset($_POST['submit'])){


    $getValuta ="SELECT * FROM valuta WHERE naziv = '$_POST[naziv]';";
    $rezultatValuta = izvrsiUpit($veza, $getValuta);
    
    if(isset($rezultatValuta) && mysqli_num_rows ( $rezultatValuta )>=1){
      $err="Valuta već postoji!";

    }
    if(!isset($err)){
      $aktivnoOd= $_POST['aktivno_od'];
      $aktivnoDo= $_POST['aktivno_do'];  
      $dodajRed = "INSERT INTO valuta (moderator_id, naziv, tecaj, slika, zvuk, aktivno_od, aktivno_do) 
      VALUES ($_POST[moderator_id], '$_POST[naziv]', '$_POST[tecaj]', '$_POST[slika]', '$_POST[zvuk]', '$aktivnoOd', '$aktivnoDo')";
      
      izvrsiUpit($veza,$dodajRed);
      
      header("Location: pregledvaluta.php");
      exit();

    }


}
zatvoriVezuNaBazu($veza);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>Document</title>
</head>
<body>

       <form action=dodajvalutu.php method=post style="border: 3px solid black">
       <h2 style="margin-bottom: 20px; text-align: center;">Dodaj valutu</h2>
       <h4 style="color:red;text-align:center;"><?php echo $err; ?></h4>
       <hr>
         <strong>Naziv valute:</strong> <input type="text" name="naziv" id="naziv" style="width: 40%; height: 10px;" required><br> 
         <strong>Tečaj:</strong> <input type="text" name="tecaj" id="tecaj" style="width: 40%; height: 10px;" required><br>
         <?php
$veza = spojiSeNaBazu();
$getValuteQuery = "SELECT korisnik_id, CONCAT(ime, ' ' , prezime) AS nazivkorisnika FROM korisnik WHERE tip_korisnika_id = 1";
$valuteRes = izvrsiUpit($veza, $getValuteQuery);


echo '<strong>Zaduženi moderator:</strong> <select name="moderator_id" id="moderator_id">'; 

$count = 0;
while ($row = mysqli_fetch_array($valuteRes)) {
   echo '<option value="'.$row[korisnik_id].'">'.$row['nazivkorisnika'].'</option>';
   zatvoriVezuNaBazu($veza);
 
}
echo '</select> <br>';

        ?>
         <strong>Slika:<strong> <input type="text" name="slika" id="slika" style="width: 40%; height: 10px;" required><br>
         <strong>Zvuk:<strong> <input type="text" name="zvuk" id="zvuk" style="width: 40%; height: 10px;"><br>
         <strong>Aktivno od:<strong> <input type="text" name="aktivno_od" id="aktivno_od" style="width: 40%; height: 10px;" required><br>
         <strong>Aktivno do:<strong> <input type="text" name="aktivno_do" id="aktivno_do" style="width: 40%; height: 10px;" required><br>
         <input type="submit" value="Dodaj" name="submit" id="submit" onclick="javascript:return validate();" style="margin-bottom: 20px;" class="dodajiznosbtn">
       </form>


       <script>
        function validate(){


         if($("#tecaj").val()=="0"){
           alert("Tečaj ne može biti 0!");
          return false;
         }

          return true;
        }
       </script>
</body>