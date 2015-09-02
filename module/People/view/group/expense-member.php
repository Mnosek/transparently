<table class="table" style="width: 100%">
    <tbody>
        <?php foreach ($members as $member) {
            echo '<tr><td>'. $member->name . ' ' . $member->last_name . '</td><td><input class="memberValue" name="userValue[]" type="text" />'
                 . '<input type="hidden" name="userId[]" value="'. $member->id() .'"/>'
                 . '</td></tr>';
        } ?>
    </tbody>
</table>