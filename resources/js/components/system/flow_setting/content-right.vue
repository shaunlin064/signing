<template>
    <div class="todo-app-area">
        <div class="todo-app-list-wrapper">
            <div class="todo-app-list">
                <div class="app-fixed-search">
                    <div class="sidebar-toggle d-block d-lg-none"><i class="feather icon-menu"></i></div>
                    <fieldset class="form-group position-relative has-icon-left m-0">
                        <input type="text" class="form-control" id="todo-search" placeholder="表單簽核設定"
                               disabled='disabled'>
                        <div class="form-control-position">
                            <i class="feather icon-server"></i>
                        </div>
                    </fieldset>
                </div>
                <form id='form'>
                    <div class="todo-task-list list-group" id="basic-list-group">
                        <loading></loading>
                        <components v-for="(item,key) in signatoryItems" v-bind:is="item.component" :key='key'
                                    :index='key' :form_type='form_type' :id='item.id' :form_id='form_id' :review_order='item.review_order'></components>
                        <button class="hidden" id='submit' type='submit'></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapState} from 'vuex';

    export default {
        name: "content-right",
        props: {},
        data() {
            return {
                count: 1,
                form_type: '',
                form_id: '',
                review_order: 1,
                signatoryItems: [],
            }
        },
        computed: {
            ...mapState(['login_user', 'member', 'department', 'flow_submit_data']),
        },
        beforeMount: function () {

        },
        mounted: function () {
            // Sortable Lists
            var dragulaCards = dragula([document.getElementById('basic-list-group')]);
            var vue = this;
            dragulaCards.on('drop', function (el, target, source, sibling) {
                vue.resetReviewOrder();
            });
        },
        created: function () {
            bus.$on('addSignatory', this.addSignatory);
            bus.$on('setDefault', this.setDefault);
            bus.$on('setData', this.setData);
            bus.$on('clean', this.clean);
            bus.$on('deleteSignatory', this.deleteSignatory);
        },
        methods: {
            async resetReviewOrder() {
                let vue = this;
                let wait = await this.settime(0.5);
                if (wait) {
                    $('.todo-task-list-wrapper.media-list').map((k, e) => {
                        let originId = e.dataset.id;
                        let number = k+1;
                        vue.flow_submit_data[vue.form_type][originId]['review_order'] = number;
                        vue.review_order = number;
                    })
                }
                bus.$emit('getReviewOrder');
            },
            async listScrollBottom() {
                let wait = await this.settime();
                if (wait) {
                    bus.$emit('listScroll', 'bottom');
                }
            },
            settime(second = 1) {
                return new Promise((resolve, reject) => {
                    setTimeout(() => {
                        resolve(true)
                    }, second * 1000)
                });
            },
            clean() {
                this.signatoryItems = [];
            },
            setDefault(arg) {
                const {form_id, form_type} = arg;
                this.form_id = form_id;
                this.form_type = form_type;
                this.count = 1;
                this.signatoryItems = [];
            },
            setData() {
                let data = Object.assign([], this.flow_submit_data[this.form_type]);
                let vue = this;
                data.map((v, key) => {
                    v['component'] = 'signatory';
                    v['id'] = key;
                    vue.signatoryItems.push(v);
                    vue.review_order = key;
                    vue.count = key;
                });
            },
            addSignatory() {
                this.count++;
                this.review_order++;
                this.signatoryItems.push({
                    id: this.count,
                    component: 'signatory',
                    review_order: this.review_order
                })
                this.listScrollBottom();
            },
            deleteSignatory(id) {
                let vue = this;
                // let found = false;
                vue.signatoryItems.map((v, key) => {
                    if (v.id === id) {
                        vue.signatoryItems.splice(key, 1);
                        delete vue.flow_submit_data[vue.form_type][id];
                    }
                })
                /*order 整理*/
                vue.resetReviewOrder();
            },
        },
        updated() {
            $(".select2").select2({
                dropdownAutoWidth: true,
                width: '100%'
            });
            // console.log('view updated')
        },
        watch: {
            form_id: {
                immediate: false,    // 这句重要
                handler(val, oldVal) {
                    this.setData();
                }
            }
        }
    }
</script>

<style scoped>

</style>
