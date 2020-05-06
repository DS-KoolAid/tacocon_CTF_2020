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
                <a href="/index.php" class="button">Login Page</a>
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
										<h3>Add User:</h3>
                                        <?php

                                            require_once("db.php");
                                            if ($_SERVER['REQUEST_METHOD']==="GET"){
                                                echo <<<HERE
                                                <form action="/add.php" method="POST">
                                                Username: <input type="text" name="name" /><br />
                                                Password (10+ characters, smallcase, uppercase, number) : <input type="password" name="secret" /><br />
                                                <input type="submit" value="Add" />
                                                </form>

                                                HERE;
                                            }

                                            elseif ($_SERVER['REQUEST_METHOD']==='POST'){

                                                function validate_secret($secret) {
                                                    if (strlen($secret) < 10) {
                                                        return false;
                                                    }
                                                    $has_lowercase = false;
                                                    $has_uppercase = false;
                                                    $has_number = false;
                                                    foreach (str_split($secret) as $ch) {
                                                        if (ctype_lower($ch)) {
                                                        $has_lowercase = true;
                                                        } else if (ctype_upper($ch)) {
                                                        $has_uppercase = true;
                                                        } else if (is_numeric($ch)) {
                                                        $has_number = true;
                                                        }
                                                    }
                                                    return $has_lowercase && $has_uppercase && $has_number;
                                                    }
        
                                                    function handle_post() {
                                                    global $_POST;
        
                                                    $name = $_POST["name"];
                                                    $secret = $_POST["secret"];
                                                    $message = "Hello " . $name . "!";
        
                                                    if (isset($name) && $name !== ""
                                                            && isset($secret) && $secret !== ""
                                                            && isset($message) && $message !== "") {
                                                        if (validate_secret($secret) === false) {
                                                        return "Invalid secret, please check requirements";
                                                        }
        
                                                        $test = get_message($name);
                                                        if ($test !== null) {
                                                        return "User already exists, please enter again";
                                                        }
                                                        insert_user($name, $secret, $message);
        
                                                        echo "<p>User has been added</p>";
                                                    }
        
                                                    return null;
                                                    }
        
                                                    $error = handle_post();
                                                    if ($error !== null) {
                                                    echo "<p>Error: " . $error . "</p>";
                                                    }
                                            }
                                            
                                            ?>


                                            <div id="content"></div>

                                    </div>
                                    
								</div>
						</div>
					</section>

			
	</body>
</html>