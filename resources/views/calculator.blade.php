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
                                        || $dsp=="×"
                                        || $dsp=="÷"
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
                    echo $dsp_old;
                    
                    //echo "&".$dsp;

                    //フラグ処理
                    switch($dsp){   
                        case ".":   $j_dp=1;
                                    break;
                        case "+":   
                        case "-":
                        case "÷":
                        case "×":   $j_op=1;
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
                    <td><button class="b1" type="submit" name="name" value="×">×</button></td>
                    <td rowspan="2"><button class="b2" type="submit" name="name" value="=">=</button></td>
                </tr>
                <tr>
                    <td><button class="b1" type="submit" name="name" value="AC">AC</button></td>
                    <td><button class="b1" type="submit" name="name" value="0">0</button></td>
                    <td><button class="b1" type="submit" name="name" value=".">.</button></td>
                    <td><button class="b1" type="submit" name="name" value="÷">÷</button></td>
                </tr>
            </table>
        </form>
    </div>
</body>

</html>