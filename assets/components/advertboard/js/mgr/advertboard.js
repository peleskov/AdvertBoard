var AdvertBoard = function (config) {
    config = config || {};
    AdvertBoard.superclass.constructor.call(this, config);
};
Ext.extend(AdvertBoard, Ext.Component, {
    page: {}, window: {}, grid: {}, tree: {}, panel: {}, combo: {}, config: {}, view: {}, utils: {}
});
Ext.reg('advertboard', AdvertBoard);

AdvertBoard = new AdvertBoard();