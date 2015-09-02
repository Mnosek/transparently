<script type="text/javascript" src="/Expense/res/js/expense-list.js" ></script>


<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addExpense">Dodaj rachunek</button>

<div id="addExpense" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Zamknij"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Dodaj rachunek</h4>
      </div>
      <div class="modal-body">
        <form id="newExpenseForm" method="POST">
              <div class="form-group">
                <label for="inputEmail">W grupie:</label>
                <select class="form-control" name="group_id" id="expenseGroup">
                  <option>Wybierz</option>
                  <?php foreach ($groups as $group) {
                    echo '<option value="' . $group->id() . '">'. $group->name .'</option>';
                  } ?>
                </select>
              </div>
              <div class="form-group">
                <label for="inputName">Opis</label>
                <input type="text" class="form-control" id="expendeName" name="name" placeholder="Opis...">
              </div>
              <div class="form-group">
                <label class="sr-only" for="expenseDate">Data</label>
                <div class="input-group">
                  <div class="input-group-addon">  <span class="glyphicon glyphicon-calendar"></span></div>
                  <input type="date" class="form-control" name="date" id="expenseDate" placeholder="Data">
                </div>
              </div>
              <div class="form-group">
                <label class="sr-only" for="exampleInputAmount">Kwota (w PLN)</label>
                <div class="input-group">
                  <div class="input-group-addon">PLN</div>
                  <input type="text" class="form-control" name="value" onchange="recalculateValues();" id="expenseValue" placeholder="Kwota">
                </div>
              </div>
              <div class="form-group">
                <label for="inputName">Podziel:</label>
                <label class="radio-inline">
                  <input type="radio" checked="checked" name="split_type_id" id="splitEqually" onclick="handleRadioValue(this);"value="Equally"> Równo
                </label>
                <label class="radio-inline">
                  <input type="radio" name="split_type_id" id="splitPercentage" onclick="handleRadioValue(this);" value="Percentage"> Procentowo
                </label>
                <label class="radio-inline">
                  <input type="radio" name="split_type_id" id="splitAmount" onclick="handleRadioValue(this);" value="Amount"> Wg dokładnej kwoty
                </label>
              </div>
              <div id="membersPane" data-dojo-type="dijit/layout/ContentPane" onload="parseMemberList()"></div>
            </form>
            <div style="display: none; width: 100%; height: 50px;" id="splitSum">
              <span>Podzielono:</span><span id="valueSplitted"></span><br />
              <span>Pozostało:</span><span id="valueLeft"></span><br />
            </div>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Anuluj</button>
          <button onclick="addExpense();" class="btn btn-primary">Dodaj</button>
      </div>
    </div>
  </div>
</div>
<br />
<br />
<div id="expensePane" data-dojo-type="dijit/layout/ContentPane" href="/expense/index/list-pane"></div>