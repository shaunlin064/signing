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
                       :src='img_url'
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
    import { apiAuthLogout } from '../src/apis/auth';
    export default {
        name: "user-info",
        props: {
            session : Object,
            img_url: String,
        },
        data() {
            return {

            }
        },
        computed: {
            ...mapState(['login_user','member','department']),
        },
        beforeMount: function () {

        },
        mounted: function () {
            this.setSession();
        },
        methods: {
            setSession(){
                this.$store.state.login_user = this.session.login_user;
                this.$store.state.member = this.session.member;
                this.$store.state.department = this.session.department;

                sessionStorage.setItem('member', JSON.stringify(this.session.member));
                sessionStorage.setItem('department', JSON.stringify(this.session.department));
            },
            openMenu(event) {
                let targetDom = $(event.currentTarget);
                targetDom.parent('.dropdown').addClass('show');
                targetDom.next().addClass('show');
            },
            logout(){
              apiAuthLogout({api_token: this.login_user.api_token}).then(()=>{
                javascript:location.href='/login';
              });

            },
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
