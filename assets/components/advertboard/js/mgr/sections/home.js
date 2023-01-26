AdvertBoard.page.Home = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        components: [{
            xtype: 'advertboard-panel-home',
            renderTo: 'advertboard-panel-home-div'
        }]
    });
    AdvertBoard.page.Home.superclass.constructor.call(this, config);
};
Ext.extend(AdvertBoard.page.Home, MODx.Component);
Ext.reg('advertboard-page-home', AdvertBoard.page.Home);