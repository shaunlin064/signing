import {mapState, mapMutations, mapActions, mapGetters} from 'vuex';
import {
    apiAddSignatures,
    apiDeleteSignatures,
    apiGetUserSignatures,
    apiResetFavoriteSignatures
} from "../src/apis/signature";

    export default {
        name: "signature",
        props: {

        },
        data() {
            return {
                show: false,
                styleList: {
                    display: 'block'
                },
                image_base64:'',
                signature_items: [],
            }
        },
        computed: {
                ...mapState([]),
        },
        beforeMount: function () {
        },
        mounted: function () {
            bus.$on('deleteSignature', this.deleteSignature);
            bus.$on('setFavorite', this.setFavorite);
            let parameter = {
                erp_user_id: this.login_user.id,
                api_token:this.login_user.api_token
            }
            apiGetUserSignatures(parameter).then((response) => {
                this.signature_items = response.data.data;
            });
        },
        methods: {
            close() {
                this.show = !this.show;
                $('body').css('overflow','auto');
            },
            open() {
                this.show = !this.show;
                this.asyncSetting();
            },
            addNewSignature(item) {
                item.api_token = this.login_user.api_token;
                apiAddSignatures(item).then((response) => {
                    this.reset();
                    item.id = response.data.data.id;
                    this.signature_items.push(item);
                    this.setFavorite(item.id);
                }).then(() => {
                    this.close();
                });
            },
            deleteSignature(id) {
                let parameter = {id:id,api_token:this.login_user.api_token};
                this.signature_items.map((v, k) => {
                    if (v.id == id) {
                        apiDeleteSignatures(parameter).then(() => {
                            this.signature_items.splice(k, 1);
                        }).then(() => {
                            this.setItemDefault();
                        });
                    }
                });
            },
            setItemDefault() {
                if (this.signature_items.length > 0) {
                    this.signature_items[this.signature_items.length - 1]['favorite'] = 1;
                    let id = this.signature_items[this.signature_items.length - 1]['id'];
                    this.setFavorite(id);
                }
            },
            itemDefaultReset() {
                this.signature_items.map((v, k) => {
                    this.signature_items[k]['favorite'] = 0;
                });
            },
            setFavorite(id) {
                this.signature_items.map((v, k) => {
                    this.signature_items[k]['favorite'] = v.id == id ? 1 : 0;
                });
                let parameter = {id:id,api_token:this.login_user.api_token};
                apiResetFavoriteSignatures(parameter);
            }
        },
        updated() {
        },
        watch: {
        }
    }
