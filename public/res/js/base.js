require(['dojo/_base/kernel',
         'dojo/_base/window',
          'dojo/parser',
          'dojo/ready',
         'dojo/aspect',
         'dojo/dom',
         'dojo/dom-construct',
         'dojo/on',
         'dojo/topic',
         'dojo/query',
         'dijit/form/_Spinner',
         'bootstrap/modal',


], function(kernel, window, parser, ready, aspect, dom, domConstruct, on, topic, query, spinner) {

     parser.parse();
    query('.flash-msg').forEach(function(item) {
        item.onclick = function() {
            dom.byId(item).style.display = 'none';
        }
    });

});





