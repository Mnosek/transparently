require(['dojo/dom',
         'dojo/dom-construct',
         'dojo/on',
         'dojo/query'

], function(dom, domConstruct, on, query) {

    validateForm = function() {
        if (dom.byId('inputPassword').value != dom.byId('inputPasswordRepeat').value ) {
            alert('Podane hasła są różne');
            return false;
        } else {
            return true;
        }
    }

});






