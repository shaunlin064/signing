<template>
    <fieldset :id='dom_id'>
        <div class="row col-md-12 align-items-center">
            <div class="card">
                <h4 class="card-title">代墊申請</h4>
            </div>
            <div class='card-body row justify-content-end'>
                <div class="modal-info mr-1 mb-1 d-inline-block">
                    <button type="button" class="btn btn-outline-info" data-toggle="modal" data-target="#info">
                        注意事項
                    </button>

                    <div class="modal fade text-left" id="info" tabindex="-1" role="dialog"
                         aria-labelledby="myModalLabel130" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-info white">
                                    <h5 class="modal-title" id="myModalLabel130">Info</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <br class="modal-body">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <h4 class="card-title">表單填寫事項</h4>
                                            <p class="card-text">
                                                申請代墊時間為每月 5 號前,提供前月份交際及交通費代墊申請。<br><br>
                                                欲申請代墊者,請依照以下表格填寫步驟填寫代墊申請表,並檢附所有相關憑證。<br><br>
                                                註 交際相關申請,將於月底由執行長室 Ravin 歸還申請人。<br><br>
                                                代墊申請完成後,請提交回執行長室 Ravin。<br><br>
                                            </p>
                                        </div>
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item">
                                                交際,請款類別代墊, 請確實填上編號
                                            </li>
                                        </ul>
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item">
                                                交通費之類別代墊。<br><br>
                                                Ex. 油資、停車費、大眾運輸工具車費...等。<br><br>
                                                註 交通費(含乘車券)總計不得超過 3000 元。<br><br>
                                            </li>
                                        </ul>
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item">
                                                附件應包括交際申請單含憑證、交通費憑證。
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-info" data-dismiss="modal">Accept</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class='row col-md-12 justify-content-end mb-2'>
                <div class='mr-2' v-if='id'>id：{{id}}</div>
                <div>申請日期：{{form_submit_data[dom_id]['created_at']}}</div>
            </div>
            <div class="col-md-6">
                <div class="form-label-group">
                    <input type="text" id="department" class="form-control" placeholder="部門" :value='department_name'
                           disabled>
                    <label for="department">部門</label>
                </div>
            </div>
            <div class='col-md-6'>
                <div class="form-label-group">
                    <input type="text" id="member" class="form-control" placeholder="申請人" :value='member_name' disabled>
                    <label for="member">申請人</label>
                </div>
            </div>
<!--            <div class="col-md-6">-->
<!--                <div class="form-label-group">-->
<!--                    <input type="text" id="apply_subject" class="form-control" placeholder="名稱" name="apply_subject"-->
<!--                           v-model='form_submit_data[dom_id]["apply_subject"]' :disabled='can_edit === false' required>-->
<!--                    <label for="apply_subject">名稱</label>-->
<!--                </div>-->
<!--            </div>-->
        </div>
        <div class="row justify-content-center border-top-light mt-2">
            <div class="row col-md-12">
                <div class="card mt-2">
                    <h4 class="card-title">項目</h4>
                </div>
            </div>
            <component v-for="(item,key) in items" v-bind:is="item.component" :id='parseInt(item.id)' :dom_id='dom_id'
                       :key='item.id'
                       :type='item.type' :form_action='form_action' :can_edit='can_edit'></component>
            <div class='row col-md-12 justify-content-end border-top-light' v-show='can_edit'>
                <div class='col-md-4 text-right mt-1'>
                    <div class="btn-group dropdown mr-1 mb-1">
                        <button type="button" class="btn btn-outline-primary dropdown-toggle" @click='openMenu'
                                data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                            新增
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" @click='addItem(item)' v-for='item in refund_type'>{{item}}</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <h4 class="card-title">金額統計</h4>
                            <p class="card-text"></p>
                        </div>
                        <div class="card-body row">
                            <div class="col-xl-2 col-md-4 col-sm-6">
                                <div class="card text-center">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="avatar bg-rgba-info p-50 m-0 mb-1">
                                                <div class="avatar-content">
                                                    <i class="feather icon-shopping-cart text-info font-medium-5"></i>
                                                </div>
                                            </div>
                                            <h2 class="text-bold-700">{{refund_total.乘車}}</h2>
                                            <p class="mb-0 line-ellipsis">乘車</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-2 col-md-4 col-sm-6">
                                <div class="card text-center">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="avatar bg-rgba-warning p-50 m-0 mb-1">
                                                <div class="avatar-content">
                                                    <i class="feather icon-clipboard text-warning font-medium-5"></i>
                                                </div>
                                            </div>
                                            <h2 class="text-bold-700">{{refund_total.案件}}</h2>
                                            <p class="mb-0 line-ellipsis">案件</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-2 col-md-4 col-sm-6">
                                <div class="card text-center">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="avatar bg-rgba-danger p-50 m-0 mb-1">
                                                <div class="avatar-content">
                                                    <i class="feather icon-users text-danger font-medium-5"></i>
                                                </div>
                                            </div>
                                            <h2 class="text-bold-700">{{refund_total.交際}}</h2>
                                            <p class="mb-0 line-ellipsis">交際</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-2 col-md-4 col-sm-6">
                                <div class="card text-center">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="avatar bg-rgba-primary p-50 m-0 mb-1">
                                                <div class="avatar-content">
                                                    <i class="feather icon-heart text-primary font-medium-5"></i>
                                                </div>
                                            </div>
                                            <h2 class="text-bold-700">{{refund_total['其他']}}</h2>
                                            <p class="mb-0 line-ellipsis">其他</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-2 col-md-4 col-sm-6">
                                <div class="card text-center">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="avatar bg-rgba-primary p-50 m-0 mb-1">
                                                <div class="avatar-content">
                                                    <i class="feather icon-trending-up text-primary font-medium-5"></i>
                                                </div>
                                            </div>
                                            <h2 class="text-bold-700">{{refund_total.total}}</h2>
                                            <p class="mb-0 line-ellipsis">總計</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class='col-md-12 mt-2'>
                <fieldset class="form-label-group">
                              <textarea class="form-control" id="remark" rows="1" placeholder="備註"
                                        v-model='form_submit_data[dom_id]["remark"]' :disabled='can_edit === false'
                                        name="remark"></textarea>
                    <label for="remark">備註</label>
                </fieldset>
            </div>
            <div class="col-md-12 mt-1">
                <div class="form-group">
                    <input class="dropzone dropzone-area" type="hidden"/>
                    <div class="dropzone dropzone-area" id="file_upload">
                        <div class="dz-message">Drop Files Here To Upload</div>
                    </div>
                </div>
            </div>
        </div>
    </fieldset>
