<html>   
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </head>
    <body style="background: url('background-cover.jpg') no-repeat fixed center;">
      <?php
          require 'vendor/autoload.php';
          session_start();

          $session = new SpotifyWebAPI\Session(
            'd0233e3bddf647c3821fac68bb2d4aa5',
            '899917c0583a471f8cf524aba161daf0',
            'https://minhaplaylist.azurewebsites.net/review.php'
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
            //$session->refreshAccessToken($_SESSION["refreshToken"]);
            //$accessToken = $session->getAccessToken();
        }
        
        $api = new SpotifyWebAPI\SpotifyWebAPI();
        $api->setAccessToken($accessToken);

          echo '<div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Vamos revisar juntos?</h5>
                    <a href="./index.php" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </a>
                  </div>
                  <div class="modal-body">
                  <ul class="list-group list-group-flush">';
                  if(!empty($_POST['playselection'])){
                    foreach($_POST['playselection'] as $selected){
                          $playlistName = $api->getPlaylist($selected); 
                          echo 'aqio';                   
                          echo'<li class="list-group-item">'.$playlistName->name.'</li>';
                      }
                    echo '<script>
                          $("#exampleModalCenter").modal();
                      </script>';
                  }
                  echo '</ul>
                  </div>
                  <div class="modal-footer">
                  <form action="./processa.php" Method="POST">
                    <button type="submit" class="btn btn-primary">Tudo pronto, Juntar Playlists!</button>
                  </form>
                  </div>
                </div>';
      ?>
</body>
</html>