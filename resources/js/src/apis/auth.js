import req from './https';

export const apiAuthLogin= params => req('post', 'auth/login',params )
