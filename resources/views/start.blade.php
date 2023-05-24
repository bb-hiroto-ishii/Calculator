<!DOCTYPE html>
<html>

<head>
    <title>test</title>
</head>
<a href="http://localhost/Calculator/public/calculator">戻る</a>

<p>
    <?PHP

    echo "電卓作成がんばろう！";
?>
</p>
<p>
    <?php
    
    //式
    $dsp_old = "5*5.5-2=";
 
    ?>
</p>
<p>
    <?php

function calculate(&$dsp_old){

$fms = $dsp_old;

//演算子の数
$max=0;

//演算子の数を数える
for($i=0;$i<=strlen($fms);$i++){
    //$i番目の文字を取得
    $t=substr($fms,$i,1);
    //=まで来たらループ抜ける
    if($t=="="){
        $max++;
        break;
    
    //文字が演算子だったら
    }elseif(
        $t=="+"
        || $t=="-"
        || $t=="*"
        || $t=="/"
    ){
        $max++;
    }
}

//表示
// echo "[{$max}]";


    //先頭に符号があった場合
    //先頭の文字
    $t=substr($fms,0,1);

    switch($t){
        case "+":
        case "-":   $fms = "0".$fms;
                    $max++;
                    break;
        case "*":
        case "/":   echo "ERROR";
                    exit;

    }

    //必要数分配列を用意
    for($i=0;$i<$max;$i++){
        $fm[$i]="";
        $op[$i]="";
    }

    //ループ用、
$j=0;

    //数値と符号を分けてそれぞれ配列に入れる
    for($i=0;$i<=strlen($fms);$i++){
        //$i番目の文字を取得
        $t=substr($fms,$i,1);
        //=まで来たらループ抜ける
        if($t=="="){
            break;
        }
        //文字が演算子だったら
        if(
            $t=="+"
            || $t=="-"
            || $t=="*"
            || $t=="/"
        ){
            //演算子用配列に入れる
            $op[$j]=$t;

            //$op[$j]の前に数値がなかったら、
            if($fm[$j]==""){
                //+or-の後に*or/が続く時はエラー
                if($op[$j]=="*" || $op[$j]=="/"){
                    echo "ERROR";
                    exit;
                //+or-の後に-が続く時は式変換
                }elseif($op[$j]=="-"){
                    switch($op[$j-1]){
                        case "+":   $op[$j-1]="-";
                                    break;
                        case "-":   $op[$j-1]="+";
                                    break;
                        case "*":
                        case "/":   $fm[$j-1]=-$fm[$j-1]; 
                                    break;
                    }
                }
                //+なら無視する
            }else{
                $j++;
            }
        }else{
            $fm[$j].=$t;
        }
    }

    //式を表示
    // for($i=0;$i<$max;$i++){
    //     echo $fm[$i].$op[$i];
    // }


    //割り算を掛け算に変換
    for($i=0;$i<$max;$i++){
        if($op[$i]=="/"){
            $fm[$i+1] = 1 / $fm[$i+1];
            $op[$i] = "*";
        }
    }

    // //表示
    // for($i=0;$i<$max;$i++){
    //     echo $fm[$i].$op[$i];
    // }


    //引き算を足し算に変換
    for($i=0;$i<$max;$i++){
        if($op[$i]=="-"){
            $fm[$i+1] = -$fm[$i+1];
            $op[$i] = "+";
        }
    }

    // //表示
    // for($i=0;$i<$max;$i++){
    //     echo $fm[$i].$op[$i];
    // }


    //掛け算を足し算に変換
    for($i=0;$i<$max;$i++){
        if($op[$i]=="*"){
            $fm[$i+1] = $fm[$i] * $fm[$i+1];
            $fm[$i] = 0;
            $op[$i] = "+";
        }
    }

    // //表示
    // for($i=0;$i<$max;$i++){
    //     echo $fm[$i].$op[$i];
    // }


    //型変換
    for($i=0;$i<$max;$i++){
        $fm[$i] = (float)$fm[$i];
    }

    //全て足す
    $ans=0;
    for($i=0;$i<$max;$i++){
        $ans = $ans + $fm[$i];
    }

    //結果格納
    $dsp_old = $ans;

    //結果表示
    echo $dsp_old;

}

calculate($dsp_old);
?>
</p>

</html>