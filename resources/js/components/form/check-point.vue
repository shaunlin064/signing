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
                    <li class="list-group-item" v-for='item in check_list'>
                        <div class='row'>
                            <div class='col-sm-3 col-align-c'>{{getMember(item.signed_member_id)}}</div>
                            <div class='col-sm-2 d-flex justify-content-center' v-html='statusBadge(item.status)'>}</div>
                            <div class='col-sm-7 col-align-l'>{{item.remark}}</div>
                        </div>

                        <!--                        <span class="badge badge-pill bg-primary float-right">4</span>-->

                    </li>
                </ul>
                <div class="card-body d-flex justify-content-end">
                    <div class='row'>
                        <button type="button" class="btn btn-primary mr-1 mb-1 waves-effect waves-light text-right" @click='confer("Confer")'>
                            <span role="status" aria-hidden="true" class="spinner-grow spinner-grow-sm"
                                  v-show='lodding'></span>
                            <strong>通過</strong>
                        </button>
                        <button type="button" class="btn btn-danger mr-1 mb-1 waves-effect waves-light text-right" @click='confer("Reject")'>
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
            check_list: Array,
        },
        data() {
            return {
                lodding: false
            }
        },
        computed: {
            ...mapState(['login_user', 'member', 'department', 'form_submit_data']),
        },
        beforeMount: function () {
        },
        mounted: function () {

        },
        methods: {
            getMember(id) {
                return getMember(id);
            },
            statusBadge(status) {
                let className = '';
                let html = '';
                switch (status) {
                    case 0:
                        className = 'danger'
                        html='駁回'
                        break;
                    case 1:
                        className = 'warning'
                        html='待簽核'
                        break;
                    case 2:
                        className = 'success'
                        html='通過'
                        break;
                    default:
                        className = 'secondary'
                        html='錯誤'
                        break;
                }
                return `<div class='badge badge-${className}'>${html}</div>`
            },
            confer(action){
                    let confirmButtonText = '';
                    let secondTitle = '';
                    switch (action) {
                        case 'Confer':
                            confirmButtonText = 'approve';
                            break;
                            case 'Reject':
                                confirmButtonText = 'approve';
                                break;
                    }
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        input: 'text',
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: `Yes, ${action} it!`,
                        confirmButtonClass: 'btn btn-primary',
                        cancelButtonClass: 'btn btn-danger ml-1',
                        buttonsStyling: false,
                    }).then(function (result) {
                        console.log(result);
                        if (result.value) {
                            Swal.fire({
                                type: "success",
                                title: `${action}!`,
                                text: `This From Apply has been ${action}.`,
                                confirmButtonClass: 'btn btn-success',
                            })
                        }
                        else if (result.dismiss === Swal.DismissReason.cancel) {
                            Swal.fire({
                                title: 'Cancelled',
                                text: 'This From Apply file is safe :)',
                                type: 'error',
                                confirmButtonClass: 'btn btn-success',
                            })
                        }
                    })
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
