<template>
    <div>
        <div class="row">
            <div class="col-12">
                <div
                    class="ag-grid-btns d-flex justify-content-between flex-wrap mb-1"
                >
                    <div class="dropdown sort-dropdown mb-1 mb-sm-0">
                        <button
                            class="btn btn-white filter-btn dropdown-toggle border text-dark"
                            @click="openMenu"
                            type="button"
                            id="dropdownMenuButton6"
                            data-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false"

                        >
                            1 - 20 of 500
                        </button>
                        <div
                            class="dropdown-menu dropdown-menu-right"
                            aria-labelledby="dropdownMenuButton6"
                        >
                            <a class="dropdown-item" href="#" @click='changePageSize'>20</a>
                            <a class="dropdown-item" href="#" @click='changePageSize'>50</a>
                            <a class="dropdown-item" href="#" @click='changePageSize'>100</a>
                            <a class="dropdown-item" href="#" @click='changePageSize'>150</a>
                        </div>
                    </div>
                    <div class="ag-btns d-flex flex-wrap">
                        <input
                            type="text"
                            class="ag-grid-filter form-control w-50 mr-1 mb-1 mb-sm-0"
                            id="filter-text-box"
                            placeholder="Search...." @keyup='agFilter'
                        />
                        <div class="btn-export" v-show='btn_csv'>
                            <button class="btn btn-primary ag-grid-export-btn" @click='exportCSV'>
                                Export as CSV
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div :id="dom_id" class="aggrid ag-theme-material"></div>
    </div>
</template>

<script>
    import {mapState} from 'vuex';
    import {apiGetAllList, apiGetCheckList, apiGetUserCheckList} from '../src/apis/form.js';

    export default {
        name: "ag",
        props: {
            // column_defs : Array
            dom_id: String,
            api_urls: Array,
            api_parmater_role: Number,
        },
        data() {
            return {
                btn_csv: false,
                primary_key: '',
                config_column: [
                    {
                        headerName: "id",
                        field: "id",
                        editable: false,
                        sortable: true,
                        filter: true,
                        minWidth: 100,
                        // width: 120,
                    },
                    {
                        headerName: "類型",
                        field: "form_type",
                        editable: false,
                        sortable: true,
                        filter: true,
                        minWidth: 150,
                        // width: 150
                    },
                    {
                        headerName: "申請人",
                        field: "apply_member_id",
                        editable: false,
                        sortable: true,
                        filter: true,
                        minWidth: 150,
                        // width: 150,
                        cellRenderer: this.ageGetMember
                    },
                    {
                        headerName: "名稱",
                        field: "apply_subject",
                        editable: false,
                        sortable: true,
                        filter: true,
                        minWidth: 200,
                        // width: 330
                    },
                    {
                        headerName: "狀態",
                        field: "status_string",
                        editable: false,
                        sortable: true,
                        filter: true,
                        minWidth: 100,
                    },
                    {
                        headerName: "申請日期",
                        field: "apply_at",
                        editable: false,
                        sortable: true,
                        filter: true,
                        minWidth: 150,
                    },
                    {
                        headerName: "Action",
                        field: "action",
                        cellRenderer: this.ageCellRendererFunc,
                        minWidth: 150,
                    }
                ],
                gridOptions: {
                    columnDefs: [],
                    // rowSelection: "multiple",
                    // minWidth: 1000,
                    floatingFilter: true,
                    filter: true,
                    pagination: true,
                    paginationPageSize: 20,
                    pivotPanelShow: "always",
                    colResizeDefault: "shift",
                    animateRows: true,
                    enableSorting: true,
                    suppressSizeToFit: true,
                    resizable: true,
                    suppressHorizontalScroll: true,
                }
            }
        },
        computed: {
            ...mapState(['login_user', 'member', 'department']),
        },
        beforeMount: function () {
        },
        mounted: function () {
            this.init();
            //    ag-root-wrapper ag-layout-normal ag-ltr
            //    ag-root-wrapper-body ag-layout-normal
        },
        methods: {
            init() {
                if ($.inArray(this.dom_id, ['ag_pending', 'ag_action']) !== -1) {
                    this.config_column[0]['field'] = 'form_apply_id';
                    this.primary_key = 'form_apply_id';
                } else {
                    this.primary_key = 'id';
                }

                this.gridOptions.columnDefs = this.config_column;
                this.getData();
            },
            getLoginUser() {
                return this.login_user.id;
            },
            agSetting(response) {
                var gridTable = document.getElementById(this.dom_id);
                this.gridOptions.rowData = response.data.data;
                /*** INIT TABLE ***/
                new agGrid.Grid(gridTable, this.gridOptions);
                this.gridOptions.api.sizeColumnsToFit();
            },
            getData() {
                let userId = this.getLoginUser();

                let vue = this;
                let params = {
                    member_id: userId,
                    role: vue.api_parmater_role,
                };
                /*** GET TABLE DATA FROM URL ***/

                switch (vue.dom_id) {
                    case 'ag_pending' :
                    case 'ag_action':
                        apiGetCheckList(params).then(function (response) {
                            vue.agSetting(response)
                        });
                        break;
                    case 'ag_user_list':
                        apiGetUserCheckList(params).then(function (response) {
                            vue.agSetting(response)
                        });
                        break;
                    case 'ag_all':
                        apiGetAllList(params).then(function (response) {
                            vue.agSetting(response)
                        });
                        break;
                }
            },
            ageGetMember(params) {
                return getMember(params.data.apply_member_id);
            },
            ageCellRendererFunc(params) {
                let id = eval(`params.data.${this.primary_key}`);

                let template;
                template = `<a type='button' target='_blank' href='/form-edit?id=${id}' class='btn btn-primary mr-1  waves-effect waves-light'>檢視</a>`;

                return template;
            },
            updateSearchQuery(val) {
                this.gridOptions.api.setQuickFilter(val);
            },
            openMenu(event) {
                let targetDom = $(event.currentTarget);
                targetDom.parent('.dropdown').addClass('show');
                targetDom.next().addClass('show');
            },
            agFilter(event) {
                let $targetDom = $(event.currentTarget);
                this.updateSearchQuery($targetDom.val());
            },
            changePageSize(event) {
                let $targetDom = $(event.currentTarget);
                this.gridOptions.api.paginationSetPageSize(Number($targetDom.text()));
                $(".filter-btn").text("1 - " + $targetDom.text() + " of 500");
            },
            exportCSV() {
                this.gridOptions.api.exportDataAsCsv();
            }
        },
        updated() {
            // console.log('view updated')
        },
        watch: {
            // change_date: {
            //     immediate: true,    // 这句重要
            //     handler(val, oldVal) {
            //         if (oldVal !== undefined) {
            //             this.getCampaignData(this.user_ids, val);
            //         }
            //     }
            // }
        }
    }
</script>

<style scoped>

</style>
