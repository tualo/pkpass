
Ext.define('Tualo.routes.PKPass', {
    statics: {
        load: async function() {
            return [
                {
                    name: 'pkpass/send',
                    path: '#pkpass/send'
                }
            ]
        }
    }, 
    url: 'pkpass/send',
    handler: {
        action: function () {
            
            Ext.getApplication().addView('Tualo.PKPass.Viewport');
        },
        before: function (action) {
            action.resume();
        }
    }
});

