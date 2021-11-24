"use strict";
// Class definition

var KTDatatableJsonRemoteDemo = function() {
    // Private functions

    // basic demo
    var demo = function() {
        var user_id = $('#kt_datatable').attr('user_id');
        var datatable = $('#kt_datatable').KTDatatable({
            // datasource definition
            data: {
                type: 'remote',
                source: HOST_URL + '/api/?data=user_transaction&id='+user_id,
                pageSize: 10,
            },

            // layout definition
            layout: {
                scroll: false, // enable/disable datatable scroll both horizontal and vertical when needed.
                footer: false // display/hide footer
            },

            // column sorting
            sortable: true,

            pagination: true,

            search: {
                input: $('#kt_datatable_search_query'),
                key: 'generalSearch'
            },

            // columns definition
            columns: [{
                field: 'transaction_id',
                title: 'Transaction ID',
            }, {
                field: 'gateway_transaction',
                title: 'Gateway ID',
            }, {
                field: 'username',
                title: 'Username',
            }, {
                field: 'amount',
                title: 'Amount',
            }, {
                field: 'datetime',
                title: 'Date & Time',
            }],

        });

        $('#kt_datatable_search_status').on('change', function() {
            datatable.search($(this).val().toLowerCase(), 'Status');
        });

        $('#kt_datatable_search_type').on('change', function() {
            datatable.search($(this).val().toLowerCase(), 'Type');
        });

        $('#kt_datatable_search_status, #kt_datatable_search_type').selectpicker();
    };

    return {
        // public functions
        init: function() {
            demo();
        }
    };
}();

jQuery(document).ready(function() {
    KTDatatableJsonRemoteDemo.init();
});
