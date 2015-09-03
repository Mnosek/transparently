<?php
    if (!count($expenses)) {
        echo 'Brak rachunków';
    } else {
?>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Nazwa</th>
            <th>Data</th>
            <th>Grupa</th>
            <th>Wartość</th>
            <th>Do zapłacenia</th>
            <th>Zapłaciłeś</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
<?php
    foreach($expenses as $expense) {
        echo '<tr>'
            .'<td>'. $expense->name . '</td>'
            .'<td>'. substr($expense->date, 0,  10) . '</td>'
            .'<td>'. $expense->group_name . '</td>'
            .'<td>'. $expense->value . ' ' . $expense->currency_id .'</td>'
            .'<td>'. $expense->to_pay . ' ' . $expense->currency_id .'</td>'
            .'<td>'. $expense->paid . ' ' . $expense->currency_id .'</td>';
            if ($expense->to_pay != $expense->paid) {
                echo '<td><a href="/expense/payment/add?expense_id='. $expense->id() . '&value='. $expense->to_pay .'">Zapłaciłem!</a></td>';
            }
        echo '</tr>';
    }
?>
    </tbody>
</table>
<?php 
    } 
?>