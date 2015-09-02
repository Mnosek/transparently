<?php
    if (!count($groups)) {
        echo 'Nie należysz do żadnej grupy.';
    } else {
?>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Nazwa</th>
            <th>Jesteś adminem?</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
<?php
    foreach($groups as $group) {
        echo '<tr><td>'. $group->name . '</td><td>';
        if ($group->is_admin) {echo 'TAK';} else{echo 'NIE'; }
        echo '</td><td><button class="btn btn-sm btn-danger"><span class="glyphicon glyphicon-remove"></span></button></td></tr>';
    }
?>
    </tbody>
</table>
<?php 
    } 
?>