<?php

    echo '<div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Vamos revisar juntos?</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
            <ul class="list-group list-group-flush">';
            if(!empty($_POST['playselection'])){
                $_SESSION["playSelection"] = $_POST['playselection'];
                foreach($_POST['playselection'] as $selected){
                    $playlistName = $api->getPlaylist($selected);                    
                    echo'<li class="list-group-item">'.$playlistName->name.'</li>';
                }
               echo '<script>
                    $("#exampleModalCenter").modal();
                 </script>';
            }
            echo '</ul>
            </div>
            <div class="modal-footer">
            <form action="processa.php" Method="POST">
              <button type="submit" class="btn btn-primary">Tudo pronto, Juntar Playlists!</button>
            </form>
            </div>
          </div>'


?>