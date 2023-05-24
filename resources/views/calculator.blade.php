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

                    //計算
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
                        //echo $dsp_old;

                    }


                    //初期化処理
                    function initialize(&$dsp_old,&$dsp,&$j_in,&$j_dp,&$j_op){
                        $dsp_old="0";
                        $dsp="0";
                        $j_in=0;
                        $j_dp=0;
                        $j_op=0;
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
                        
                    //入力値あるかどうか
                    if(isset($dsp)){
                        //ACが押されたかどうか
                        if($dsp == "AC")
                        {
                            //表示を初期化
                            //$dsp_old="0";
                            initialize($dsp_old,$dsp,$j_in,$j_dp,$j_op);
                            
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

/*
                            //演算子入力だった場合、数値と演算子を個別保存
                            if(
                                $dsp=="+" 
                                || $dsp=="-"
                                || $dsp=="×"
                                || $dsp=="÷"
                            ){
                                $fm[i]=$dsp_old;
                                $op[i]=$dsp;
                                i++;
                            }
*/
                            
                            

                            //前回の入力値に今回の入力値をくっつける。
                            $dsp_old .= $dsp;

                            //初期化後入力フラグ上げ
                            $j_in=1;
                        }
                        
                    }else{
                        //初期値設定
                        initialize($dsp_old,$dsp,$j_in,$j_dp,$j_op);
                    }
                    

                    //計算結果表示
                    if($dsp=="="){
                        calculate($dsp_old);
                    }
                    echo $dsp_old;
                    //echo "&".$dsp;

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
                        $j_op
                        );

                    //echo $var[0],$var[1];

                for($i=0;$i<4;$i++){
                    echo "<input type=\"hidden\" name=\"var{$i}\" value=\"{$var[$i]}\">";
                }    
                

                ?>


            </div>
            </p>

            <table>
                <tr>
                    <td><button class="b1" type="submit" name="name" value="7">7</button></td>
                    <td><button class="b1" type="submit" name="name" value="8">8</button></td>
                    <td><button class="b1" type="submit" name="name" value="9">9</button></td>
                    <td><button class="b1" type="submit" name="name" value="+">+</button></td>
                </tr>
                <tr>
                    <td><button class="b1" type="submit" name="name" value="4">4</button></td>
                    <td><button class="b1" type="submit" name="name" value="5">5</button></td>
                    <td><button class="b1" type="submit" name="name" value="6">6</button></td>
                    <td><button class="b1" type="submit" name="name" value="-">-</button></td>
                </tr>
                <tr>
                    <td><button class="b1" type="submit" name="name" value="1">1</button></td>
                    <td><button class="b1" type="submit" name="name" value="2">2</button></td>
                    <td><button class="b1" type="submit" name="name" value="3">3</button></td>
                    <td><button class="b1" type="submit" name="name" value="*">×</button></td>
                    <td rowspan="2"><button class="b2" type="submit" name="name" value="=">=</button></td>
                </tr>
                <tr>
                    <td><button class="b1" type="submit" name="name" value="AC">AC</button></td>
                    <td><button class="b1" type="submit" name="name" value="0">0</button></td>
                    <td><button class="b1" type="submit" name="name" value=".">.</button></td>
                    <td><button class="b1" type="submit" name="name" value="/">÷</button></td>
                </tr>
            </table>
        </form>
    </div>
</body>

</html>