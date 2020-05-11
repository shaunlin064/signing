import req from './https';

export const apiGetNotificationList = params => req('post', 'system/message/list',params )
export const apiGetNotification = params => req('post', 'system/message/get',params )
export const apiPostNotificationSetRead = params => req('post', 'system/message/setRead',params )
export const apiPostNotificationSetReadAll = params => req('post', 'system/message/setReadAll',params )
