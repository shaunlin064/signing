<template>
    <div class="col-lg-6 col-12 p-0">
        <div class="card rounded-0 mb-0 px-2">
            <div class="card-header pb-1">
                <div class="card-title">
                    <h4 class="mb-0">Login</h4>
                </div>
            </div>
            <p class="px-2">Welcome back, please login to your account.</p>
            <div class="card-content">
                <div class="card-body pt-1">
                    <form action="">
                        <fieldset class="form-label-group form-group position-relative has-icon-left">
                            <input type="text" class="form-control" id="user-name" placeholder="Username"
                                   v-model='account' required>
                            <div class="form-control-position">
                                <i class="feather icon-user"></i>
                            </div>
                            <label for="user-name">Username</label>
                        </fieldset>

                        <fieldset class="form-label-group position-relative has-icon-left">
                            <input type="password" class="form-control" id="user-password" placeholder="Password"
                                   v-model='password' required>
                            <div class="form-control-position">
                                <i class="feather icon-lock"></i>
                            </div>
                            <label for="user-password">Password</label>
                        </fieldset>
                        <div class="form-group d-flex justify-content-between align-items-center">
                            <div class="text-left">
                                <fieldset class="checkbox">
                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                        <input type="checkbox">
                                        <span class="vs-checkbox">
                                                <span class="vs-checkbox--check">
                                                  <i class="vs-icon feather icon-check"></i>
                                                </span>
                                              </span>
                                        <span class="">Remember me</span>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary float-right btn-inline" @click='login' :disabled='lodding'>
                            <span role="status" aria-hidden="true" class="spinner-grow spinner-grow-sm" v-show='lodding'></span>
                            Login</button>
                    </form>
                </div>
            </div>
            <div class="login-footer">

            </div>
        </div>
    </div>
</template>

<script>
    /*TODO::alert UI 優化與 轉跳訊息*/
    import {mapState} from 'vuex';

    export default {
        name: "login",
        props: {},
        data() {
            return {
                account: '',
                password: '',
                lodding : false,
                response: {},
            }
        },
        computed: {
            ...mapState([]),
        },
        beforeMount: function () {
        },
        mounted: function () {

        },
        methods: {
            validate(){
                if(this.response.status != 200 || this.response.status === undefined || this.response.data === undefined){
                    alert('系統錯誤無法登入,請聯繫管理員');
                    this.lodding = false;
                    return false;
                }
                if(this.response.data.status != 1 ){
                    alert('密碼錯誤');
                    this.lodding = false;
                    return false;
                }
                if(this.response.data.data.login_user === undefined ||  this.response.data.data.member === undefined || this.response.data.data.department === undefined){
                    alert('系統錯誤無法登入,請聯繫管理員');
                    this.lodding = false;
                    return false;
                }
                return true;
            },
            login() {
                if(this.account  === '' || this.password === ''){
                   return;
                }
                this.lodding = true;
                let password = MD5(this.password);
                let account = this.account;
                let vue = this;
                axios.post('api/system/login', {
                    account,
                    password
                })
                    .then(function (response) {
                        vue.response = response;
                        if(vue.validate()){
                            sessionStorage.setItem('login_user', JSON.stringify(response.data.data.login_user));
                            sessionStorage.setItem('member', JSON.stringify(response.data.data.member));
                            sessionStorage.setItem('department', JSON.stringify(response.data.data.department));
                            javascript:location.href='/';
                        }
                    })
                    .catch(function (error) {
                        console.log(error);
                    });

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
