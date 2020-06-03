<?php
    /**
     * Created by PhpStorm.
     * User: shaun
     * Date: 2020/5/25
     * Time: 11:47
     */

    namespace App\Http\Controllers;

    use App\FormApply;
    use Barryvdh\DomPDF\Facade as PDF;
    use Illuminate\Http\Request;

    class PrintController extends Controller {

        public function print ( Request $request ) {

            [
                $signing,
                $config,
                $html
            ]
                = $this->getFormData($request);
            return view(
                'pages.outPut.' . $html, [
                                           'pdf'     => false,
                                           'signing' => $signing,
                                           'config'  => $config
                                       ]
            );

        }

        public function pdf ( Request $request ) {

            [
                $signing,
                $config,
                $html
            ]
                = $this->getFormData($request);

            $pdf = PDF::loadView(
                'pages.outPut.' . $html, [
                                           'pdf'     => true,
                                           'signing' => $signing,
                                           'config'  => $config
                                       ]
            );
            return $pdf->stream('test.pdf');
        }

        /**
         * @param Request $request
         * @return array
         */
        private function getFormData ( Request $request ): array {
            $signing = new \App\Http\Controllers\API\FormController();
            $signing = $signing->get(
                newRequest(
                    [
                        'id' => $request->id,

                    ]
                )
            )['data'];

            $config = config('form')[ $signing['form_id'] ];

            if ( $signing['form_id'] === 6 ) {
                $signing['column']['items'] = collect($signing['column']['items'])->values();
                $signing['fee_items_total'] = $signing['column']['items']->pluck('fee_items')->map(
                    function ( $v, $k ) use ( &$signing ) {
                        $signing['column']['items'][ $k ]['fee_items'] = json_decode($v, true);
                        return json_decode($v, true);
                    }
                )->flatten(1);
            }
            $html = $config['html_name'];
            return [
                $signing,
                $config,
                $html
            ];
        }
    }
