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

          $api = new SpotifyWebAPI\SpotifyWebAPI();

          // Fetch the saved access token from somewhere. A database for example.
          $api->setAccessToken($_GET['code']);
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
                      try {
                        $playlistName = $api->getPlaylist($selected);                   
                          echo'<li class="list-group-item">'.$playlistName->name.'</li>';
                      } catch (\Throwable $th) {
                        echo $th; 
                      }
                          
                      }
                    echo '<script>
                          $("#exampleModalCenter").modal();
                      </script>';
                  }
                  echo '</ul>
                  </div>
                  <div class="modal-footer">
                  <form action="./processa.php?code='.$_GET['code'].'" Method="POST">
                    <button type="submit" class="btn btn-primary">Tudo pronto, Juntar Playlists!</button>
                  </form>
                  </div>
                </div>';
      ?>
</body>
</html>