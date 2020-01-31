<html>   
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </head>
    <body>
<?php
    require 'vendor/autoload.php';

    set_time_limit(600);
    session_start();

    $session = new SpotifyWebAPI\Session(
        'd0233e3bddf647c3821fac68bb2d4aa5',
        '899917c0583a471f8cf524aba161daf0',
        'https://minhaplaylist.azurewebsites.net/processa.php'
    );
    
    // Request a access token using the code from Spotify
    try {
        $session->requestAccessToken($_SESSION["codeSession"]);
        $accessToken = $session->getAccessToken();
        $_SESSION["refreshToken"] = $session->getRefreshToken();
        
    } catch (\Throwable $th) {
        $session->refreshAccessToken($_SESSION["refreshToken"]);
        $accessToken = $session->getAccessToken();
    }
    
    $api = new SpotifyWebAPI\SpotifyWebAPI();
    $api->setAccessToken($_SESSION["accessToken"]);
    $user = $api->me();
    $playid = $api->createPlaylist([
            'name' => '@eu.jpe - TudoEm1'
        ]);

        echo $playid->id;
        $imageData = base64_encode(file_get_contents('cover.jpg'));
        
        $api->updatePlaylistImage($playid->id, $imageData);
        

        foreach($_SESSION['playSelection'] as $selected){
            $playlistTracks = $api->getPlaylistTracks($selected);
            
            foreach ($playlistTracks->items as $track) {
                try {
                    sleep(0.3);
                    $api->addPlaylistTracks($playid->id, [
                        $track->track->id
                    ]);
                   } catch (\Throwable $th) {
                    //echo $th;
                    //header('Location: app.php?result=erro');
                    //die();
                }
            }
            
        }

        header('Location: app.php?result=sucesso');
        die();

?>
</body>
</html>
