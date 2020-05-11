import req from './https';

/*session*/
export const apiSessionRelease = params => req('post', 'session/release',params)
export const apiSessionPut = params => req('post', 'session/put',params)
export const apiSessionGet = params => req('post', 'session/get',params)
