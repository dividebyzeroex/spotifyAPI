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

        session_start();
    
        $session = new SpotifyWebAPI\Session(
            'd0233e3bddf647c3821fac68bb2d4aa5',
            '899917c0583a471f8cf524aba161daf0',
            'https://minhaplaylist.azurewebsites.net/app.php'
        );
        
        // Request a access token using the code from Spotify
        try {
               if(isset($_GET['code'])){
                $session->requestAccessToken($_GET['code']);
                $_SESSION["codeSession"] = $_GET['code'];
                $accessToken = $session->getAccessToken();
                $_SESSION["refreshToken"] = $session->getRefreshToken();
            }else{
                $session->refreshAccessToken($_SESSION["refreshToken"]);
                $accessToken = $session->getAccessToken();
            }
           
        } catch (\Throwable $th) {
            $session->refreshAccessToken($_SESSION["refreshToken"]);
            $accessToken = $session->getAccessToken();
        }
        
        $api = new SpotifyWebAPI\SpotifyWebAPI();
        $api->setAccessToken($accessToken);
        
        $user = $api->me();
        $playlists = $api->getUserPlaylists($user->id, [
            'limit' => 50
        ]);       
        
        if(isset($_GET["result"])){
            if($_GET["result"] == "sucesso"){
                echo '<div class="container-fluid">
                <div class="alert alert-success" role="alert">
                    <h4 class="alert-heading">Acabamos!</h4>
                    <p>Agora você já pode abrir seu spotify e curtir a playlist que preparei para você com todas as suas musicas!</p>
                    <hr>
                    <p class="mb-0">Se você curtiu, me segue no insta para dar aquela moral!! <a href="https://www.instagram.com/eu.jpe?r=nametag" target="_blank">@eu.jpe</a></p>
                </div>';

            }else{
                echo '<div class="alert alert-danger" role="alert">
                    Tivemos um problema para criar sua playlist, causado por uma demora fora do normal. Podemos tentar novamete?
                </div>';
            }
        }
                
            echo '<nav class="navbar navbar-light bg-light">
                    <div class="media">
                        <img class="align-self-start mr-3" src="'.(($user->images[0]->url != null|| strlen($user->images[0]->url)>0)?$user->images[0]->url:'avatar.jpg').'" alt="'.$user->display_name.'" width="64px"; height="64px">
                        <div class="media-body">
                            <h5 class="mt-0">Oi '.$user->display_name.'</h5>
                            <p>Abaixo temos suas playlists, escolha todas que você queira juntar.</p>
                        </div>
                    </div>
                </nav>
                <form method="POST" action="./review.php">
                <div class="row">';
        foreach ($playlists->items as $playlist) {
            echo '<div class="col-sm-2">
                    <div class="card">
                        <input type="checkbox" name="playselection[]" value="'.$playlist->id.'" style="visibility:hidden;" id="ch_'.$playlist->id.'"/>
                        <img class="card-img-top responsive" src="'.(($playlist->images[0]->url != null || strlen($playlist->images[0]->url>0))?$playlist->images[0]->url:'cover.jpg').'" onclick="seleciona(\'sp_'.$playlist->id.'\');">
                        <span class="badge badge-success" style="visibility:hidden;" id="sp'.$playlist->id.'">Selecionado</span>
                    </div>
                </div>';
        }        
        echo '</div>
                <div class="text-center">
                    <input type="submit" class="btn btn-success" value="Juntar Playlists">
                </div>
        </div></form>
          </div>
        </div>
      </div>';
      ?>
    <script>
       function seleciona(elementId){
            var splitchannel = elementId.split("_");
            var spanSelect = document.getElementById("sp"+splitchannel[1]);
            var chSelect = document.getElementById("ch_"+splitchannel[1]);
            //alert(chSelect);
            if(spanSelect.style.visibility == "visible"){
                spanSelect.style.visibility ="hidden";
                chSelect.checked = "false";
            }else{
                spanSelect.style.visibility ="visible";
                chSelect.checked = "true";
            }
            
        }
    </script>
    </body>
</html>
