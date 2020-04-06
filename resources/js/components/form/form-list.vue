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
                            <a class="dropdown-item" href="#">20</a>
                            <a class="dropdown-item" href="#">50</a>
                            <a class="dropdown-item" href="#">100</a>
                            <a class="dropdown-item" href="#">150</a>
                        </div>
                    </div>
                    <div class="ag-btns d-flex flex-wrap">
                        <input
                            type="text"
                            class="ag-grid-filter form-control w-50 mr-1 mb-1 mb-sm-0"
                            id="filter-text-box"
                            placeholder="Search...."
                        />
                        <div class="btn-export">
                            <button class="btn btn-primary ag-grid-export-btn">
                                Export as CSV
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="myGrid" class="aggrid ag-theme-material"></div>
    </div>
</template>

<script>
    import {mapState, mapMutations, mapActions, mapGetters} from 'vuex';

        export default {
            name: "form_list",
            props: {

            },
            data() {
                return {}
            },
            computed: {
                    ...mapState([]),
            },
            beforeMount: function () {
            },
            mounted: function () {

            },
            methods: {
                openMenu(event){
                    let targetDom = $(event.currentTarget);
                    targetDom.parent('.dropdown').addClass('show');
                    targetDom.next().addClass('show');
                },
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
