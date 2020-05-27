<?php
	/**
	 * Created by PhpStorm.
	 * User: shaun
	 * Date: 2020/5/26
	 * Time: 12:26
	 */
?>
<tr>
    <td class='title w2'>部門</td>
    <td class='w3'>{{session('js_signing.member')[$signing['apply_member_id']]['department_name']}}</td>
    <td class='title w2'>申請人</td>
    <td class='w3'>{{session('js_signing.member')[$signing['apply_member_id']]['name']}}</td>
</tr>
