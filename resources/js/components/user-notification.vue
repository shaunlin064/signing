<template>
    <li class="dropdown dropdown-notification nav-item"><a class="nav-link nav-link-label"
                                                           href="#"
                                                           data-toggle="dropdown" @click='openMenu'><i
        class="ficon feather icon-bell"></i><span
        class="badge badge-pill badge-primary badge-up" v-show='new_message_count > 0'>{{new_message_count}}</span></a>
        <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
            <li class="dropdown-menu-header">
                <div class="dropdown-header m-0 p-2">
                    <h3 class="white" v-show='new_message_count > 0'>{{new_message_count}} New</h3>
                    <span class="grey darken-2">Notifications</span>
                </div>
            </li>
            <li class="scrollable-container media-list">
                <a class="d-flex justify-content-between" href="javascript:void(0)" v-if='message_count < 1'>
                    <div class="media d-flex align-items-start">
                        <div class="media-body">
                            <small class="notification-text">
                                no notification..
                            </small>
                        </div>
                    </div>
                </a>
                <a class="d-flex justify-content-between" href="javascript:void(0)" v-for='item in message'>
                    <div class="media d-flex align-items-start">
                        <div class="media-left"><i
                            class="feather icon-plus-square font-medium-5 primary"></i>
                        </div>
                        <div class="media-body">
                            <h6 class="primary media-heading">{{item.title}}!</h6><small
                            class="notification-text">{{item.content}}</small>
                        </div>
                        <small>
                            <time class="media-meta" :datetime='item.created_at'>
                                {{timeSince(item.created_at)}}
                            </time>
                        </small>
                    </div>
                </a>
<!--                <a class="d-flex justify-content-between" href="javascript:void(0)">-->
<!--                <div class="media d-flex align-items-start">-->
<!--                    <div class="media-left"><i-->
<!--                        class="feather icon-download-cloud font-medium-5 success"></i>-->
<!--                    </div>-->
<!--                    <div class="media-body">-->
<!--                        <h6 class="success media-heading red darken-1">99% Server-->
<!--                            load</h6>-->
<!--                        <small class="notification-text">You got new order of-->
<!--                            goods.</small>-->
<!--                    </div>-->
<!--                    <small>-->
<!--                        <time class="media-meta" datetime="2015-06-11T18:29:20+08:00">5-->
<!--                            hour-->
<!--                            ago-->
<!--                        </time>-->
<!--                    </small>-->
<!--                </div>-->
<!--            </a>-->
<!--                <a class="d-flex justify-content-between" href="javascript:void(0)">-->
<!--                <div class="media d-flex align-items-start">-->
<!--                    <div class="media-left"><i-->
<!--                        class="feather icon-alert-triangle font-medium-5 danger"></i>-->
<!--                    </div>-->
<!--                    <div class="media-body">-->
<!--                        <h6 class="danger media-heading yellow darken-3">Warning-->
<!--                            notifixation-->
<!--                        </h6><small class="notification-text">Server have 99% CPU-->
<!--                        usage.</small>-->
<!--                    </div>-->
<!--                    <small>-->
<!--                        <time class="media-meta" datetime="2015-06-11T18:29:20+08:00">-->
<!--                            Today-->
<!--                        </time>-->
<!--                    </small>-->
<!--                </div>-->
<!--            </a>-->
<!--                <a class="d-flex justify-content-between" href="javascript:void(0)">-->
<!--                <div class="media d-flex align-items-start">-->
<!--                    <div class="media-left"><i-->
<!--                        class="feather icon-check-circle font-medium-5 info"></i>-->
<!--                    </div>-->
<!--                    <div class="media-body">-->
<!--                        <h6 class="info media-heading">Complete the task</h6><small-->
<!--                        class="notification-text">Cake-->
<!--                        sesame snaps cupcake</small>-->
<!--                    </div>-->
<!--                    <small>-->
<!--                        <time class="media-meta" datetime="2015-06-11T18:29:20+08:00">-->
<!--                            Last-->
<!--                            week-->
<!--                        </time>-->
<!--                    </small>-->
<!--                </div>-->
<!--            </a>-->
<!--                <a class="d-flex justify-content-between" href="javascript:void(0)">-->
<!--                    <div class="media d-flex align-items-start">-->
<!--                    <div class="media-left"><i-->
<!--                        class="feather icon-file font-medium-5 warning"></i></div>-->
<!--                    <div class="media-body">-->
<!--                        <h6 class="warning media-heading">Generate monthly report</h6>-->
<!--                        <small-->
<!--                            class="notification-text">Chocolate cake oat cake tiramisu-->
<!--                            marzipan</small>-->
<!--                    </div>-->
<!--                    <small>-->
<!--                        <time class="media-meta" datetime="2015-06-11T18:29:20+08:00">-->
<!--                            Last-->
<!--                            month-->
<!--                        </time>-->
<!--                    </small>-->
<!--                </div>-->
<!--                </a>-->
            </li>
