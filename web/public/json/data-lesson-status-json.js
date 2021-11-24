"use strict";
// Class definition

var KTDatatableJsonRemoteDemo = function() {
    // Private functions

    // basic demo
    var demo = function() {
        var user_id = $('#kt_datatable').attr("user_id");
        var datatable = $('#kt_datatable').KTDatatable({
            // datasource definition
            data: {
                type: 'remote',
                source: HOST_URL + '/api/?data=lesson_status&user_id='+user_id,
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
                field: 'userid',
                title: 'User ID',
            }, {
                field: 'Name',
                title: 'Name',
                template: function(row) {
                    return row.firstname + ' ' + row.lastname;
                },
            }, {
                field: 'Group',
                title: 'Group',
                template: function(row) {
                    if(row.usergroup == '1') {
                        return 'Admin';
                    } else {
                        return 'User';
                    }
                },
            }, {
                field: 'lesson_title',
                title: 'Lesson'
            }, {
                field: 'lesson_status_time',
                title: 'Time'
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
