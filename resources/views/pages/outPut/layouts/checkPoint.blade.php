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
            <td class='w3'>
                @if(isset(\App\Signature::Find($signer['signatures_id'])->image_base64))
                <img style='width: 100%' src='{{\App\Signature::Find($signer['signatures_id'])->image_base64}}' alt=''>
                    @endif
            </td>
        @endforeach
        @if($item->count() < 2)
                <td colspan="2" class='title w2'></td>
        @endif
    </tr>
@endforeach
