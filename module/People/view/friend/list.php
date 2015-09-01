<script type="text/javascript" src="/People/res/js/friend-list.js" ></script>


<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#searchFriends">Szukaj znajomych</button>

<div id="searchFriends" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Szukaj znajomych</h4>
      </div>
      <div class="modal-body">
        <form>
              <div class="form-group">
                <label for="inputEmail">Podaj email znajomego</label>
                <input type="email" class="form-control" id="inputEmail" placeholder="e-mail">
              </div>
            </form>
            <div id="searchFriendList"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Zamknij</button>
        <button onclick="searchFriends();" class="btn btn-primary">Szukaj</button>
      </div>
    </div>
  </div>
</div>
<br />
<br />
<div id="friendsPane" data-dojo-type="dijit/layout/ContentPane" href="/people/friend/list-pane"></div>