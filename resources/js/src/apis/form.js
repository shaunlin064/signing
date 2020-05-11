import req from './https';

/*表單crud*/
export const apiFormApply = params => req('post', 'form/apply',params)
export const apiGetForm = params => req('post', 'form/get' ,params)
export const apiFormEdit = params => req('post', 'form/edit',params)

/*表單簽核*/
export const apiFormChecking = params => req('post', 'form/check',params)

/*getList*/
export const apiGetUserCheckList = params => req('post', 'form/user/list', params)
export const apiGetCheckList = params => req('post', 'form/check/list',params)
export const apiGetAllList = params => req('post', 'form/all',params)

/*get depend List*/
export const apiGetDependList = params => req('post', 'form/depend',params)
