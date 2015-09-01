<script type="text/javascript" src="/People/res/js/group-list.js" ></script>


<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addGroup">Utwórz grupę</button>

<div id="addGroup" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Nowa grupa</h4>
      </div>
      <div class="modal-body">
        <form id="groupForm">
              <div class="form-group">
                <label for="inputName">Nazwa</label>
                <input type="text" class="form-control" id="inputName" name="name">
              </div>
        <div>
          <?php
              if (!count($friends)) {
                  echo 'Nie masz jeszcze znajomych';
              } else {
          ?>
          <table class="table table-bordered"> 
              <tbody>
              <?php
                  foreach($friends as $friend) {
                      echo '<tr><td><input type="checkbox" name="friend[]" value="'. $friend->user_id . '" /></td><td>'. $friend->name . '</td><td>'. $friend->last_name . '</td><td>'. $friend->email . '</td></tr>';
                  }
              ?>
              </tbody>
          </table>
          <?php 
              } 
          ?>
        </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Anuluj</button>
        <button onclick="addGroup();" class="btn btn-primary">Zapisz</button>
      </div>
    </div>
  </div>
</div>
<br />
<br />
<div id="groupsPane" data-dojo-type="dijit/layout/ContentPane" href="/people/group/list-pane"></div>