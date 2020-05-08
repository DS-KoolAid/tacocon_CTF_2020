 <?php
 
    if ($_SERVER['REQUEST_METHOD']==="POST" && isset($_POST['comment'])){



        $input = base64_encode($_POST['comment']);


        $fp = fopen('../comments.html', 'a');//opens file in append mode  
        fwrite($fp, "\n".$input);   
        fclose($fp);  

        echo <<<HERE
        <html>
            <head>
            <title>Feedback Server</title>
            <meta charset="utf-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1" />
            <link rel="stylesheet" href="assets/css/main.css" />
        </head>
        <body>

            <!-- Header -->
                <header id="header" class="alt">
                    <div class="logo"><a href="index.php">TACOS <span>are the best</span></a></div>
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
                                                <img src="images/feedback.png" alt="" /></a>
                                            </div>
                                        </div>
                                        <div class="col col2">
                                            <h3>Comments have been added. The chef thanks you for your feedback!</h3>

                                        </div>
                                        
                                    </div>
                            </div>
                        </section>

                
        </body>
        </html>
        
        HERE;
        
    }
    else{
        echo <<<HERE
        Invalid request.
        HERE;
    }
    

 ?>