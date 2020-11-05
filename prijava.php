<?php 
	session_start();
	$_SESSION['user_type'] = -1;
	$_SESSION['korisnik_id'] = "";
	include_once("iwa_2019_vz_projekt.php");
	$veza = spojiSeNaBazu();

	
	if(isset($_POST["submit"])){
		$greska = "";
		$poruka = "";
		$korime = $_POST["korime"];
		$lozinka = $_POST["lozinka"];
		if(isset($korime) && !empty($korime)
			&& isset($_POST["lozinka"]) && !empty($_POST["lozinka"])){
				
				$upit = "SELECT * FROM korisnik 
					WHERE korisnicko_ime='{$korime}' 
					AND lozinka = '{$_POST["lozinka"]}'";
				
				$rezultat = izvrsiUpit($veza,$upit);
				$prijava = false;

				$count = mysqli_num_rows($rezultat);

				if($count == 0){

					$greska = "Korisničko ime i/ili lozinka se ne podudaraju!";
					
				}else {
					
					$red = mysqli_fetch_array($rezultat);
					$_SESSION['user_type'] = $red["tip_korisnika_id"];
					$_SESSION['korisnik_id'] = $red["korisnik_id"];
					$_SESSION['ime'] = $red["ime"];
					
					
					header("Location: index.php");
					exit();

				}


		}
		
	}
	
	zatvoriVezuNaBazu($veza);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prijava</title>
	<link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
	
	<body>	
		
		<section>
      <form action="prijava.php" method="post" style="height: 600px;"> 
        <div class="imgcontainer">
          <img src="images\unnamed.jpg" alt="Avatar" class="avatar">
        </div>
		
				
        <div class="container">
      <label for="korime"><b>Korisničko ime</b></label>
      <input type="text" placeholder="Korisničko ime" name="korime">

      <label for="lozinka"><b>Lozinka</b></label>
      <input type="password" placeholder="Lozinka" name="lozinka">

      <input type="submit" class="btn" value="Prijava" name="submit">
      <input type ="reset" class="btn" value="Anonimni" name="reset" id ="reset">
    </div>
    <div>
				<?php 
					if(isset($greska)){
						echo "<p style='color:red; position: absolute;
            display: flex;
            justify-content: center;
            width: 100%;
            '>$greska</p>";
					}
					
				?>
			</div>
			</form>
			
		</section>
	</body>

<script>
$(document).ready(function(){
    $('#reset').click(function(){


		window.location.replace("index.php");

    });
});
</script>
	
</html>
