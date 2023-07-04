var Bulktxt = function (config) {
    config = config || {};
    Bulktxt.superclass.constructor.call(this, config);
};
Ext.extend(Bulktxt, Ext.Component, {
    page: {},
    window: {},
    grid: {},
    tree: {},
    panel: {},
    combo: {},
    config: {},
});
Ext.reg("bulktxt", Bulktxt);
Bulktxt = new Bulktxt();