<!DOCTYPE html>
<html>

<head><title>test</title></head>
<a href = "http://localhost/Calculator/public/calculator">戻る</a>

<p>
<?PHP

    echo "電卓作成がんばろう！";
?>
</p>
<p>
    <?php
    

    $dsp_old = "-5*-+--5*-+5=";

    //i:何番目の文字を見るか
    //j:何番目の配列に入れるか
 
    ?>
</p>
<p>
    <?php


$j_er=0;
$j=0;
$max=50;


    //先頭に符号があった場合
    //先頭の文字
    $t=substr($dsp_old,0,1);

    switch($t){
        case "+":
        case "-":   $dsp_old = "0".$dsp_old;
                    $max++;
                    break;
        case "*":
        case "/":   echo "ERROR";
                    exit;

    }

    for($i=0;$i<$max;$i++){
        $fm[$i]="";
        $op[$i]="";
    }

    //数値と符号を分けてそれぞれ配列に入れる
    for($i=0;$i<=strlen($dsp_old);$i++){
        //$i番目の文字を取得
        $t=substr($dsp_old,$i,1);
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
                //+or-の後に*or/が続く時はエラー)
                if($op[$j]=="*" || $op[$j]=="/"){
                    echo "ERROR";
                    exit;    
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
    for($i=0;$i<$max;$i++){
        echo $fm[$i].$op[$i];
    }

    ?>
</p><p>
    <?php

    //割り算を掛け算に変換
    for($i=0;$i<$max;$i++){
        if($op[$i]=="/"){
            $fm[$i+1] = 1 / $fm[$i+1];
            $op[$i] = "*";
        }
    }

    //表示
    for($i=0;$i<$max;$i++){
        echo $fm[$i].$op[$i];
    }

    ?>
</p><p>
    <?php

    //引き算を足し算に変換
    for($i=0;$i<$max;$i++){
        if($op[$i]=="-"){
            $fm[$i+1] = -$fm[$i+1];
            $op[$i] = "+";
        }
    }

    //表示
    for($i=0;$i<$max;$i++){
        echo $fm[$i].$op[$i];
    }

    ?>
</p><p>
    <?php

    //掛け算を足し算に変換
    for($i=0;$i<$max;$i++){
        if($op[$i]=="*"){
            $fm[$i+1] = $fm[$i] * $fm[$i+1];
            $fm[$i] = 0;
            $op[$i] = "+";
        }
    }

    //表示
    for($i=0;$i<$max;$i++){
        echo $fm[$i].$op[$i];
    }

    ?>
</p><p>
    <?php

    for($i=0;$i<$max;$i++){
        $fm[$i] = (float)$fm[$i];
    }

    //表示
    for($i=0;$i<$max;$i++){
        echo "{$fm[$i]}/";
    }

    ?>
</p><p>
    <?php

    //表示
    for($i=0;$i<$max;$i++){
        echo var_dump($op[$i]);
    }

    ?>
</p><p>
    <?php

    //全て足す
    $ans=0;
    for($i=0;$i<$max;$i++){
        $ans = $ans + $fm[$i];
    }

    //結果表示
    echo $ans;

?>
</p>
</html>