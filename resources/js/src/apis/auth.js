import req from './https';

export const apiAuthLogin= params => req('post', 'system/login',params )
export const apiAuthLogout= params => req('post', 'system/logout',params )
