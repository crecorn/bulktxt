Ext.onReady(function () {
    MODx.load({ xtype: "bulktxt-page-home" });
});
Bulktxt.page.Home = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        components: [
            {
                xtype: "bulktxt-panel-home",
                renderTo: "bulktxt-panel-home-div"
            }
        ]
    });
    Bulktxt.page.Home.superclass.constructor.call(this, config);
};
Ext.extend(Bulktxt.page.Home, MODx.Component);
Ext.reg("bulktxt-page-home", Bulktxt.page.Home);