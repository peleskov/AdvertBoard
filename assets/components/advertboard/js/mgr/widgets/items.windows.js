AdvertBoard.window.CreateItem = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'advertboard-item-window-create';
    }
    Ext.applyIf(config, {
        title: _('advertboard_item_create'),
        width: 550,
        autoHeight: true,
        url: AdvertBoard.config.connector_url,
        action: 'mgr/item/create',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    AdvertBoard.window.CreateItem.superclass.constructor.call(this, config);
};
Ext.extend(AdvertBoard.window.CreateItem, MODx.Window, {

    getFields: function (config) {
        return [{
            layout: 'column',
            border: false,
            anchor: '100%',
            items: [{
                layout: 'form',
                border: false,
                columnWidth: .70,
                items: [{
                    xtype: 'textfield',
                    fieldLabel: _('advertboard_item_title'),
                    name: 'title',
                    id: config.id + '-title',
                    anchor: '99%',
                    allowBlank: true,
                }]
            }, {
                layout: 'form',
                border: false,
                columnWidth: .10,
                items: [{
                    xtype: 'xcheckbox',
                    fieldLabel: _('advertboard_item_top'),
                    name: 'top',
                    id: config.id + '-top',
                    anchor: '99%',
                }]
            }, {
                layout: 'form',
                border: false,
                columnWidth: .20,
                items: [{
                    xtype: 'numberfield',
                    fieldLabel: _('advertboard_item_price'),
                    name: 'price',
                    id: config.id + '-price',
                    anchor: '99%',
                    allowBlank: true,
                }]
            }]

        }, {
            layout: 'column',
            border: false,
            anchor: '100%',
            items: [{
                layout: 'form',
                border: false,
                columnWidth: .50,
                items: [{
                    xtype: 'numberfield',
                    fieldLabel: _('advertboard_item_parent'),
                    name: 'pid',
                    id: config.id + '-pid',
                    anchor: '99%',
                    allowBlank: true,
                }]
            }, {
                layout: 'form',
                border: false,
                columnWidth: .50,
                items: [{
                    xtype: 'numberfield',
                    fieldLabel: _('advertboard_item_author'),
                    name: 'user_id',
                    id: config.id + '-user_id',
                    anchor: '99%',
                    allowBlank: true,
                }]


            }]
        }, {
            layout: 'form',
            border: false,
            anchor: "100%",
            items: [{
                xtype: 'modx-combo-browser',
                fieldLabel: _('advertboard_item_image'),
                name: 'img',
                id: config.id + '-img',
                grow: true,
                anchor: '100%',
            }]
        }, {
            layout: 'form',
            border: false,
            anchor: "100%",
            items: [{
                xtype: 'textarea',
                fieldLabel: _('advertboard_item_content'),
                name: 'content',
                id: config.id + '-content',
                grow: true,
                anchor: '100%',
            }]
        }]
    },

    loadDropZones: function () {
    }
});
Ext.reg('advertboard-item-window-create', AdvertBoard.window.CreateItem);


AdvertBoard.window.UpdateItem = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'advertboard-item-window-update';
    }
    Ext.applyIf(config, {
        title: _('advertboard_item_update'),
        width: 550,
        autoHeight: true,
        url: AdvertBoard.config.connector_url,
        action: 'mgr/item/update',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    AdvertBoard.window.UpdateItem.superclass.constructor.call(this, config);
};
Ext.extend(AdvertBoard.window.UpdateItem, MODx.Window, {

    getFields: function (config) {
        return [{
            xtype: 'hidden',
            name: 'id',
            id: config.id + '-id',
        }, {
            layout: 'column',
            border: false,
            anchor: '100%',
            items: [{
                layout: 'form',
                border: false,
                columnWidth: .70,
                items: [{
                    xtype: 'textfield',
                    fieldLabel: _('advertboard_item_title'),
                    name: 'title',
                    id: config.id + '-title',
                    anchor: '99%',
                    allowBlank: true,
                }]
            }, {
                layout: 'form',
                border: false,
                columnWidth: .10,
                items: [{
                    xtype: 'xcheckbox',
                    fieldLabel: _('advertboard_item_top'),
                    name: 'top',
                    id: config.id + '-top',
                    anchor: '99%',
                }]
            }, {
                layout: 'form',
                border: false,
                columnWidth: .20,
                items: [{
                    xtype: 'numberfield',
                    fieldLabel: _('advertboard_item_price'),
                    name: 'price',
                    id: config.id + '-price',
                    anchor: '99%',
                    allowBlank: true,
                }]
            }]

        }, {
            layout: 'column',
            border: false,
            anchor: '100%',
            items: [{
                layout: 'form',
                border: false,
                columnWidth: .50,
                items: [{
                    xtype: 'numberfield',
                    fieldLabel: _('advertboard_item_parent'),
                    name: 'pid',
                    id: config.id + '-pid',
                    anchor: '99%',
                    allowBlank: true,
                }]
            }, {
                layout: 'form',
                border: false,
                columnWidth: .50,
                items: [{
                    xtype: 'numberfield',
                    fieldLabel: _('advertboard_item_author'),
                    name: 'user_id',
                    id: config.id + '-user_id',
                    anchor: '99%',
                    allowBlank: true,
                }]


            }]
        }, {
            layout: 'form',
            border: false,
            anchor: "100%",
            items: [{
                xtype: 'hidden',
                name: 'images',
                id: config.id + '-images',
                allowBlank: true,
            }, {
                anchor: '100%',
                html: '',
                id: config.id + '-image',
                listeners: {
                    afterrender: function () {
                        let val = Ext.getCmp(config.id + '-images').getValue();
                        if (val) {
                            let imgs = JSON.parse(val);
                            if(imgs[0] !== undefined && imgs[0]['full_url'] !== undefined) {
                                this.update('<div style="text-align: center; padding-top: 15px;"><img src="' + imgs[0]['full_url'] + '" alt=""></div>');
                            }
                        }
                    }
                }
            }]
        }, {
            layout: 'form',
            border: false,
            anchor: "100%",
            items: [{
                xtype: 'modx-combo-browser',
                fieldLabel: _('advertboard_item_image'),
                name: 'img',
                id: config.id + '-img',
                grow: true,
                anchor: '100%',
            }]
        }, {
            layout: 'form',
            border: false,
            anchor: "100%",
            items: [{
                xtype: 'textarea',
                fieldLabel: _('advertboard_item_content'),
                name: 'content',
                id: config.id + '-content',
                grow: true,
                anchor: '100%',
            }]
        }]
    },

    loadDropZones: function () {
    }

});
Ext.reg('advertboard-item-window-update', AdvertBoard.window.UpdateItem);

AdvertBoard.window.ImportCreate = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'advertboard-import-window-create';
    }
    Ext.applyIf(config, {
        title: _('advertboard_import'),
        width: 550,
        autoHeight: true,
        url: AdvertBoard.config.connector_url,
        action: 'mgr/item/import',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    AdvertBoard.window.ImportCreate.superclass.constructor.call(this, config);
};
Ext.extend(AdvertBoard.window.ImportCreate, MODx.Window, {

    getFields: function (config) {
        return [{
            layout: 'form',
            width: '100%',
            autoHeight: true,
            border: true,
            buttonAlign: 'center',
            items: [{
                xtype: 'panel',
                border: false,
                cls: 'main-wrapper',
                layout: 'form',
                items: [{
                    layout: 'form',
                    border: false,
                    anchor: "100%",
                    items: [{
                        html: _('advertboard_import_intro_msg'),
                        id: 'advertboard-import-intro-msg',
                        xtype: 'label'
                    }, {
                        xtype: 'modx-combo-browser',
                        fieldLabel: _('advertboard_import_file'),
                        name: 'csv_file',
                        id: config.id + '-csv_file',
                        allowBlank: false,
                        openTo: '/assets/import/',
                        hideFiles: true,
                        anchor: '100%',
                    }]
                }]
            }]
        }]
    },

    loadDropZones: function () {
    }
});
Ext.reg('advertboard-import-window-create', AdvertBoard.window.ImportCreate);