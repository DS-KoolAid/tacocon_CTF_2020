<?php


if(isset($_COOKIE['admin_id']) && $_COOKIE['admin_id'] == "kCxpAJacgNoGZPEPsgcdAhaVCAXdQyLa6wHUyNPYLhDMYPuEr4inwLmRxsEPqXkK"){

  $entries = file("../comments.html");

  $out_string="";

  if(count($entries) > 0)
  {
    foreach($entries as $entry)
    {
      $out_string.= "<h5>&emsp;&emsp;&emsp;Anonymous says:<br>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;".base64_decode($entry)."</h5><br>";
    }
  }
  // $out_string=urldecode($out_string);
  echo <<< HERE
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
                  <h4>Comments:</h4>
                     
                  <div id="content"> $out_string</div>

                  </div>
                                    
                </div>
            </div>
          </section>

      
  </body>
  </html>
  HERE;


}

else{
  echo <<< HERE
  You aren't the admin!
  HERE;
}



?>