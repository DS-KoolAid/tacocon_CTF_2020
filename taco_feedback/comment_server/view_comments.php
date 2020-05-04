<?php


if(isset($_COOKIE['admin_id']) && $_COOKIE['admin_id'] == "kCxpAJacgNoGZPEPsgcdAhaVCAXdQyLa6wHUyNPYLhDMYPuEr4inwLmRxsEPqXkK"){

  $entries = file("../comments.html");

  if(count($entries) > 0)
  {
    foreach($entries as $entry)
    {
      echo base64_decode($entry);
    }
  }


}

else{
  echo <<< HERE
  You aren't the admin!
  HERE;
}



?>