Ext.require([
    'Ext.grid.*',
    'Ext.data.*',
    'Ext.util.*',
    'Ext.state.*',
    'Ext.form.*'
]);

Ext.onReady(function(){
    // Define our data model
    Ext.define('Employee', {
        extend: 'Ext.data.Model',
        fields: [
            'descripcion',
            'cant',
            { name: 'cant2', type: 'float' },
            { name: 'active', type: 'bool' }
        ],
        proxy:{
            type: 'ajax',
            url: 'http://localhost/almacen/default/articulos/listar'
        }
    });

    // Generate mock employee data
    
    // create the Data Store
    var store = Ext.create('Ext.data.Store', {
        // destroy the store if the grid is destroyed
        autoDestroy: true,
        model: 'Employee',
        autoLoad: true,
        
    });

    var rowEditing = Ext.create('Ext.grid.plugin.RowEditing', {
        clicksToMoveEditor: 1,
        autoCancel: false
    });

    // create the grid and specify what field you want
    // to use for the editor at each column.
    var grid = Ext.create('Ext.grid.Panel', {
        store: store,
        columns: [{
            header: 'Descripcion',
            dataIndex: 'descripcion',
            flex: 1,
            
        }, {
            header: 'Cant Solicitada',
            dataIndex: 'cant',
            width: 160,
            
        },  {
            xtype: 'numbercolumn',
            header: 'Cant Entregada',
            dataIndex: 'salary',
            format: '0,0',
            width: 90,
            editor: {
                xtype: 'numberfield',
                allowBlank: false,
                minValue: 1,
                maxValue: 150000
            }
        }, ],
        renderTo: 'grid_despacho',
        width: 600,
        height: 400,
        title: 'Articulos Solicitados',
        frame: true,
        tbar: [{
            text: 'Agregar Articulos',
            iconCls: 'employee-add',
            handler : function() {
                rowEditing.cancelEdit();

                // Create a model instance
                var r = Ext.create('Employee', {
                    name: 'New Guy',
                    email: 'new@sencha-test.com',
                    start: Ext.Date.clearTime(new Date()),
                    salary: 50000,
                    active: true
                });

                store.insert(0, r);
                rowEditing.startEdit(0, 0);
            }
        }, {
            itemId: 'removeEmployee',
            text: 'Eliminar Articulos',
            iconCls: 'employee-remove',
            handler: function() {
                var sm = grid.getSelectionModel();
                rowEditing.cancelEdit();
                store.remove(sm.getSelection());
                if (store.getCount() > 0) {
                    sm.select(0);
                }
            },
            disabled: true
        }],
        plugins: [rowEditing],
        listeners: {
            'selectionchange': function(view, records) {
                grid.down('#removeEmployee').setDisabled(!records.length);
            }
        }
    });
});
