import {mapState} from "vuex";

export default {
    data () {
        return{
        }
    },
    computed: {
        ...mapState(['exPassCheckColumn']),
    },
    created () {
    },
    methods: {
        formValidate() {
            let vue = this;
            let data = this.formGetPostData();
            this.lodding = true;

            vue.validate_message = {};
            let passCheckColumn = ['apply_attachment', 'remark'];
            switch (vue.form_type) {
                case 'form-payment':
                    // passCheckColumn.push('campaign_id');
                    break;
                case 'form-sign':
                    passCheckColumn.push('recipient_company', 'recipient_contact', 'recipient_phone', 'recipient_address');
                    break;
            }

            passCheckColumn = passCheckColumn.concat(this.exPassCheckColumn);

            Object.keys(data).forEach(key => {
                if(key === 'items'){
                    if(!nullCheck(data[key])){
                        let items =  data[key];
                        Object.keys(items).forEach(key =>{
                            let item = items[key];
                            Object.keys(item).forEach(key => {
                                if(nullCheck(item[key])){
                                    if ($.inArray(key, passCheckColumn) === -1) {
                                        vue.lodding = false;
                                        vue.validate_message[key] = 'required';
                                    }
                                }
                            });
                        });
                    }
                }
                if (nullCheck(data[key])) {
                    if ($.inArray(key, passCheckColumn) === -1) {
                        vue.lodding = false;
                        vue.validate_message[key] = 'required';
                    }
                }
            });

            return Object.keys(vue.validate_message).length !== 0;

        },
        formToJson(data) {
            /* other Array to Json*/
            Object.keys(data).forEach(columnName => {
                if ($.inArray(columnName, ['form_stamp_type', 'accompany_user_id', 'attend_member', 'apply_attachment']) != -1) {
                    data[columnName] = JSON.stringify(data[columnName]);
                }
            });
            /*travel_fee*/
            if (data['items'] !== undefined) {
                let itemsData = data['items'];
                Object.keys(itemsData).forEach(key => {

                    if (itemsData[key]['fee_items'] !== undefined) {
                        itemsData[key]['fee_items'] = JSON.stringify(itemsData[key]['fee_items']);
                    }
                });
                data['items'] = itemsData;
            }
            return data;
        },
        formGetPostData() {
            return Object.assign({}, eval(`this.form_submit_data['${this.form_type}']`));
        },
    }
}
