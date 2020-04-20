$(document).ready(function() {
    /*** COLUMN DEFINE ***/
    var columnDefs = [
        {
            headerName: "id",
            field: "id",
            editable: false,
            sortable: true,
            filter: true,
            width:120,
            // checkboxSelection: true,
            // headerCheckboxSelectionFilteredOnly: true,
            // headerCheckboxSelection: true
        },
        {
            headerName: "類型",
            field: "form_type",
            editable: false,
            sortable: true,
            filter: true,
            width:150
        },

        // {
        //     headerName: "部門",
        //     field: "department",
        //     editable: false,
        //     sortable: true,
        //     filter: true
        // },
        {
            headerName: "申請人",
            field: "apply_member_id",
            editable: false,
            sortable: true,
            filter: true,
            width:150,
            cellRenderer: ageGetMember
        },
        {
            headerName: "名稱",
            field: "apply_subject",
            editable: false,
            sortable: true,
            filter: true,
            width:330
        },
        {
            headerName: "狀態",
            field: "status_string",
            editable: false,
            sortable: true,
            filter: true
        },
        {
            headerName: "申請日期",
            field: "created_at_format",
            editable: false,
            sortable: true,
            filter: true
        },
        {
            headerName: "Action",
            field: "action",
            cellRenderer: ageCellRendererFunc
            // editable: false,
            // sortable: true,
            // filter: true
        }
    ];

    /*** GRID OPTIONS ***/
    var gridOptions = {
        columnDefs: columnDefs,
        // rowSelection: "multiple",
        floatingFilter: true,
        filter: true,
        pagination: true,
        paginationPageSize: 20,
        pivotPanelShow: "always",
        colResizeDefault: "shift",
        animateRows: true,
        resizable: true
    };

    /*** DEFINED TABLE VARIABLE ***/
    var gridTable = document.getElementById("myGrid");
    function ageGetMember(params) {
        return getMember(params.data.apply_member_id);
    }
    function ageCellRendererFunc(params) {
        // params.$scope.ageClicked = ageClicked;
        //return '<button ng-click="ageClicked(data.age)" ng-bind="data.age"></button>';

        // let status = params.data.action;
        let template;

        template = `<a type="button" target='_blank' href="/form-edit?id=${params.data.id}" class="btn btn-primary mr-1  waves-effect waves-light">檢視</a>`;

        return template;
    }
    /*TODO:: login data*/
    let userId = 157;
    /*** GET TABLE DATA FROM URL ***/
    axios.post('api/form/user/list', {
        member_id:userId
    })
        .then(function (response) {
            gridOptions.rowData = response.data.data;
            /*** INIT TABLE ***/
            new agGrid.Grid(gridTable, gridOptions);
            console.log(response.data.data);
        })
        .catch(function (error) {
            console.log(error);
        });
    // agGrid
    //     .simpleHttpRequest({ url: "data/form-data.json" })
    //     .then(function(data) {
    //         gridOptions.api.setRowData(data);
    //     });

    /*** FILTER TABLE ***/
    function updateSearchQuery(val) {
        gridOptions.api.setQuickFilter(val);
    }

    $(".ag-grid-filter").on("keyup", function() {
        updateSearchQuery($(this).val());
    });

    /*** CHANGE DATA PER PAGE ***/
    function changePageSize(value) {
        gridOptions.api.paginationSetPageSize(Number(value));
    }

    $(".sort-dropdown .dropdown-item").on("click", function() {
        var $this = $(this);
        changePageSize($this.text());
        $(".filter-btn").text("1 - " + $this.text() + " of 500");
    });

    /*** EXPORT AS CSV BTN ***/
    $(".ag-grid-export-btn").on("click", function(params) {
        gridOptions.api.exportDataAsCsv();
    });

    // /*** INIT TABLE ***/
    // new agGrid.Grid(gridTable, gridOptions);

    /*** SET OR REMOVE EMAIL AS PINNED DEPENDING ON DEVICE SIZE ***/

    // if ($(window).width() < 768) {
    //     gridOptions.columnApi.setColumnPinned("id", null);
    // } else {
    //     gridOptions.columnApi.setColumnPinned("id", "left");
    // }
    // $(window).on("resize", function() {
    //     if ($(window).width() < 768) {
    //         gridOptions.columnApi.setColumnPinned("id", null);
    //     } else {
    //         gridOptions.columnApi.setColumnPinned("id", "left");
    //     }
    // });
});


