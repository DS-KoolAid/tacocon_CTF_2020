


<html>
<?php

function clean($string) {
    $string = str_replace(' ', '', $string); // Replaces all spaces with hyphens.
    $string=str_replace('\n', '', $string);
    $string=str_replace('\r', '', $string);
 
    return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
 }

if ($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['sshkey'])){

    $att=$_POST['sshkey'];
    
    $ans = <<< 'EOS'
    -----BEGIN DSA PRIVATE KEY-----
    MIIBugIBAAKBgQCFNoJiMbryCUiRhjIVD09YxY/lmBUBXhdSYPInk118YTc0PRv0
    7BHtcEGRWlEOONvdnObTAp3DlRAlLPersaY0BQUGGO5Rpg8wjtjuBXDniuYRAtqx
    Ph+SqQmdmmpllf1zEtefTXGCrD8ldgrdHdqaqi62jqFaENr3/YVr5dBK1wIVAIgV
    OGuF3mRB3t5HNPx0dh+VV7QfAoGAIMQnIRxdJJWzw6f1Un1HjUyhvnEHGC4IQM/W
    2tU4i8kxrH9SiyWFGLb0nFTBbTT3lEYSpfRbzMepAp6XuwWSl7KEgpRS4AubSUS9
    yoQSxEXpIcwnW+UEL4panwUGzJpeTEIP5RncxTKet47Q1rwXXcvMt6mveXSi+l1L
    J7PG7hcCgYBJMDjt17uMZXhSNwTTo2rFAs68C7k5t4YR8J9TmQ9AFvPdYBiVEN0B
    GWkbJn2a8USg+lpmeljVW3G6P6CoXDurPKS2LY0kvkVnJScR9M24c3lfVENuG9Y9
    nd/9YVJ8PE7Szv89U5//WwkirxEoUTis4mkNuiWY7+DS/cVwoZq+NgIUFlZuTKWU
    4SZXTQzKMYF5tSoVtvs=
    -----END DSA PRIVATE KEY-----
    EOS;


    $att=clean($att);
    $ans=clean($ans);

    if ($att===$ans){
        echo "Thank you! I can get into my server now! <br><br>Here's your reward: Tacocon{ThisIsWhatHappensWhenyouTakeOutRandfromSSH}";
    }
    else{
        echo "Nope, that's not it!";
    }
}

else{
    echo "Invalid Request!";
}

?>

</html>