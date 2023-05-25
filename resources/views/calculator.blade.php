<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <p>
        <title>電卓</title>
    </p>

    <!--    <a href="http://localhost/Calculator/public/start">いきごみ</a>
-->
</head>

<body>

    <div class="base" align="center">
        <!--        <form action="result" method="POST"> -->
        <form action="calculator" method="POST">
            @csrf
            <p>
            <div class="display" align="right">
                <?PHP

                    //デバッグ用
                    function console_log($str="",$data){
                        $data = "{$str}:{$data}";
                    echo '<script>';
                    echo 'console.log('.json_encode($data).')';
                    echo '</script>';
                    }

                    //計算
                    function calculate(&$dsp_old,&$j_error){

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
                            case "/":   //$dsp_old = "ERROR";
                                        $j_error = 1;
                                        return;

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
                                        //$dsp_old = "ERROR";
                                        $j_error = 1;
                                        return;
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

                        //型変換
                        for($i=0;$i<$max;$i++){
                            $fm[$i] = (float)$fm[$i];
                        }

                        //式を表示
                        // for($i=0;$i<$max;$i++){
                        //     echo $fm[$i].$op[$i];
                        // }


                        //割り算を掛け算に変換
                        for($i=0;$i<$max;$i++){
                            if($op[$i]=="/"){
                                if($fm[$i+1]==0 || $fm[$i+1]==""){
                                    //$dsp_old = "ERROR";
                                    $j_error = 1;
                                    return;
                                }
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
<<<<<<< Updated upstream
=======
                                if($fm[$i+1]==""){
                                    //$dsp_old = "ERROR";
                                    $j_error = 1;
                                    return;
                                }
>>>>>>> Stashed changes
                                $fm[$i+1] = $fm[$i] * $fm[$i+1];
                                $fm[$i] = 0;
                                $op[$i] = "+";
                            }
                        }

                        // //表示
                        // for($i=0;$i<$max;$i++){
                        //     echo $fm[$i].$op[$i];
                        // }


                        // //型変換
                        // for($i=0;$i<$max;$i++){
                        //     $fm[$i] = (float)$fm[$i];
                        // }

                        //全て足す
                        $ans=0;
                        for($i=0;$i<$max;$i++){
                            $ans = $ans + $fm[$i];
                        }

                        //結果格納
                        $dsp_old = $ans;

                        //結果表示
                        //echo $dsp_old;

                    }

                    //3桁区切り処理
                    function cut(&$dsp_old){
    
                        $len = strlen($dsp_old);
                        $fake = "";
                        $view = "";
                        $c = 0;
                        
                        //デバッグ用
                        console_log("len",$len);

                        for($i=$len-1;$i>=0;$i--){
                            //echo "{$i}:";
                            //$n[$i] = substr($dsp_old,$i,1);
                            $n = substr($dsp_old,$i,1);

                            //*と/を変換
                            if($n=="*"){
                                $n = "×";
                            }
                            if($n=="/"){
                                $n = "÷";
                            }
                            
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

                        //デバッグ用
                        console_log("fake",$fake);

                        for($i=0;$i<$len;$i++){
                            $n = substr($fake,$i,1);
                        
                            

                            //削除フラグがあがっているときは、","を無視
                            if($del==1){
                                if($n!=","){
                                    $view = $view.$n;
                                }
                                //数字以外の文字（,は除く）が出てきたら、削除フラグ下げる
                                if(is_numeric($n)==false && $n!=","){
                                    $del=0;
                                }
                            }else{
                                $view = $view.$n;
                            }

                            //追加した文字が小数点だったら、","削除フラグ上げる
                            if($n=="."){
                                $del=1;
                            }

                            //デバッグ用
                            console_log("del_flg",$del);
                            

                        }

                        return $view;

                    }

                    //初期化処理
                    function initialize(&$dsp_old,&$dsp,&$j_in,&$j_dp,&$j_op,&$len){
                        $dsp_old="0";
                        $dsp="0";
                        $j_in=0;
                        $j_dp=0;
                        $j_op=0;
                        $len=1;
                    }

                    //先頭が0か判断、0なら処理
                    function judge_head(&$dsp_old,&$dsp,&$j_in,&$j_dp,&$j_op){
                        //先頭が0かどうか(0.も0としてはんだんされてしまうため小数点フラグも見る)
                        if($dsp_old=="0" && $j_dp==0){
                            //小数点が打たれた場合
                            if($dsp=="."){
                                return 0;
                            }else{
                                //初期化後入力されているか
                                if($j_in==1){
                                    //入力値が演算子か
                                    if(
                                        $dsp=="+" 
                                        || $dsp=="-"
                                        || $dsp=="*"
                                        || $dsp=="/"
                                    ){
                                        return 0;
                                    }else{
                                        $dsp_old = "";
                                        return 0;
                                    }
                                    return 0;
                                }else{
                                    $dsp_old = "";
                                    return 0;
                                }
                            }
                        }
                        return 0;
                    }
                        
                    //ここからメインルート
                    $j_error = 0;
                    $j_lock = 0;

                    //入力値あるかどうか
                    if(isset($dsp)){
                        
                        //ACが押されたかどうか
                        if($dsp == "AC")
                        {
                            //表示を初期化
                            //$dsp_old="0";
                            initialize($dsp_old,$dsp,$j_in,$j_dp,$j_op,$len);
                            
                        }else{                            
                            
                            //先頭が0かどうか確認
                            judge_head($dsp_old,$dsp,$j_in,$j_dp,$j_op);

                            //小数点入力していいか
                            if($dsp=="."){
                                if($j_dp==0){
                                    $j_dp=1;
                                }else{
                                    $dsp="";
                                }
                            }

                            //前回の入力値に今回の入力値をくっつける。
                            $dsp_old .= $dsp;

                            //入力フラグ上げ
                            if($dsp != "="){
                                $j_in=1;
                            }
                        }
                        
                    }else{
                        //初期値設定
                        initialize($dsp_old,$dsp,$j_in,$j_dp,$j_op,$len);
                    }

                    // //入力値の限界桁は8桁
                    // $len_max = 8;
                    // //小数点があった場合は9桁
                    // if($j_dp==1){
                    //     $len_max = 9;
                    // } 
                    // //入力済みの桁が限界をこえてたら
                    // if($len+1>$len_max){
                    //     if(
                    //         $dsp=="+" 
                    //         || $dsp=="-"
                    //         || $dsp=="*"
                    //         || $dsp=="/"
                    //     ){
                    //         //なにもしない
                    //     }else{
                    //         //エラー
                    //         $j_error = 1;
                    //     }
                    // }

                    //デバッグ用
                    console_log("文字数",$len+1);
                    console_log("限界文字数",$len_max);

                    //表示フェーズ
                    //=が入力されていた場合は計算
                    if($dsp=="="){

                        //入力制限フラグ上げる
                        //何も入力してない時は、＝押しても入力制限しない
                        if($j_in != 0){
                            $j_lock = 1;
                        }

                        //計算処理
                        calculate($dsp_old,$j_error);

                        //エラーフラグ確認用
                        //echo "j_error[{$j_error}]";

                        //計算結果が、8桁を超える場合は、上から8桁分表示
                        $len_max = 8;
                        //負の数の時の符号は含まないので+1桁
                        if($dsp_old<0){
                            $len_max++;
                        } 

                        //少数点も含まないので+1桁
                        if(strpos($dsp_old,".")!=false){
                            $len_max++;
                        }

                        //入力済みの桁が限界をこえてたら
                        if($len_max<strlen($dsp_old)){
                            $dsp_old = substr($dsp_old,0,$len_max);
                        }

                        //計算結果表示
                        if($j_error == 1){
                            echo "ERROR";
                            $j_lock = 1;
                        }else{
                            echo cut($dsp_old);
                        }
                        initialize($dsp_old,$dsp,$j_in,$j_dp,$j_op,$len);
                    }else{

                        //入力値表示
                        if($j_error == 1){
                            echo "ERROR";
                            $j_lock = 1;
                        }else{
                            echo cut($dsp_old);
                        }
                            //echo "&".$dsp;
                        
                        //桁カウント
                        //入力値が演算子の時、初期値から変わッて無い時、リセット
                        if(
                            $dsp=="+" 
                            || $dsp=="-"
                            || $dsp=="*"
                            || $dsp=="/"
                            || strlen($dsp_old)==1
                        ){
                            $len = 1;
                        }else{
                            $len++;
                        }

                        //表示
                        //echo "len:[{$len}]";
                    }

                    //フラグ処理
                    switch($dsp){   
                        case ".":   $j_dp=1;
                                    break;
                        case "+":   
                        case "-":
                        case "*":
                        case "/":   $j_op=1;
                                    //$j_dp=0;
                                    //↑演算子入力によって、「表示固定し、dsp_oldリセット」のロジック書いたらコメント解除する
                                    break;
                    }                                           

                    //hiddenで渡す変数を配列に格納
                    $var = array(
                        $j_in,
                        $dsp_old,
                        $j_dp,
                        $j_op,
                        $len
                        );

                    //echo $var[0],$var[1];

                for($i=0;$i<5;$i++){
                    echo "<input type=\"hidden\" name=\"var{$i}\" value=\"{$var[$i]}\">";
                }    
                

                ?>


            </div>
            </p>

            <table>

                <tr>
                    <td><button class="b1" type="submit" name="name" value="7" 
                        <?php if($j_lock == 1){echo "disabled";} ?>     >7</button></td>
                    <td><button class="b1" type="submit" name="name" value="8" 
                        <?php if($j_lock == 1){echo "disabled";} ?>     >8</button></td>
                    <td><button class="b1" type="submit" name="name" value="9" 
                        <?php if($j_lock == 1){echo "disabled";} ?>     >9</button></td>
                    <td><button class="b1" type="submit" name="name" value="+" 
                        <?php if($j_lock == 1){echo "disabled";} ?>     >+</button></td>
                </tr>
                <tr>
                    <td><button class="b1" type="submit" name="name" value="4" 
                        <?php if($j_lock == 1){echo "disabled";} ?>     >4</button></td>
                    <td><button class="b1" type="submit" name="name" value="5" 
                        <?php if($j_lock == 1){echo "disabled";} ?>     >5</button></td>
                    <td><button class="b1" type="submit" name="name" value="6" 
                        <?php if($j_lock == 1){echo "disabled";} ?>     >6</button></td>
                    <td><button class="b1" type="submit" name="name" value="-" 
                        <?php if($j_lock == 1){echo "disabled";} ?>     >-</button></td>
                </tr>
                <tr>
                    <td><button class="b1" type="submit" name="name" value="1" 
                        <?php if($j_lock == 1){echo "disabled";} ?>     >1</button></td>
                    <td><button class="b1" type="submit" name="name" value="2" 
                        <?php if($j_lock == 1){echo "disabled";} ?>     >2</button></td>
                    <td><button class="b1" type="submit" name="name" value="3" 
                        <?php if($j_lock == 1){echo "disabled";} ?>     >3</button></td>
                    <td><button class="b1" type="submit" name="name" value="*" 
                        <?php if($j_lock == 1){echo "disabled";} ?>     >×</button></td>
                    <td rowspan="2">
                        <button class="b2" type="submit" name="name" value="=" 
                        <?php if($j_lock == 1){echo "disabled";} ?>     >=</button></td>
                </tr>
                <tr>
                    <td><button class="b1" type="submit" name="name" value="AC">AC</button></td>
                    <td><button class="b1" type="submit" name="name" value="0" 
                        <?php if($j_lock == 1){echo "disabled";} ?>     >0</button></td>
                    <td><button class="b1" type="submit" name="name" value="." 
                        <?php if($j_lock == 1){echo "disabled";} ?>     >.</button></td>
                    <td><button class="b1" type="submit" name="name" value="/" 
                        <?php if($j_lock == 1){echo "disabled";} ?>     >÷</button></td>
                </tr>

            </table>
        </form>
    </div>
</body>

</html>