<?php

class Taco {
    function __destruct(){
        echo '<script>alert("TacoCon{ThisGuyShouldProbablySeeADoctor}") </script>';
    }

}

if (isset($_GET['doyoulovetacos']) && !empty($_GET['doyoulovetacos'])){
    $ans=$_GET['doyoulovetacos'];
    $love=unserialize($_GET['doyoulovetacos']);
    if ($ans=='YES'){
        echo <<<HERE
        <html>
        <!-- I LOVE TACOS SO MUCH I NAME MY OBJECTS AFTER THEM -->
        <head>
        <title>TACOS!!!!!!!!!!</title><meta charset="utf-8" /><meta name="viewport" content="width=device-width, initial-scale=1" /><link rel="stylesheet" href="assets/css/main.css" />
        </head>
        <body>
        <header id="header" class="alt">
        <div class="logo"><a href="index.html">TACOS <span>are the best</span></a></div>
        </header>
        <div id="main">
        <section class="wrapper style1">
        <div class="inner">
        <!-- 2 Columns -->
        <div class="flex flex-2">

        <div class="col col1">
        <div class="image round fit">

        <a href="generic.html" class="link"><img src="images/heckyea.jpg" alt="" /></a>
        </div>
        </div>
        <div class="col col2">
        <h3>SWEET ME TOO!!!</h3>
        </div>
        </div>
        </div></section></body>
        </html>
        HERE;

    }
    else if ($ans=='NO'){
        echo <<<HERE
        <html>
        <!-- I LOVE TACOS SO MUCH I NAME MY OBJECTS AFTER THEM -->
        <head>
        <title>TACOS!!!!!!!!!!</title><meta charset="utf-8" /><meta name="viewport" content="width=device-width, initial-scale=1" /><link rel="stylesheet" href="assets/css/main.css" />
        </head>
        <body>
        <header id="header" class="alt">
        <div class="logo"><a href="index.html">TACOS <span>are the best</span></a></div>
        </header>
        <div id="main">
        <section class="wrapper style1">
        <div class="inner">
        <!-- 2 Columns -->
        <div class="flex flex-2">

        <div class="col col1">
        <div class="image round fit">

        <a href="generic.html" class="link"><img src="images/dl.jpg" alt="" /></a>
        </div>
        </div>
        <div class="col col2">
        <h3>DON'T LIE TO ME!!!!!<br><br>EVERYONE LOVES TACOS!!!</h3>
        </div>
        </div>
        </div></section></body>
        </html>
        HERE;

    }

    

}

else{
    echo <<<HERE
    <html>
    <!-- I LOVE TACOS SO MUCH I NAME MY OBJECTS AFTER THEM -->
	<head>
		<title>TACOS!!!!!!!!!!</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="assets/css/main.css" />
	</head>
	<body>

		<!-- Header -->
			<header id="header" class="alt">
				<div class="logo"><a href="index.html">TACOS <span>are the best</span></a></div>
			</header>

		<!-- Main -->
			<div id="main">

				<!-- Section -->
					<section class="wrapper style1">
						<div class="inner">
							<!-- 2 Columns -->
								<div class="flex flex-2">
									<div class="col col1">
										<div class="image round fit">
											<a href="generic.html" class="link"><img src="images/pic01.jpg" alt="" /></a>
										</div>
									</div>
									<div class="col col2">
										<h3>HI MY NAME IS DAN. <br><br>I CANT STOP EATING TACOS<br><br>DO YOU LIKE TACOS????</h3>

										<form action="/answer.php" method="get" id="form1">
										<input type="radio" id="YES" name="doyoulovetacos" value="YES">
										<label for="YES">YES</label><br>
										<input type="radio" id="NO" name="doyoulovetacos" value="NO">
										<label for="NO">NO</label><br>
										</form> 
										<button type="submit" form="form1" value="Submit">Submit</button>

									</div>
								</div>
						</div>
					</section>

			
	</body>
</html>"
HERE;
}

?>
