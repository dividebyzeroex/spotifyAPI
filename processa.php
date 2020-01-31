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

        set_time_limit(1800);
        session_start();

        $api = new SpotifyWebAPI\SpotifyWebAPI();

        // Fetch the saved access token from somewhere. A database for example.
        $api->setAccessToken($_GET['code']);
        $user = $api->me();
        $playid = $api->createPlaylist([
            'name' => '@eu.jpe - TudoEm1'
        ]);       
        $imageData = base64_encode(file_get_contents('cover.jpg'));
        $api->updatePlaylistImage($playid->id, $imageData);
    
        foreach($_POST['processaMusic'] as $selected){            
            $playlistTracks = $api->getPlaylistTracks($selected);
           foreach ($playlistTracks->items as $track) {
                try {
                    sleep(0.2);
                    $api->addPlaylistTracks($playid->id, [
                        $track->track->id
                    ]);
                   } catch (\Throwable $th) {
                    
                    //header('Location: app.php?result=erro');
                    //die();
                }
            }
            
        }

        echo 
        '<div class="container-fluid">
            <div class="alert alert-success" role="alert">
                <h4 class="alert-heading">Acabamos!</h4>
                <p>Agora você já pode abrir seu spotify e curtir a playlist que preparei para você com todas as suas musicas!</p>
                <hr>
                <p class="mb-0">Se você curtiu, me segue no insta para dar aquela moral!! <a href="https://www.instagram.com/eu.jpe?r=nametag" target="_blank">@eu.jpe</a></p>
            </div>
            <div class="text-center">
                <a href="https://minhaplaylist.azurewebsites.net/" class="btn btn-success">Ir para minhas Playlists</a>
            </div>
        </div>';
?>
</body>
</html>
