let date = new Date();
date = `${date.getFullYear()}-${('0' + (date.getMonth() + 1)).substring(0, 2)}-01`;
export default {
    state: {
        login_user : [],
        member : [],
        department : [],
        // login_user : sessionStorage.login_user !== undefined ?  JSON.parse(sessionStorage.login_user) : JSON.parse(localStorage.login_user),
        // member : sessionStorage.member !== undefined ? JSON.parse(sessionStorage.member) : JSON.parse(localStorage.member),
        // department : sessionStorage.department !== undefined ? JSON.parse(sessionStorage.department) : JSON.parse(localStorage.department),
        form_submit_data:{},
        plan_fee_count_total: 0,
        plan_fee_counts:{},
        exPassCheckColumn:[],
        currency_type: [['TWD','新台幣','台灣'],['JPY','日幣','日本'],['CNY','人民幣','中國'],['HKD','港元','香港'],['KRW','韓元','韓國'],['SGD','新幣','新加坡'],['USD','美元','美國'],['GBP','英鎊','英國'],['IDR','印尼盾','印度']],
        flow_submit_data:{},
    },
    getters: {

    },
    actions: {

    },
    mutations: {

    }
};
