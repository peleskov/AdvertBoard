AdvertBoard.panel.Home = function (config) {
    config = config || {};
    Ext.apply(config, {
        baseCls: 'modx-formpanel',
        layout: 'anchor',
        stateful: true,
        stateId: 'advertboard-panel-home',
        stateEvents: ['tabchange'],
        getState:function() {return {activeTab:this.items.indexOf(this.getActiveTab())};},
        hideMode: 'offsets',
        items: [{
            html: '<h2>' + _('advertboard') + '</h2>',
            cls: '',
            style: {margin: '15px 0'}
        }, {
            xtype: 'modx-tabs',
            defaults: {border: false, autoHeight: true},
            border: true,
            hideMode: 'offsets',
            items: [{
                title: _('advertboard_items'),
                layout: 'anchor',
                items: [{
                    html: _('advertboard_intro_msg'),
                    cls: 'panel-desc',
                }, {
                    xtype: 'advertboard-grid-items',
                    cls: 'main-wrapper',
                }]
            }]
        }]
    });
    AdvertBoard.panel.Home.superclass.constructor.call(this, config);
};
Ext.extend(AdvertBoard.panel.Home, MODx.Panel);
Ext.reg('advertboard-panel-home', AdvertBoard.panel.Home);
