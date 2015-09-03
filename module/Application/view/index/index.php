
          <div class="row placeholders">
            <div class="col-xs-6 col-sm-4 placeholder">
              <h4><?php echo $balance['to_pay_total']; ?> PLN</h4>
              <span class="text-muted">Twój dług</span>
            </div>
           <div class="col-xs-6 col-sm-4 placeholder">
              <h4><?php echo $balance['total_paid']; ?> PLN</h4>
              <span class="text-muted">Zapłaciłeś</span>
            </div>
            <div class="col-xs-6 col-sm-4 placeholder">
              <h4><?php echo $balance['balance']; ?> PLN</h4>
              <span class="text-muted">Bilans</span>
            </div>
          </div>

          <h2 class="sub-header">Rozliczenia w grupach</h2>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Grupa</th>
                  <th>Suma</th>
                  <th>Do zapłaty</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($groupBalance as $group) { ?> 
                    <tr>
                      <td><?php echo $group['group_name']; ?></td>
                      <td><?php echo $group['value']; ?> PLN</td>
                      <td><?php echo $group['to_pay']; ?> PLN</td>
                    </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
 