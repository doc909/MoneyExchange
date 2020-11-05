<?php
session_start();
$var_value = $_SESSION['user_type'];

include_once("iwa_2019_vz_projekt.php");
  $veza = spojiSeNaBazu();

  $upit = "SELECT naziv, tecaj, slika FROM valuta";
  $rezultat = izvrsiUpit($veza, $upit);
  
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
    
</body>
</html>

