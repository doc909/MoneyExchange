<?php
 if(!isset($_SESSION)) 
 { 
     session_start(); 
 } 

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mjenjačnica</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    
</head>

<header>
        <span class="header-image"></span>
        <nav class="navbar navbar-expand-lg navbar-light bg-light" style="margin-bottom: 20px;">
            <a class="navbar-brand" href="o_autoru.html">O autoru</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
              <div class="navbar-nav">
                <a class="nav-item nav-link" href="prijava.php">Prijava</a>
                <a class="nav-item nav-link" href="pregledvaluta.php" >Pregled valuta</a>
                

                <?php
$var_value = $_SESSION['user_type'];
                    switch($var_value){
                        case 0:
                        echo '<a class="nav-item nav-link" href="adminkorisnika.php" >Korisnici</a>
                        <a class="nav-item nav-link" href="administracijavaluta.php" >Valute</a>
                        <a class="nav-item nav-link" href="administracijavrsta.php" >Vrste Korisnika</a>
                        <a class="nav-item nav-link" href="dodajkorisnika.php" >Dodaj korisnika</a>
                        <a class="nav-item nav-link" href="dodajvalutu.php" >Dodaj valutu</a>
                        <a class="nav-item nav-link" href="statistika.php" >Statistika</a>';
                        
                        case 1:
                        echo '<a class="nav-item nav-link" href="pregledsvihzahtjeva.php" >Pregled svih zahtjeva</a>
                        <a class="nav-item nav-link" href="azurirajtecaj.php" >Ažuriranje tečaja</a>';
                        case 2:
                        echo '<a class="nav-item nav-link" href ="upravljanjeiznosima.php" >Iznosi</a>
                              <a class="nav-item nav-link" href="slanjezahtjeva.php" >Slanje zahtjeva</a>
                              <a class="nav-item nav-link" href="pregledzahtjevakorisnik.php" >Zahtjevi korisnika</a>';    

                              if(isset($_SESSION['korisnik_id'])){
                                echo'<a class="nav-item nav-link" href="logout.php" >Odjavi se</a>';
                              }
                    }

                   
                ?>
                
              </div>
            </div>
        </nav>
    </header>