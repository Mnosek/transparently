<?php
    if (!count($friends)) {
        echo 'Nie masz jeszcze znajomych';
    } else {
?>
<table class="table table-bordered">
    <thead>
        <th>Imię</th>
        <th>Nazwisko</th>
        <th>Email</th>
        <th></th>
    </thead>
    <tbody>
<?php
    foreach($friends as $friend) {
        echo '<tr><td>'. $friend->name . '</td><td>'. $friend->last_name . '</td><td>'. $friend->email . '</td><td><button class="btn btn-sm btn-danger">
    <span class="glyphicon glyphicon-remove"></span>
  </button></td></tr>';
    }
?>
    </tbody>
</table>
<?php 
    } 
?>