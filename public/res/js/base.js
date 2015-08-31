require(['dojo/_base/kernel',
         'dojo/_base/window',
         'dojo/aspect',
         'dojo/dom',
         'dojo/dom-construct',
         'dojo/on',
         'dojo/parser',
         'dojo/topic',
         'dojo/query',
         'dijit/form/_Spinner',

], function(kernel, window, aspect, dom, domConstruct, on, parser, topic, query, spinner) {

    query('.flash-msg').forEach(function(item) {
        item.onclick = function() {
            dom.byId(item).style.display = 'none';
        }
    });

});





