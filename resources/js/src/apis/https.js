// import {tip, to403Page, toLogin} from './utils';
//
//
const errorHandle = (status, msg) => {
    switch (status) {
        case 400:
            // tip(msg)
            break;
        case 401:
            // tip('登入過期,請重新登入');
            // setTimeout(() => {
            //     toLogin();
            // }, 1000);
            break;
        case 403:
            // to403Page();
            break;
        case 404:
            // tip(msg);
            break;
        default:
            console.log('resp沒有攔截到的錯誤:' + msg);
    }
}

const statusHandle = (status, msg) => {
    switch (status) {
        case 0:
            alert(msg);
            // javascript:location.href = '/404';
            break;
        case 1:
            break;
        default:
            console.log('resp沒有攔截到的錯誤:' + msg);
    }
}

var instance = axios.create({
    baseURL: '/api/'
})

instance.interceptors.request.use((config)=>{
    return config;
}, (error) =>{
    return Promise.reject(error);
});

instance.interceptors.response.use((response) =>{

    if(response.data){
        statusHandle(response.data.status,response.data.message)
    }
    return response;

}, (error) => {
    const { response } = error;

    if(response){
        errorHandle(response.status, response.data.error);
        return Promise.reject(error);
    }else{
        if(!window.navigator.onLine){
            tip('網路出了點問題,請重新連線');
        }else{
            return Promise.reject(error);
        }
    }

});

export default function (method, url , data=null) {
    method = method.toLowerCase();
    if(method === 'post'){
        return instance.post(url,data)
    }else if (methos === 'get'){
        return instance.get(url, {params : data})
    }else if (methos === 'delete'){
        return instance.delete(url, {params : data})
    }else if (methos === 'put'){
        return instance.put(url, data)
    }else{
        console.error('未知的method'+method);
        return false;
    }
}
