import req from './https';

/*表單crud*/
export const apiGetUserSignatures = params => req('post', 'signature/getUserSignatures',params)
export const apiAddSignatures = params => req('post', 'signature/add',params)
export const apiDeleteSignatures = params => req('post', 'signature/delete',params)
export const apiResetFavoriteSignatures = params => req('post', 'signature/resetFavorite',params)
