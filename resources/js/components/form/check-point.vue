<template>
    <div class="col-sm-12">
        <div class="card">
            <div class="card-content">
                <div class="card-body">
                    <h4 class="card-title">Signing List</h4>
                    <!--                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of-->
                    <!--                        the card's content.</p>-->
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item" v-for='item in check_list' @model='check_list'>
                        <div class='row'>
                            <div class='col-sm-3 col-align-c'>{{getMember(item.signed_member_id)}}</div>
                            <div class='col-sm-2 d-flex justify-content-center' v-html='statusBadge(item.status)'>}
                            </div>
                            <div class='col-sm-7 col-align-l'>{{item.remark}}</div>
                        </div>

                        <!--                        <span class="badge badge-pill bg-primary float-right">4</span>-->

                    </li>
                </ul>
                <div class="card-body d-flex justify-content-end">
                    <div class='row'>
                        <button type="button" class="btn btn-primary mr-1 mb-1 waves-effect waves-light text-right"
                                @click='confer("Confer")'>
                            <span role="status" aria-hidden="true" class="spinner-grow spinner-grow-sm"
                                  v-show='lodding'></span>
                            <strong>通過</strong>
                        </button>
                        <button type="button" class="btn btn-danger mr-1 mb-1 waves-effect waves-light text-right"
                                @click='confer("Reject")'>
                            <span role="status" aria-hidden="true" class="spinner-grow spinner-grow-sm"
                                  v-show='lodding'></span>
                            <strong>駁回</strong>
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapState} from 'vuex';

    export default {
        name: "check-point",
        props: {
            check_list_props: Array,
            form_id: Number,
        },
        data() {
            return {
                lodding: false,
                check_list: null,
            }
        },
        computed: {
            ...mapState(['login_user', 'member', 'department', 'form_submit_data']),
        },
        beforeMount: function () {
        },
        mounted: function () {
            this.getCheck();
        },
        methods: {
            async getCheck() {
                while (this.check_list === null) {
                    this.check_list = await this.settime();
                }
            },
            settime() {
                let vue = this;
                return new Promise((resolve, reject) => {
                    setTimeout(() => {
                        resolve(vue.check_list_props)
                    }, 500)
                });
            },
            getMember(id) {
                return getMember(id);
            },
            statusBadge(status) {
                let className = '';
                let html = '';
                switch (status) {
                    case 0:
                        className = 'danger'
                        html = '駁回'
                        break;
                    case 1:
                        className = 'warning'
                        html = '待簽核'
                        break;
                    case 2:
                        className = 'success'
                        html = '通過'
                        break;
                    default:
                        className = 'secondary'
                        html = '錯誤'
                        break;
                }
                return `<div class='badge badge-${className}'>${html}</div>`
            },
            post(action, remark = null) {
                let status = action == 'Confer' ? 2 : 0;
                let postData = {
                    id: this.form_id,
                    member_id: this.login_user.id,
                    signature: '',
                    remark,
                    status
                }
                return axios.post('api/form/check', postData)
                    .then(function (response) {
                       console.log(response);
                       return response
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            async confer(action) {
                let vue = this;
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: `Yes, ${action} it!`,
                    confirmButtonClass: 'btn btn-primary',
                    cancelButtonClass: 'btn btn-danger ml-1',
                    buttonsStyling: false,
                }).then(async function (result) {

                    if (result.value) {
                        if (action === 'Confer') {
                            let result = await vue.post(action);
                            console.log(result);

                            Swal.fire({
                                type: "success",
                                title: `${action}!`,
                                text: `This From Apply has been ${action}.`,
                                confirmButtonClass: 'btn btn-success',
                            })
                        } else {
                            Swal.fire({
                                title: `${action}`,
                                text: "請輸入原因",
                                type: 'question',
                                input: 'text',
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: `送出`,
                                confirmButtonClass: 'btn btn-primary',
                                buttonsStyling: false,
                                inputValidator: (value) => {
                                    if (!value) {
                                        return 'You need to write something!'
                                    }
                                }
                            })
                                .then(function (result) {
                                    /*TODO::form check api*/
                                    if (result.dismiss === Swal.DismissReason.cancel || result.dismiss === 'backdrop') {
                                        Swal.fire({
                                            title: 'Cancelled',
                                            text: 'This From Apply file is safe :)',
                                            type: 'error',
                                            confirmButtonClass: 'btn btn-success',
                                        })
                                    } else {
                                        Swal.fire({
                                            type: "success",
                                            title: `${action}!`,
                                            text: `This From Apply has been ${action}.`,
                                            confirmButtonClass: 'btn btn-success',
                                        })
                                    }
                                })
                        }
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        Swal.fire({
                            title: 'Cancelled',
                            text: 'This From Apply file is safe :)',
                            type: 'error',
                            confirmButtonClass: 'btn btn-success',
                        })
                    }
                })
            }
        }
        ,
        updated() {
            // console.log('view updated')

        }
        ,
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
