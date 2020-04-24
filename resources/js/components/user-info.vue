<template>
    <li class="dropdown dropdown-user nav-item" >
        <a
            class="dropdown-toggle nav-link dropdown-user-link" href="#"
            data-toggle="dropdown" @click='openMenu'>
            <div class="user-nav d-sm-flex d-none">
                <span class="user-name text-bold-600">{{login_user.name}}</span>
                <span class="user-status">{{login_user.department}}</span>
            </div>
            <span><img class="round"
                       src="images/portrait/small/avatar-s-18.jpg"
                       alt="avatar" height="40"
                       width="40"/></span>
        </a>
        <div class="dropdown-menu dropdown-menu-right">
<!--            <div class="dropdown-divider"></div>-->
            <a class="dropdown-item" @click='logout'>
                <i class="feather icon-power"></i> Logout
            </a>
        </div>
    </li>
</template>

<script>
    import {mapState} from 'vuex';

    export default {
        name: "user-info",
        props: {
            session : Object,
        },
        data() {
            return {
                over_time : false,
            }
        },
        computed: {
            ...mapState(['login_user','member','department']),
        },
        beforeMount: function () {

        },
        mounted: function () {
            this.setSession();
            this.asyncGet();
        },
        methods: {
            async asyncGet() {
                this.over_time = await this.settime();
                if(this.over_time){
                    this.relogin();
                }
                console.log(this.over_time);
            },
            settime() {
                return new Promise((resolve, reject) => {
                    setTimeout(() => {
                        resolve(true)
                    }, 15 * 60000)
                });
            },
            setSession(){
                this.$store.state.login_user = this.session.login_user;
                this.$store.state.member = this.session.member;
                this.$store.state.department = this.session.department;

                sessionStorage.setItem('member', JSON.stringify(this.session.member));
                sessionStorage.setItem('department', JSON.stringify(this.session.department));
            },
            relogin(){
                Swal.fire({
                    title: '請重新登入',
                    text: '閒置過久系統已登出',
                    type: 'info',
                    confirmButtonClass: 'btn btn-success',
                }).then(result=>{
                    javascript:location.href='/login';
                });
            },
            openMenu(event) {
                let targetDom = $(event.currentTarget);
                targetDom.parent('.dropdown').addClass('show');
                targetDom.next().addClass('show');
            },
            logout(){
                // Object.keys(localStorage).forEach( key=>{
                //     localStorage.removeItem(key);
                // })
                // sessionStorage.clear();
                axios({
                    url: 'session/release',
                    method: 'post',
                    headers: {
                        'Content-Type': 'application/json',
                    }
                }).then(
                    (res)=>{
                        console.log(res.data);
                    }
                ).catch(err => console.error(err));

                javascript:location.href='/login';
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
