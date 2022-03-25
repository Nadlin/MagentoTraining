define([
    'uiComponent',
    'jquery',
    'mage/url'
], function (Component, $, url) {
    return Component.extend({
        defaults: {
            searchText: '',
            minSearchSymbols: 3,
            searchResult: [],
            searchUrl: url.build('linnik/filter/sku')
        },

        initObservable: function () {
            this._super()
                .observe(['searchText', 'searchResult']);

            return this;
        },

        initialize: function () {
            this._super();

            this.searchText.subscribe(this.getAutoCompleteOptions.bind(this));
        },

        getAutoCompleteOptions: function (searchValue) {
            if (searchValue.length >= this.minSearchSymbols) {
                console.log(searchValue);
                $.ajax({
                    url: this.searchUrl,
                    type: 'POST',
                    dataType: 'json',
                    data: {q: searchValue},
                    success: function (data) {
                        console.log(data);
                        this.searchResult(data);
                    }.bind(this),
                    error: function (data) {
                        console.log(data);
                        this.searchResult([]);
                    }.bind(this)
                })
            }
        }
    });
});
