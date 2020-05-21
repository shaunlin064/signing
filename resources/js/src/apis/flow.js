import req from './https';

/*flow crud*/
export const apiGetFlow = params => req('post', 'form/flow/get',params)
export const apiAddFlow = params => req('post', 'form/flow/add',params)
export const apiEditFlow = params => req('post', 'form/flow/edit',params)
export const apiDeleteFlow = params => req('post', 'form/flow/delete',params)
export const apiSaveAllFlow = params => req('post', 'form/flow/saveAll',params)