<!--            <li class="dropdown-menu-footer">-->
<!--                <a class="dropdown-item p-1 text-center" href="javascript:void(0)">-->
<!--                    Read all notifications-->
<!--                </a>-->
<!--            </li>-->
        </ul>
    </li>
</template>

<script>
    import {mapState} from 'vuex';

    export default {
        name: "user-notification",
        props: {},
        data() {
            return {
                new_message_count: 0,
                new_message_ids: [],
                message_count : 0,
                message: [],
            }
        },
        computed: {
            ...mapState(['login_user']),
        },
        beforeMount: function () {
        },
        mounted: function () {
            this.asyncGet();
        },
        methods: {
            async asyncGet() {
                let wait = await this.settime();
                if (wait) {
                    this.getMessage();
                }
            },
            settime() {
                return new Promise((resolve, reject) => {
                    setTimeout(() => {
                        resolve(true)
                    }, 1 * 1000)
                });
            },
            timeSince(date) {
                let dateTime = new Date(date).getTime() / 1000;
                var seconds = Math.floor(((new Date().getTime()/1000) - dateTime));
                 let   interval = Math.floor(seconds / 31536000);

                if (interval > 1) return interval + " year ago";

                interval = Math.floor(seconds / 2592000);
                if (interval > 1) return interval + " month ago";

                interval = Math.floor(seconds / 86400);
                if (interval > 1) return interval + " day ago";
                if (interval > 1 && interval < 2) return "yesterday";

                interval = Math.floor(seconds / 3600);
                if (interval >= 1) return interval + " hour ago";

                interval = Math.floor(seconds / 60);

                if (interval > 1) return interval + " minute ago";

                return Math.floor(seconds) + "second ago";
            },
            getMessage() {
                let vue = this;
                axios({
                    url: 'api/system/message/list',
                    method: 'post',
                    data: {member_id: vue.login_user.id},
                    headers: {
                        'Content-Type': 'application/json',
                    }
                }).then(
                    (res) => {
                        vue.message = res.data.data;
                        vue.message_count = res.data.data.length;
                        let count = 0;
                        res.data.data.map((v)=>{
                            if(v.read_at === null){
                                count++;
                                vue.new_message_ids.push(v.id);
                            }
                        });
                        vue.new_message_count = count;
                    }
                ).catch(err => console.error(err));
            },
            openMenu(event) {
                let targetDom = $(event.currentTarget);
                targetDom.parent('.dropdown').addClass('show');
                targetDom.next().addClass('show');
                let vue = this;

               if(vue.new_message_ids){
                   axios({
                       url: 'api/system/message/setRead',
                       method: 'post',
                       data: {
                           id : vue.new_message_ids,
                           member_id: vue.login_user.id
                       },
                       headers: {
                           'Content-Type': 'application/json',
                       }
                   }).then(
                       (res) => {
                           if(res.data.status === 1){
                               vue.new_message_count = 0;
                               vue.new_message_ids = [];
                           }
                       }
                   ).catch(err => console.error(err));
               }
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
