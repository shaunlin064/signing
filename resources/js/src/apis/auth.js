import req from './https';

export const apiAuthLogin= params => req('post', 'auth/login',params )
export const apiAuthLogout= params => req('post', 'auth/logout',params )

