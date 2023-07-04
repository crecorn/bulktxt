// this is not needed in bulktxt extra will change this.

Bulktxt.panel.Home = function (config) {
    config = config || {};
    Ext.apply(config, {
        border: false,
        baseCls: "modx-formpanel",
        cls: "container",
        items: [
            {
                html: "<h2>" + _("bulktxt.management") + "</h2>",
                border: false,
                cls: "modx-page-header",
            },
            {
                xtype: "modx-tabs",
                defaults: { border: false, autoHeight: true },
                border: true,
                items: [
                    {
                        title: _("bulktxt"),
                        defaults: { autoHeight: true },
                        items: [
                            {
                                html:
                                    "<p>" +
                                    _("Bulktxt Description") +
                                    "</p>",
                                border: false,
                                bodyCssClass: "panel-desc",
                            } /*,{
                                xtype: 'doodles-grid-doodles'
                                ,cls: 'main-wrapper'
                                ,preventRender: true
                            }*/,
                        ],
                    },
                ],
                listeners: {
                    afterrender: function (tabPanel) {
                        tabPanel.doLayout();
                    },
                },
            },
        ],
    });
    Bulktxt.panel.Home.superclass.constructor.call(this, config);
};
Ext.extend(Bulktxt.panel.Home, MODx.Panel);
Ext.reg("bulktxt-panel-home", Bulktxt.panel.Home);