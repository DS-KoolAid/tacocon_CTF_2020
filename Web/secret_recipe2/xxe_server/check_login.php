<?php 
    libxml_disable_entity_loader (false);
    $xmlfile = file_get_contents('php://input');
    $dom = new DOMDocument();
    $dom->loadXML($xmlfile, LIBXML_NOENT | LIBXML_DTDLOAD);
    $creds = simplexml_import_dom($dom);
    $user = $creds->user;
    $pass = $creds->pass;
    if ($user == 'admin' && $pass == 'admin'){
        echo <<<HERE
        Hello Admin!
         <br> <br> Remember, instead of showing the secret recipe here we moved it to that server on the local network (secret_server). <br><br>
         We are stepping up our security! We can't have our secret sauce being potentially exposed to everyone!

        HERE;
    }
    else{
        echo "Invalid Login";
    }
?> 


