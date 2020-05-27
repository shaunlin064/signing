<?php
	/**
	 * Created by PhpStorm.
	 * User: shaun
	 * Date: 2020/5/26
	 * Time: 12:11
	 */
	?>
@foreach($signing['checkPoint']->chunk(2) as $key => $item)
    <tr>
        @foreach($item as $signer)
            <td class='title w2'>{{$signer['check_point_name']}}</td>
            <td class='w3'>{{session('js_signing.member')[$signer['signed_member_id']]['name']}}</td>
        @endforeach
        @if($item->count() < 2)
                <td colspan="2" class='title w2'></td>
        @endif
    </tr>
@endforeach
