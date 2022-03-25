define([
    'uiComponent'
], function (Component) {
    return function (Component) {
        return Component.extend({
            defaults: {
                minSearchSymbols: 5
            }
        })
    }
})
