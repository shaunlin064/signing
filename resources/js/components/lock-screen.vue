<template>
    <div class='lock-screen-mask' v-show='over_time'>
        <section class="row d-flex justify-content-center lock-screen-content">
            <div class="col-xl-7 col-10 d-flex justify-content-center">
                <div class="card bg-authentication rounded-0 mb-0 w-100">
                    <div class="row m-0">
                        <div class="col-lg-6 d-lg-block d-none text-center align-self-center px-1 py-0">
                            <img src="images/pages/lock-screen.png" alt="branding logo">
                        </div>
                        <div class="col-lg-6 col-12 p-0">
                            <div class="card rounded-0 mb-0 px-2 pb-2">
                                <div class="card-header pb-1">
                                    <div class="card-title">
                                        <h4 class="mb-0">閒置過久鎖定</h4>
                                    </div>
                                </div>
                                <div class="card-content">
                                    <div class="card-body pt-1">
                                        <form action="#">
                                            <fieldset class="form-label-group position-relative has-icon-left">
                                                <input type="text" class="form-control" id="user-name" placeholder="account" disabled v-model='account'>
                                                <div class="form-control-position">
                                                    <i class="feather icon-user"></i>
                                                </div>
                                                <label for="user-name">Username</label>
                                            </fieldset>

                                            <fieldset class="form-label-group position-relative has-icon-left">
                                                <input type="password" class="form-control" id="user-password" placeholder="Password" required v-model='password' @keyup.enter='login' :class='invalid'>
                                                <div class="form-control-position">
                                                    <i class="feather icon-lock"></i>
                                                </div>
                                                <label for="user-password">Password</label>
                                                <div class="invalid-feedback" v-show='password_error'>
                                                    {{password_error}}
                                                </div>
                                            </fieldset>
                                            <a href="/login">Are you not {{account.toUpperCase()}} ?</a>
                                            <button type="button" class="btn btn-primary float-right" :disabled='lodding' @click='login'> <span role="status" aria-hidden="true" class="spinner-grow spinner-grow-sm" v-show='lodding'></span>
                                                Unlock</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
    import {mapState, mapMutations, mapActions, mapGetters} from 'vuex';
    import {apiSessionPut,apiSessionGet} from '../src/apis/system.js'
    import {apiAuthLogin} from '../src/apis/auth'
        export default {
            name: "lock-screen",
            props: {

            },
            data() {
                return {
                    over_time : false,
                    account: '',
                    password: '',
                    lodding : false,
                    response: {},
                    invalid: '',
                    password_error : ''
                }
            },
            computed: {
                    ...mapState(['login_user']),
            },
            beforeMount: function () {
            },
            mounted: function () {
                this.asyncGet();
                this.account = this.login_user.name.toLowerCase();

            },
            methods: {
                async asyncGet() {
                    this.over_time = await this.settime();
                    if(this.over_time){
                        $('html, body').animate({scrollTop : 0},0);
                        this.logout();
                    }
                },
                settime() {
                    return new Promise((resolve, reject) => {
                        setTimeout(() => {
                            resolve(true)
                        }, 30 * 60000)
                    });
                },
                validate(){
                    if(this.response.status != 200 || this.response.status === undefined || this.response.data === undefined){
                        this.invalid = 'is-invalid';
                        this.password_error = '系統錯誤無法登入,請聯繫管理員';
                        this.lodding = false;
                        return false;
                    }
                    if(this.response.data.status != 1 ){
                        this.invalid = 'is-invalid';
                        this.password_error = '密碼錯誤';
                        this.lodding = false;
                        return false;
                    }
                    if(this.response.data.data.login_user === undefined ||  this.response.data.data.member === undefined || this.response.data.data.department === undefined){
                        this.invalid = 'is-invalid';
                        this.password_error = '系統錯誤無法登入,請聯繫管理員';
                        this.lodding = false;
                        return false;
                    }
                    return true;
                },
                login() {
                    if(this.account  === '' || this.password === ''){
                        this.invalid = 'is-invalid';
                        this.password_error = '密碼不能為空';
                        return;
                    }else{
                        this.invalid = '';
                        this.password_error = '';
                    }
                    this.lodding = true;
                    let password = MD5(this.password);
                    let account = this.account;
                    let vue = this;

                    apiAuthLogin({
                        account,
                        password
                    })
                        .then(function (response) {
                            vue.response = response;
                            if(vue.validate()){
                                //重新存入新session
                                vue.putSession(response.data.data);
                                vue.over_time = false;
                                vue.lodding = false;
                                //重新計時
                                $('body').css({'overflow':''});
                                vue.asyncGet();
                                vue.password = '';
                            }
                        })
                        .catch(function (error) {
                            console.log(error);
                        });

                },
                putSession(loginResponse){
                    apiSessionPut({value:loginResponse});
                },
                getsession(){
                    apiSessionGet({key:'login_user'});
                },
                logout(){
                    $('body').css({'overflow':'hidden'});
                    // axios({
                    //     url: 'session/release',
                    //     method: 'post',
                    //     headers: {
                    //         'Content-Type': 'application/json',
                    //     }
                    // }).then(
                    //     (res)=>{
                    //         $('body').css({'overflow':'hidden'});
                    //     }
                    // ).catch(err => console.error(err));
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
