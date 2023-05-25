<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="{{asset('css/jvsstyle.css')}}">
        <title>JavaScript版電卓</title>
    </head>

    <body>

        <script>
        
        window.addEventListener("load",initialize);

        var dsp_old,dsp,j_dp,j_in;

        function initialize(){
            dsp_old =0;
            dsp = 0;
            j_dp=0;
            j_in=0;

            console.log(dsp_old);
            console.log(dsp);
            console.log(j_dp);
        }

        function key0(){
            dsp="0";
            return;    
        }

        function key1(){
            dsp=1;
            return;    
        }

        function key2(){
            dsp=2;
            return;    
        }

        function key3(){
            dsp=3;
            return;    
        }

        function key4(){
            dsp=4;
            return;    
        }

        function key5(){
            dsp=5;
            return;    
        }

        function key6(){
            dsp=6;
            return;    
        }

        function key7(){
            dsp=7;
            return;    
        }

        function key8(){
            dsp=8;
            return;    
        }

        function key9(){
            dsp=9;
            return;    
        }

        function keyEQ(){
            dsp="=";
            return;
        }

        function keyAD(){
            dsp="+";
            j_dp=0;
            return;
        }

        function keyDF(){
            dsp="-";
            j_dp=0;
            return;
        }

        function keyML(){
            dsp="*";
            j_dp=0;
            return;
        }

        function keyDV(){
            dsp="/";
            j_dp=0;
            return;
        }

        function keyDP(){
            dsp=".";
            j_dp=1;
            return;
        }

        function keyAC(){
            dsp_old = 0;
            dsp="";
            return;
        }
        
        function view(){
            //指定キーだったら
            if(dsp != "no_in"){
                
                //先頭0確認


                //esc以外の時
                if(dsp != ""){
                    dsp_old = ""+ dsp_old + dsp;
                }

                var testarea = document.getElementById("DSP");
                testarea.innerHTML = dsp_old;
            }
        }

        //入力済みの値を見て、先頭が0になってもいいか判断、処理
        function judge_head(){
            //先頭が0かどうか(0.も0としてはんだんされてしまうため小数点フラグも見る)
            if(dsp=="0" && j_dp==0){
                //小数点が打たれた場合
                if(dsp=="."){
                    return 0;
                }else{
                    //初期化後入力されているか
                    if(j_in==1){
                        //入力値が演算子か
                        if(
                            dsp=="+" 
                            || dsp=="-"
                            || dsp=="*"
                            || dsp=="/"
                        ){
                            return 0;
                        }else{
                            dsp_old = "";
                            return 0;
                        }
                        return 0;
                    }else{
                        dsp_old = "";
                        return 0;
                    }
                }
            }
            return 0;
        }

        //キーボード入力時の処理
        function keydownEvent(event) {
            
            var key_code = event.keyCode;
    
            switch( key_code ){
                case 13 :   keyEQ();    //enter
                            break;      //enter
                case 48 :   key0();
                            break;
                case 49 :   key1();
                            break;
                case 50 :   key2();
                            break;
                case 51 :   key3();
                            break;
                case 52 :   key4();
                            break;
                case 53 :   key5();
                            break;
                case 54 :   key6();
                            break;
                case 55 :   key7();
                            break;
                case 56 :   key8();
                            break;
                case 57 :   key9();
                            break;                
                case 187:   keyAD();
                            break;
                case 189:   keyDF();
                            break;
                case 186:   keyML();
                            break;
                case 191:   keyDV();
                            break;
                case 190:   keyDP();
                            break;
                case 27 :   keyAC(); //esc    
                            break;
                default :   dsp = "no_in";
            }
    
            console.log(dsp);

            judge_head();
            
            view();
            console.log(dsp_old);

            j_in=1;
        }
    
        //クリック時の処理
        function clickEvent(event){

            judge_head();

            view();
            console.log(dsp);
            j_in=1;
        }

        //キーボード入力検知したら処理
        window.addEventListener("keydown", keydownEvent);
        
        //クリック検知したら処理        
        window.addEventListener("click", clickEvent);

        </script>

        <div class="base" align="center">
           <p>
            <div class="display" align="right" id="DSP">
                    0
            </div>
           </p>




        <table>

            <tr>
                <td><button class="b1" onclick="key7()" name="name" value="7">7</button></td>
                <td><button class="b1" onclick="key8()" name="name" value="8">8</button></td>
                <td><button class="b1" onclick="key9()" name="name" value="9">9</button></td>
                <td><button class="b1" onclick="keyAD()" name="name" value="+">+</button></td>
            </tr>
            <tr>
                <td><button class="b1" onclick="key4()" name="name" value="4">4</button></td>
                <td><button class="b1" onclick="key5()" name="name" value="5">5</button></td>
                <td><button class="b1" onclick="key6()" name="name" value="6">6</button></td>
                <td><button class="b1" onclick="keyDF()" name="name" value="-">-</button></td>
            </tr>
            <tr>
                <td><button class="b1" onclick="key1()" name="name" value="1">1</button></td>
                <td><button class="b1" onclick="key2()" name="name" value="2">2</button></td>
                <td><button class="b1" onclick="key3()" name="name" value="3">3</button></td>
                <td><button class="b1" onclick="keyML()" name="name" value="*">×</button></td>
                <td rowspan="2">
                    <button class="b2" onclick="keyEQ()" name="name" value="=">=</button></td>
            </tr>
            <tr>
                <td><button class="b1" onclick="keyAC()" name="name" value="AC">AC</button></td>
                <td><button class="b1" onclick="key0()" name="name" value="0">0</button></td>
                <td><button class="b1" onclick="keyDP()" name="name" value=".">.</button></td>
                <td><button class="b1" onclick="keyDV()" name="name" value="/">÷</button></td>
            </tr>

        </table>
        </div>
    </body>

</html>