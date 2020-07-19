<?php

namespace App;

use Cookie;

class Recall
{
    public function __construct()
    {

    }

    public function add($productId, $fileName)
    {
        if (Cookie::get('myProducts'))   //myProducts라는 쿠키가 존재하면...
        {
            foreach (Cookie::get('myProducts') as $name => $value)  //쿠키를 순서대로 읽어서
            {
                $name = htmlspecialchars($name);
                $value = htmlspecialchars($value);
                //echo ($name . '###'. $value . '    ' ); ///////////////
                if ($name == $productId)  //현재 보고 있는 상품이 있으면
                {                         //삭제한다.(아래 루틴에서 다시 세이브한다==>순서를 유지하기 위해...)
                    $myCookie = 'myProducts' . '[' . $productId . ']';
                    Cookie::queue($myCookie, $fileName,  -1, '/'); //-1은 분을 의미(1시간 = 60초 * 60초)
                }                                                  //일분 전에 쿠키가 지워졌다는 의미...
            }
        }
        $myCookie = 'myProducts' . '[' . $productId . ']'; //어레이 형태로 저장하기 위해 대괄호를 포함.
        Cookie::queue($myCookie, $fileName, +1440, '/'); //+1440은 분을 의미(+숫자는 분을 의미)
    }
}
