


<!DOCTYPE HTML>
<!--
	Urban by TEMPLATED
	templated.co @templatedco
	Released for free under the Creative Commons Attribution 3.0 license (templated.co/license)
-->

<html>
	<head>
		<title>Recipe Server</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="assets/css/main.css" />
	</head>
	<body>

		<!-- Header -->
			<header id="header" class="alt">
                <div class="logo"><a href="index.php">TACOS <span>are the best</span></a></div>
                <a href="/add.php" class="button">Add User</a>
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
											<img src="images/admin.png" alt="" /></a>
										</div>
									</div>
									<div class="col col2">
										<h3>Enter credentials</h3>
                                        <?php

                                            require_once("db.php");
                                            if ($_SERVER['REQUEST_METHOD']==='POST'){
                                                function handle_post() {
                                                global $_POST;
                                                
                                                $name = $_POST["name"];
                                                $secret = $_POST["password"];

                                                if (isset($name) && $name !== "" && isset($secret) && $secret !== "") {
                                                    if (check_name_secret($name, $secret) === false) {
                                                    return "Incorrect name or secret, please try again";
                                                    }

                                                    $message = get_message($name);

                                                    echo "<p>Message:";
                                                    echo "<li>" . htmlentities($message['message']) . "</li></p>";
                                                }
                                                else {
                                                    echo <<< HERE
                                                    <form action="/view.php" method="POST">
                                                    Name: <input type="text" name="name" /><br />
                                                    Secret: <input type="password" name="password" /><br />
                                                    <input type="submit" value="Login" />
                                                    </form>
                                                    HERE;

                                                }

                                                return null;
                                                }

                                                $error = handle_post();
                                                if ($error !== null) {
                                                echo "<p>Error: " . $error . "</p>";
                                                }
                                            }

                                            elseif ($_SERVER['REQUEST_METHOD']==="GET"){
                                                echo <<< HERE
                                                <form action="/view.php" method="POST">
                                                Name: <input type="text" name="name" /><br />
                                                Secret: <input type="password" name="password" /><br />
                                                <input type="submit" value="Login" />
                                                </form>
                                                HERE;

                                            }
                                            ?>
                                            

                                            <div id="content"></div>

                                    </div>
                                    
								</div>
						</div>
					</section>

			
	</body>
</html>