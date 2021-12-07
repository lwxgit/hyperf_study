<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
namespace App\Controller;

use App\Service\UserService;
use Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\View\RenderInterface;

/**
 * @AutoController
 */
class LinController extends AbstractController
{

    public function index_bak(RenderInterface $render)
    {
        $res_data = [];
        // 日期
        $n = 12;
        $date = [];

        for($i = 1;$i <= $n;$i++){
            $date[] = $i;
        }
        $date_str = json_encode($date);

        $res_data['date_str'] = $date_str;

        // 实际
        $res   = [
            15559.48 + 50610.88 + 64307,
            11581.92 + 51129.83 + 72557,
            13684.49 + 49969.57 + 72557,
            19714.68 + 54016.73 + 69557,
            16752.90 + 56292.19 + 80577,
            22759.16 + 56179.52 + 80577,
        ];

        $je_res   = [
            50610.88,
            51129.83,
            49969.57,
            54016.73,
            56292.19,
            56179.52
        ];

        $cx_res   = [
            15559.48,
            11581.92,
            13684.49,
            19714.68,
            16752.90,
            22759.16
        ];

        $data_str = json_encode($res);
        $je_str   = json_encode($je_res);
        $cx_str   = json_encode($cx_res);
        $res_data['data_str'] = $data_str;
        $res_data['je_str']   = $je_str;
        $res_data['cx_str']   = $cx_str;


        // 预计
        $s  = 62107;
        $je_start = 45273.59;
        $cx_start = 16514.85;

        $ress = [];
        $t = 0.11/12;
        $cx_t = 0.0015;
        $je = [];
        $cx = [];
        for ($k=0;$k<$n;$k++){

            // $je[] = (String) (round(($je_start * $t),2));
            $je_start = round(($je_start + $je_start * $t + 3500),2);
            $cx_start = round(($cx_start + $cx_start * $cx_t + 3000),2);
            $je[] = $je_start;
            $cx[] = $cx_start;
            $ress[] = ($je_start + $cx_start + $s);
        }
        $datas_str = json_encode($ress);
        $datas_je  = json_encode($je);
        $datas_cx  = json_encode($cx);
        $res_data['datas_str'] = $datas_str;
        $res_data['datas_je']  = $datas_je;
        $res_data['datas_cx']  = $datas_cx;

//        return view();


        return $render->render('lin/index', $res_data);
    }

    /**
     * @param RenderInterface $render
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function index(RenderInterface $render)
    {
        // 日期
        $n = 52;
        $date = [];

        for($i = 1;$i <= $n;$i++){
            $date[] = $i;
        }
        $date_str = json_encode($date);
        $res_data['date_str'] = $date_str;

        // 实际
        $res   = [
//            17529.76 + 47086.41 + 64107,
            14563.59 + 49294.10 + 74807,
            10587.38 + 49761.31 + 83557,
            13687.47 + 51581.25 + 83557,
            19733.65 + 55727.42 + 80577,
            22770.94 + 58026.45 + 80577,
            24808.66 + 60783.37 + 78400,
            26852.29 + 64903.12 + 78400,
            20899.83 + 66118.85 + 89943,
        ];

        $je_res   = [
            49294.10,
            49761.31,
            51581.25,
            55727.42,
            58026.45,
            60783.37,
            64903.12,
            66785.62,
        ];

        $cx_res   = [
            14563.59,
            10587.28,
            13687.47,
            19733.65,
            22770.94,
            24808.66,
            26852.29,
            20902.99,
        ];

        $eyzc_res   = [
            0,
            0,
            0,
            0,
            0,
            2000,
            2000 + 3000,
            2000 + 3000 +1000,
        ];
        $sf = [];
        foreach ($res as $k => $v){
            $sf[] = ($v - $je_res[$k] - $cx_res[$k]) * 0.75 + $je_res[$k] * 0.5 + $cx_res[$k] * 0.5;
        }

        $data_str = json_encode($res);
        $je_str   = json_encode($je_res);
        $cx_str   = json_encode($cx_res);
        $eyzc_str   = json_encode($eyzc_res);
        $sf_str   = json_encode($sf);


        $res_data['data_str'] = $data_str;
        $res_data['je_str']   = $je_str;
        $res_data['cx_str']   = $cx_str;
        $res_data['eyzc_str']   = $eyzc_str;
        $res_data['sf_str']   = $sf_str;

        // 预计
        $s  = 64107;
        $je_start = 47086.41;
        $cx_start = 17529.76;

        $ress = [];
        $t = 0.11/12;
        $cx_t = 0.0015;
        $je = [];
        $cx = [];
        $yj_sf = [];
        for ($k=0;$k<$n;$k++){

            // $je[] = (String) (round(($je_start * $t),2));

//            $sy[] = (String) ($je_start * $t + $cx_start * $cx_t);

            $je_start = round(($je_start + $je_start * $t + 3375),2);
            $cx_start = round(($cx_start + $cx_start * $cx_t + 3000),2);

            $temp_yj_sf = $s * 0.75 + $je_start * 0.5 + $cx_start * 0.5;

            $je[] =  $je_start;
            $cx[] =  $cx_start;
            $ress[] =  ($je_start + $cx_start + $s);
            $yj_sf[] =  $temp_yj_sf;


        }
        $datas_str = json_encode($ress);
        $datas_je  = json_encode($je);
        $datas_cx  = json_encode($cx);
        $datas_yj_sf  = json_encode($yj_sf);
//        $datas_sy  = json_encode($sy);
//        $this->assign('datas_str' ,$datas_str);
//        $this->assign('datas_je' ,$datas_je);
//        $this->assign('datas_cx' ,$datas_cx);
//        $this->assign('datas_yj_sf' ,$datas_yj_sf);


        $res_data['datas_str'] = $datas_str;
        $res_data['datas_je']  = $datas_je;
        $res_data['datas_cx']  = $datas_cx;
        $res_data['datas_yj_sf']  = $datas_yj_sf;

//        return view();


        return $render->render('lin/index', $res_data);
    }
}
