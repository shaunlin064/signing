import req from './https';

export const apiPostFile = params => req('post', 'system/upload' ,params)
