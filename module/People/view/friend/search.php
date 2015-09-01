<?php if (!count($users)) { ?>
Nie znaleziono użytkowników o podanym emailu

<?php } else { 
    foreach ($users as $user) {
        echo $user->name . ' ' . $user->last_name . ' <button type="button" class="btn btn-green" onclick="addFriend(' . $user->id() . ')">Dodaj</button>';
    }

    }
?>