</template>

<script>
    import {mapState} from 'vuex';

    export default {
        name: "form-refund",
        props: {
            dom_id: String,
            form_data: Object,
            form_action: String,
            can_edit: Boolean,
            id:Number,
        },
        data() {
            return {
                refund_type: [
                    '乘車', '案件', '交際', '其他'
                ],
                refund_total:{
                  '乘車' : 0, '案件' : 0, '交際' : 0, '其他': 0, 'total' : 0
                },
                member_name: '',
                department_name: '',
                items: [],
                count: -1
            }
        },
        computed: {
            ...mapState(['form_submit_data', 'login_user', 'member', 'department']),
        },
        beforeMount: function () {
        },
        mounted: function () {
            this.initial();
        },
        methods: {
            count_total(){
                let count = 0;
                let formItemData = this.form_submit_data[this.dom_id]['items'];
                let vue = this;
                Object.keys(vue.refund_total).forEach(key => {
                    vue.refund_total[key] = 0;
                });
                Object.keys(formItemData).forEach(key => {
                    let type = formItemData[key]['type'];
                    count += parseInt(formItemData[key]['price']);
                    vue.refund_total[type]+= parseInt(formItemData[key]['price']);
                });
                vue.refund_total['total'] = count;
            },
            initial() {
                let vue = this;
                vue.count_total();

                $('.row').on('click', '[data-action="deleteItem"]', function (e) {
                    vue.deleteItem(e);
                });
                $('.row').on('change', '.form-control.price', function (e) {
                    vue.count_total();
                });

                if (this.form_action === 'new') {
                    this.department_name = this.login_user.department;
                    this.member_name = this.login_user.name;
                } else {
                    this.department_name = getDepartment(this.form_submit_data[this.dom_id]['apply_department_id']);
                    this.member_name = getMember(this.form_submit_data[this.dom_id]['apply_member_id']);
                    let itemsData = this.form_submit_data[this.dom_id]['items'];
                    Object.keys(itemsData).forEach(key => {
                        let tmpdata = Object.assign({}, itemsData[key]);
                        tmpdata.component = 'form-refund-items';
                        tmpdata.can_edit = vue.can_edit;
                        vue.items.push(tmpdata);
                        vue.count = tmpdata.id;
                    });
                }
            },
            deleteItem(event) {
                // $(event.currentTarget).parents('.row.col-md-12').remove();
                let id = $(event.currentTarget).data('id');
                let vue = this;
                this.items.map((e, k) => {
                    if (e.id === id) {
                        vue.items.splice(k, 1);
                        // vue.form_submit_data[vue.dom_id]["items"].splice(k,1);
                        delete vue.form_submit_data[vue.dom_id]["items"][id];
                    }

                });

            },
            openMenu(event) {
                let targetDom = $(event.currentTarget);
                targetDom.parent('.btn-group').addClass('show');
                targetDom.next().addClass('show');
            },
            addItem(type) {
                this.count++;

                this.items.push({
                    component: 'form-refund-items',
                    type: type,
                    id: this.count,
                });

                // let defaultColumn = {
                //     id: this.count.toString(),
                //     type: type,
                //     date: '',
                //     name: '',
                //     price: '',
                // };
                // switch (type) {
                //     case '乘車':
                //         defaultColumn.get_on_start = '';
                //         break;
                //     case '案件':
                //         defaultColumn.campaign_id = '';
                //         break;
                //     case '交際':
                //         defaultColumn.form_pair_data_id = '';
                //         break;
                //     case '其他':
                //         break;
                // }
                // this.form_submit_data[this.dom_id]["items"][this.count] = defaultColumn;

                this.form_submit_data[this.dom_id]["items"][this.count] = {
                    id: this.count.toString(),
                    type: type,
                    date: '',
                    name: '',
                    get_on_start: '',
                    campaign_id: '',
                    form_pair_data_id: '',
                    price: '',
                };
            }
        },
        updated() {

        },
        watch: {
            // change_date: {
            //     immediate: true,
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
