 <?php
 
    if ($_SERVER['REQUEST_METHOD']==="POST" && isset($_POST['comment'])){

        $input = base64_encode(htmlspecialchars($_POST['comment']));

        file_put_contents("../comments.html", $input."\n");

        echo <<<HERE
        Comments have been added.
        HERE;
        
    }
    else{
        echo <<<HERE
        Invalid request.
        HERE;
    }
    

 ?>