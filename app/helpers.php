<?php
    /**
     * Created by PhpStorm.
     * User: shaun
     * Date: 2019-08-15
     * Time: 14:34
     */

    use App\Http\Controllers\SessionController;



    /*START 「Date 相關」 */
    //判斷日期為當月第幾週
    function weekOfMonth ( $date )
    {
        $time = strtotime($date);
        $firstOfMonth = strtotime(date("Y-m-01", $time));
        return intval(date("W", $time)) - intval(date("W", $firstOfMonth)) + 1;
    }

    ;
    //簡單判斷日期是否是正確日期格式
    function isDateSimple ( $str )
    {

        if ( !preg_match("/^[0-9]{4}(\-|\/)[0-9]{2}(\\1)[0-9]{2}$/", $str) && !preg_match("/^[0-9]{2}(\-|\/)[0-9]{2}$/",
                                                                                          $str) )
        {
            return false;
        }
        return true;
    }

    function date_range ( $first, $last,$interval_spec = 'P1D' )
    {
        $firstDate = new DateTime($first);
        $lastDate = new DateTime($last);
        $period = new \DatePeriod(
            $firstDate,
            new \DateInterval($interval_spec),
            $lastDate
        );

        if ( $first == $last )
        {
            return [ $first ];
        }
        foreach ( $period as $date )
        {
            $dates[] = $date->format('Y-m-d');
        }

        $dates[] = $lastDate->format('Y-m-d');
        return $dates;
    }

    /*END 「Date 相關」 */

    /*START 字串相關*/
    //trim掉特殊字符
    function escapeStr ( $str )
    {
        return preg_replace('/[\x00-\x08\x0b-\x0c\x0e-\x1f\x7f]/', '', $str);
    }

    /*END 字串相關*/

    function newRequest ( $Array = null )
    {
        return new \Illuminate\Http\Request($Array);
    }

    function getMember ( $id, $field = 'name' )
    {
        $data = SessionController::getSession('member');
        return $data[$id][$field];
    }

    function getDepartment ( $id, $field = 'name' )
    {
        $data = SessionController::getSession('department');
        return $data[$id][$field];
    }
