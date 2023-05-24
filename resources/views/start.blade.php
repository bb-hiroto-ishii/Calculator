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
    $dsp_old = "1234.5678+784.323232-345643.3454";
    echo $dsp_old;
 
    ?>
</p>
<p>

    <script>
        var dsp = 0;
        var n = 0;


    addEventListener("keydown", keydownEvent);

    function keydownEvent(event) {
        
        var key_code = event.keyCode;
        

        // if( key_code === 49){
        //     //alert(event.keyCode);
            
        //     dsp +=1;

        // }

        // if( key_code === 50){
        //     //alert(event.keyCode);
            
        //     dsp +=2;
   
        // }

        switch( key_code ){
            case 49 :   n =1;
                        break;
            case 50 :   n =2;
                        break;
            case 51 :   n =3;
                        break;
            case 52 :   n =4;
                        break;
            default :   n =0;
        }

        dsp += n;
       
            var testarea = document.getElementById("testarea");
            testarea.innerHTML = dsp;
    }

    </script>
</p>
<p id="testarea">
テスト
</p>

    <button type="button" onclick="ALERT()" id="testarea">最高だぜ！</button>

    <script>
        function ALERT(){
            alert("yeah!");
        }
    </script>
</p>
<p>

    <?php




function cut(&$dsp_old){
    
    $len = strlen($dsp_old);
    $fake = "";
    $view = "";
    $c = 0;

    echo "[{$len}]";
    
    for($i=$len-1;$i>=0;$i--){
        //echo "{$i}:";
        //$n[$i] = substr($dsp_old,$i,1);
        $n = substr($dsp_old,$i,1);
        
        //echo $n[$i];
        
        //抽出文字が数字だったら
        if(is_numeric($n)==true){
            //書き込み済み数字が3桁だったら"，"を挟む
            if($c>2){
                $fake = ",".$fake;      
                $c=0;  
            }
        }
        //表示用文字列として書き込む
        $fake = $n.$fake;

        //抽出文字が数字だったらカウントアップ、違ったらリセット
        if(is_numeric($n)==true){    
            $c++;
        }else{
            $c=0;
        }
    }

    //改めて先頭から見て、小数部に","があったら消す。
    $len = strlen($fake);
    $del = 0;

    for($i=0;$i<$len;$i++){
        $n = substr($fake,$i,1);
    
        

        //削除フラグがあがっているときは、","を無視
        if($del==1){
            if($n!=","){
                $view = $view.$n;
            }
            //数字以外の文字が出てきたら、削除フラグ下げる
            if(is_numeric($n)==false){
                $del=0;
            }
        }else{
            $view = $view.$n;
        }

        //追加した文字が小数点だったら、","削除フラグ上げる
        if($n=="."){
            $del=1;
        }

        //echo "i:{$i},n:{$n},del:{$del}_";
    }

    // echo "FAKE:";
    // echo $fake;
    echo "VIEW:";
    echo $view;

    // for($i=0;$i<$len;$i++){
    //     echo "【{$n[$i]}】";
    // }

}

cut($dsp_old);

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
echo "[{$max}]";


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
    for($i=0;$i<$max;$i++){
        echo $fm[$i].$op[$i];
    }


    //割り算を掛け算に変換
    for($i=0;$i<$max;$i++){
        if($op[$i]=="/"){
            if($fm[$i+1] == "0" || $fm[$i+1] == ""){
                exit;
            }else{
                $fm[$i+1] = 1 / $fm[$i+1];
                $op[$i] = "*";
            }
        }
    }


    //表示
    for($i=0;$i<$max;$i++){
        echo $fm[$i].$op[$i];
    }
}

//     //引き算を足し算に変換
//     for($i=0;$i<$max;$i++){
//         if($op[$i]=="-"){
//             $fm[$i+1] = -$fm[$i+1];
//             $op[$i] = "+";
//         }
//     }

//     // //表示
//     // for($i=0;$i<$max;$i++){
//     //     echo $fm[$i].$op[$i];
//     // }


//     //掛け算を足し算に変換
//     for($i=0;$i<$max;$i++){
//         if($op[$i]=="*"){
//             $fm[$i+1] = $fm[$i] * $fm[$i+1];
//             $fm[$i] = 0;
//             $op[$i] = "+";
//         }
//     }

//     // //表示
//     // for($i=0;$i<$max;$i++){
//     //     echo $fm[$i].$op[$i];
//     // }


//     //型変換
//     for($i=0;$i<$max;$i++){
//         $fm[$i] = (float)$fm[$i];
//     }

//     //全て足す
//     $ans=0;
//     for($i=0;$i<$max;$i++){
//         $ans = $ans + $fm[$i];
//     }

//     //結果格納
//     $dsp_old = $ans;

//     //結果表示
//     echo $dsp_old;

// }

//calculate($dsp_old);

?>
</p>

</html>