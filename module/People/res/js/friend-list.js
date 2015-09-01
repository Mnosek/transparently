require(['dojo/dom',
         'dojo/dom-construct',
         'dojo/on',
         'dojo/query',
         'dojo/request/xhr',
         'dijit/registry',
         'dijit/layout/ContentPane'


], function(dom, domConstruct, on, query, xhr, registry) {

    searchFriends = function() {
        if (!dom.byId('inputEmail').value) {
            alert('Podaj email');
        } else {
             xhr('/people/friend/search', {
                   method: 'post',
                   data: {'email': dom.byId('inputEmail').value}
                }).then(
                    function(data) {
                        dom.byId('searchFriendList').innerHTML = data;
                    }
                );
        }
    };


    addFriend = function(id) {
        xhr('/people/friend/add', {
           method: 'post',
           data: {'user_id': id}
        }).then(
            function(data) {
                dom.byId('searchFriendList').innerHTML = '';
                dom.byId('inputEmail').value = '';
                dom.byId('inputEmail').focus();
                registry.byId('friendsPane').set('href','/people/friend/list-pane');
            }
        );
    };
});






