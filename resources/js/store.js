let date = new Date();
date = `${date.getFullYear()}-${('0' + (date.getMonth() + 1)).substring(0, 2)}-01`;
export default {
    state: {
        login_user : sessionStorage.login_user !== undefined ?  JSON.parse(sessionStorage.login_user) : JSON.parse(localStorage.login_user),
        member : sessionStorage.member !== undefined ? JSON.parse(sessionStorage.member) : JSON.parse(localStorage.member),
        department : sessionStorage.department !== undefined ? JSON.parse(sessionStorage.department) : JSON.parse(localStorage.department),
        form_submit_data:{}
    },
    getters: {

    },
    actions: {

    },
    mutations: {

    }
};
