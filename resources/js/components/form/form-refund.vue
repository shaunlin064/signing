<template>
    <fieldset>
        <div class="row col-md-12 align-items-center">
            <div class="card">
                <h4 class="card-title">代墊申請</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-label-group">
                    <input type="text" id="member" class="form-control"
                           placeholder="申請人" name="member">
                    <label for="member">申請人</label>
                </div>
            </div>
            <div class='col-md-6'>
                <div class="form-label-group">
                    <input type="text" id="department" class="form-control"
                           placeholder="部門" name="department">
                    <label for="department">部門</label>
                </div>
            </div>
        </div>
        <div class="row justify-content-center border-top-light mt-2">
            <div class="row col-md-12">
                <div class="card mt-2">
                    <h4 class="card-title">項目</h4>
                </div>
            </div>
            <component v-for="item in items" v-bind:is="item.type" :key='item.id' :id='item.id' :type='item.form'></component>
            <div class='row col-md-12 justify-content-end border-top-light'>

                <div class='col-md-4 text-right mt-1'>
                    <div class="btn-group dropdown mr-1 mb-1">
                        <button type="button" class="btn btn-outline-primary dropdown-toggle" @click='openMenu' data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                            新增
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" @click='addItem("乘車")'>乘車</a>
                            <a class="dropdown-item" @click='addItem("案件")'>案件</a>
                            <a class="dropdown-item" @click='addItem("交際")'>交際</a>
                            <a class="dropdown-item" @click='addItem("其他")'>其他</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class='col-md-12 mt-2'>
                <fieldset class="form-label-group">
                              <textarea class="form-control" id="remark" rows="3" placeholder="備註"
                                        name="remark"></textarea>
                    <label for="remark">備註</label>
                </fieldset>
            </div>
        </div>
    </fieldset>
</template>

<script>
    import {mapState, mapMutations, mapActions, mapGetters} from 'vuex';
        export default {
            name: "form-refund",
            props: {

            },
            data() {
                return {
                    items: [],
                    count: 0
                }
            },
            computed: {
                    ...mapState([]),
            },
            beforeMount: function () {
            },
            mounted: function () {
                var vue = this;
                $('.row').on('click','[data-action="deleteItem"]',function(e){
                    vue.deleteItem(e);
                });
                this.initial();
            },
            methods: {
                initial(){
                    $(".select2").select2({
                        dropdownAutoWidth: true,
                        width: '100%'
                    });
                },
                deleteItem(event){
                    $(event.currentTarget).parents('.row.col-md-12').remove();
                },
                openMenu(event){
                    let targetDom = $(event.currentTarget);
                    targetDom.parent('.btn-group').addClass('show');
                    targetDom.next().addClass('show');
                },
                addItem(type){

                    this.items.push({
                        type: 'form-refund-items',
                        form:type,
                        id: this.count++
                    });

                    this.initial();
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
