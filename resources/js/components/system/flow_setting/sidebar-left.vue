<template>
    <div class="sidebar-content todo-sidebar d-flex">
        <span class="sidebar-close-icon">
        <i class="feather icon-x"></i>
        </span>
        <div class="todo-app-menu">
            <div class="form-group text-center add-task">
                <button type="button" class="btn btn-primary btn-block my-1"
                        @click='addSignatory'>新增關卡
                </button>
            </div>
            <div class="sidebar-menu-list">
                <hr>
                <h5 class="mt-2 mb-1 pt-25">表單</h5>
                <div class="list-group list-group-filters font-medium-1">
                    <a href="#" class="list-group-item list-group-item-action border-0" :class='classList(key)' @click='change'
                       :data-form_id='item["id"]' :data-form_type='item["html_name"]' v-for='(item,key) in form_config'>
                    <i class="font-medium-5 feather icon-info mr-50"></i>
                    {{item['name']}}</a>
                </div>
                <hr>
                <div class="form-group text-center add-task">
                    <button class="btn btn-primary btn-block my-1" @click='saveFlowData'>儲存
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
    import {mapState, mapMutations, mapActions, mapGetters} from 'vuex';
    import {apiGetFlow,apiSaveAllFlow} from '../../../src/apis/flow'
    import {apiFormChecking} from "../../../src/apis/form";
        export default {
            name: "sidebar-left",
            props: {
                form_config : Object
            },
            data() {
                return {
                    isActive: true,
                    form_type: 'form-payment',
                    form_id: '1',
                    evTimeStamp: 0,
                    can_post:false,
                }
            },
            computed: {
                    ...mapState(['flow_submit_data']),
            },
            beforeMount: function () {
            },
            mounted: function () {
                $('#form').submit(()=>{
                    this.can_post = true;
                })
            },
            methods: {
                setDefault(){
                    bus.$emit('setDefault',{form_id : this.form_id,form_type : this.form_type})
                },
                classList(key) {
                    if(key == 1 ){
                        this.getFlowData(this.form_id);
                        return {
                            active: this.isActive,
                        }
                    }
                },
                change(event){
                    if(this.form_id != event.currentTarget.dataset.form_id){
                        this.form_type = event.currentTarget.dataset.form_type;
                        this.form_id = event.currentTarget.dataset.form_id;
                        bus.$emit('loadingStart');
                        bus.$emit('listScroll');
                        this.getFlowData(this.form_id);
                    }
                },
                addSignatory(){
                    bus.$emit('addSignatory');
                },
                getFlowData(form_id){
                    let vue = this;
                    let now = +new Date();
                    bus.$emit('clean');
                    if (now - this.evTimeStamp > 100) {
                        this.evTimeStamp = now;
                        apiGetFlow({form_id}).then(function (response) {
                            let result = response.data;
                            if(vue.flow_submit_data[vue.form_type] === undefined){
                                vue.flow_submit_data[vue.form_type] = {};
                            }
                            result.data.map((v,key)=>{

                                ['created_at','deleted_at','updated_at','replace_member'].map(e=>{
                                    delete v[e];
                                })
                                vue.flow_submit_data[vue.form_type][key+1] = v;
                            })
                        }).then(()=>{
                            this.setDefault({form_id:this.form_id,form_type:this.form_type});
                            bus.$emit('loadingEnd');
                        });
                    }
                },
                saveFlowData(){
                    this.validateForm();
                    if(this.can_post){
                        this.swal();
                    }
                },
                swal(){
                    let swalConfig = {
                        title: '確認送出？',
                        text: "",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: `Yes`,
                        confirmButtonClass: 'btn btn-primary',
                        cancelButtonClass: 'btn btn-danger ml-1',
                        buttonsStyling: false,
                    }
                    swalConfig.preConfirm= (result) => {
                        let postData = {
                            form_id : this.form_id,
                            form_flow_data : this.flow_submit_data[this.form_type],
                        };

                        return apiSaveAllFlow(postData )
                            .then(function (response) {
                                return response.data;
                            })
                            .catch(function (error) {
                                Swal.showValidationMessage(
                                    `Request failed: ${error}`
                                )
                            });
                    };
                    Swal.fire(
                        swalConfig
                    ).then((result)=>{
                        if( result.value !== undefined){
                            this.swalSuccess(result);
                        }else{
                            this.swalCancel();
                        }
                    })
                },
                validateForm(){
                    /*驗證欄位*/
                    $('#submit').click();
                },
                swalCancel() {
                    Swal.fire({
                        title: 'Cancelled',
                        text: '已取消',
                        type: 'error',
                        confirmButtonClass: 'btn btn-success',
                    })
                },
                swalSuccess(result){
                    let type = result.value.status == 1 ? 'success' : 'error';
                    let timerInterval;

                    let swalConfig = {
                        type,
                        title : `${result.value.status_string}`,
                        html: ` ${result.value.message} <b></b>`,
                    }
                    if(result.value.status == 1){
                        swalConfig.timer = 1000;
                        swalConfig.onBeforeOpen = () => {
                            Swal.showLoading()
                            timerInterval = setInterval(() => {
                                const content = Swal.getContent()
                                if (content) {
                                    const b = content.querySelector('b')
                                    if (b) {
                                        b.textContent = Math.round(Swal.getTimerLeft() / 1000,1);
                                    }
                                }
                            }, 100)
                        };
                        swalConfig.onClose = () => {
                            clearInterval(timerInterval)
                        };
                    }else{
                        swalConfig.confirmButtonClass = 'btn btn-success';
                    }
                    Swal.fire( swalConfig
                    ).then(result=>{
                        if(type === 'success'){
                            // javascript:location.href = '/form-edit?id=' + this.form_id;
                        }
                    })
                },
            },
            updated() {
            },
            watch: {
                // can_post: {
                //     immediate: false,    // 这句重要
                //     handler(val, oldVal) {
                //         if(val){
                //             this.postData();
                //         }
                //     }
                // }
            }
        }
</script>

<style scoped>

</style>
