<?php
	/**
	 * Created by PhpStorm.
	 * User: shaun
	 * Date: 2020/5/25
	 * Time: 11:47
	 */
	namespace App\Http\Controllers;

	class PdfController extends Controller{

        public function output () {
            $pdf = PDF::loadView('pages.outPut.test');
            $pdf->save(storage_path().'_test.pdf');
            return $pdf->download('_test.pdf');
        }
	}
