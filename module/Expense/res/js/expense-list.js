require(['dojo/dom',
         'dojo/dom-construct',
         'dojo/on',
         'dojo/request/xhr',
         'dijit/registry',
         'dojo/dom-form',
         'dojo/query',
         'dijit/layout/ContentPane'


], function(dom, domConstruct, on, xhr, registry, domForm, query) {
    
    dom.byId('expenseGroup').onchange = function() {
        if (!registry.byId('membersPane').get('href')) {
            registry.byId('membersPane').set('href','/people/group/expense-member?group_id=' + this.value);
        } else {
            registry.byId('membersPane').set('href','/people/group/expense-member?group_id=' + this.value);
            registry.byId('membersPane').refresh();
        }
    };


    parseMemberList = function()
    {
        var form = domForm.toObject(dom.byId("newExpenseForm"));

        if (form.split_type_id == 'Equally') {
            dom.byId('membersPane').style.display = 'none';
            dom.byId('splitSum').style.display = 'none';
        } else {
            dom.byId('membersPane').style.display = '';
            dom.byId('splitSum').style.display = '';
            dom.byId('valueSplitted').innerHTML = '';
            dom.byId('valueLeft').innerHTML = '';
        }

        query('#membersPane .memberValue').forEach(function(item){
            item.value = '';
            item.onchange = function() {
                recalculateValues();
            };
        });
    };


    recalculateValues = function()
    {
        sum = 0;

        query('#membersPane .memberValue').forEach(function(item){
            if (parseFloat(item.value)) {
                sum += parseFloat(item.value);
            }
        });

        if (radioValue == 'Percentage') {
            splitted = sum;
            left = 100 - sum;
            dom.byId('valueSplitted').innerHTML = splitted + '%';
            dom.byId('valueLeft').innerHTML = left + '%';
            var valueSum = sum;
        } else if (radioValue == 'Amount') {
            toSplit = parseFloat(dom.byId('expenseValue').value);
            splitted = sum;
            left = toSplit - sum;
            var valueSum = sum;
            dom.byId('valueSplitted').innerHTML = splitted + ' PLN';
            dom.byId('valueLeft').innerHTML = left + ' PLN';
        }

    };

    
    var radioValue = 0;

    handleRadioValue = function(radio)
    {
            if (radio.value != radioValue) {
                parseMemberList();
                radioValue = radio.value;
            }
    };


    addExpense = function()
    {
        var form = domForm.toObject(dom.byId("newExpenseForm"));

        xhr('/expense/index/add', {
           method: 'post',
           data: form,
           handleAs: 'json'
        }).then(
            function(data) {
                if (data.error) {
                    alert(data.error);
                } else {
                    query('#addExpense').modal('hide');
                    registry.byId('expensePane').set('href','/expense/index/list-pane');
                }
            }
        );
    };

});






