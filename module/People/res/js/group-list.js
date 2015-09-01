require(['dojo/dom',
         'dojo/dom-construct',
         'dojo/on',
         'dojo/query',
         'dojo/request/xhr',
         'dijit/registry',
         'dojo/dom-form',
         'dojo/query',
         'dijit/layout/ContentPane'


], function(dom, domConstruct, on, query, xhr, registry, domForm, query) {
    
    addGroup = function() {

        var form = domForm.toObject(dom.byId("groupForm"));

        if (!form.name) {
            alert("Podaj nazwę grupy");
        }

        if (!form['friend[]']) {
            alert("Musisz wybrać znajomych");
        }


        xhr('/people/group/create', {
           method: 'post',
           data: form
        }).then(
            function(data) {
                if (data) {
                    alert(data);
                } else {
                    query('#addGroup').modal('hide');
                    registry.byId('groupsPane').set('href','/people/group/list-pane');
                }
            }
        );
    };
});






