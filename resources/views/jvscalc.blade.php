<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="{{asset('css/jvsstyle.css')}}">
        <title>JavaScript版電卓</title>
    </head>

    <body>

        <script>
        
        window.addEventListener("load",stand_up);

        var dsp_old,dsp,j_dp,j_in;

        function initialize(){
            dsp_old =0;
            dsp = 0;
            j_dp=0;
            j_in=0;
            j_op=0;
            j_error=0;

            //console.log(dsp_old);
            //console.log(dsp);
            //console.log(j_dp);

        }

        function stand_up(){
            initialize();
            view(dsp_old);
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
            return;
        }

        function keyDF(){
            dsp="-";
            return;
        }

        function keyML(){
            dsp="*";
            return;
        }

        function keyDV(){
            dsp="/";
            return;
        }

        function keyDP(){
            dsp=".";
            return;
        }

        function keyAC(){
            dsp="AC";
            return;
        }

        //計算
        function calculate(){

        //console.log("calstart");
        //console.log("dsp_old:"+dsp_old);

        var fms,max,i,len,n,j,ans;

        fms = dsp_old;

        //演算子の数
        max=0;

        //式文字数
        len=fms.length;

        //演算子の数を数える
        for(i=0;i<=len;i++){
            //$i番目の文字を取得
            n=fms.substr(i,1);
            //=まで来たらループ抜ける
            if(n=="="){
                max++;
                break;
            
            //文字が演算子だったら
            }else if(
                n=="+"
                || n=="-"
                || n=="*"
                || n=="/"
            ){
                max++;
            }
        }

        //console.log("[op_count:"+max+"]")

            //先頭に符号があった場合
            //先頭の文字
            n=fms.substr(0,1);

            switch(n){
                case "+":
                case "-":   fms = "0"+fms;
                            max++;
                            break;
                case "*":
                case "/":   j_error = 1;
                            return;

            }


            //末尾に符号があった場合エラー
            n=fms.substr(-2,1);

            if(
                n=="+"
                || n=="-"
                || n=="*"
                || n=="/"
            ){
                j_error=1;
                return;
            }

            //必要数分配列を用意
            var fm = new Array(max);
            var op = new Array(max);


            for(i=0;i<max;i++){

            //配列初期化
            fm[i] = "";
            op[i] = "";

                //console.log("[fm"+i+":"+fm[i]+"]");
                //console.log("[op"+i+":"+op[i]+"]");
            }

            
            
            //ループ用、
            j=0;

            //数値と符号を分けてそれぞれ配列に入れる
            for(i=0;i<=fms.length;i++){
                //$i番目の文字を取得
                n=fms.substr(i,1);
                //=まで来たらループ抜ける
                if(n=="="){
                    break;
                }
                //文字が演算子だったら
                if(
                    n=="+"
                    || n=="-"
                    || n=="*"
                    || n=="/"
                ){
                    //演算子用配列に入れる
                    op[j]=n;

                    //$op[$j]の前に数値がなかったら、
                    if(!fm[j]){
                        //+or-の後に*or/が続く時はエラー
                        if(op[j]=="*" || op[j]=="/"){
                            j_error = 1;
                            return;
                        //+or-の後に-が続く時は式変換
                        }else if(op[j]=="-"){
                            switch(op[j-1]){
                                case "+":   op[j-1]="-";
                                            break;
                                case "-":   op[j-1]="+";
                                            break;
                                case "*":
                                case "/":   fm[j-1]=-fm[j-1]; 
                                            break;
                            }
                        }
                        //+なら無視する
                    }else{
                        j++;
                    }
                }else{
                    fm[j] = " " + fm[j] + n;
                }

                //console.log("[n:"+n+"]");
            }

            for(i=0;i<max;i++){
                //console.log("[formula:"+ fm[i]+op[i]+"]");
            }

            //型変換
            for(i=0;i<max;i++){
                fm[i] = Number(fm[i]);
            }

            //割り算を掛け算に変換
            for(i=0;i<max;i++){
                if(op[i]=="/"){
                    if(fm[i+1]==0 || fm[i+1]==""){
                        j_error = 1;
                        return;
                    }
                    fm[i+1] = (1 / fm[i+1]).toPrecision();
                    op[i] = "*";
                }
            }

            //引き算を足し算に変換
            for(i=0;i<max;i++){
                if(op[i]=="-"){
                    fm[i+1] = -fm[i+1];
                    op[i] = "+";
                }
            }

            //掛け算を足し算に変換
            for(i=0;i<max;i++){
                if(op[i]=="*"){

                    if(fm[i+1]==""){
                        j_error = 1;
                        return;
                    }

                    fm[i+1] = fm[i] * fm[i+1];
                    fm[i] = 0;
                    op[i] = "+";
                }
            }

            for(i=0;i<max;i++){
                console.log("[changed_formula:"+fm[i]+"@"+op[i]+"]");
            }

            //全て足す
            ans=0;
            for(i=0;i<max;i++){
                ans = ans + fm[i];

                //console.log("[ans:"+ans+"]");
            }

            //結果格納
            dsp_old = Number(ans).toFixed(20);

        }
        
        //計算前桁数制御
        function count_digit(){

            var max,len,result,count,i,n;

            max = 8;                //最大桁数8
            len = dsp_old.length;  //既入力文字列の長さ取得
            count = 0;              //カウンタ

            //後ろから順に、演算子以外を抜き出す
            for(i=1;i<=len;i++){ 
                n = dsp_old.substr(-i,1);

                //console.log("[n"+i+":"+n+"]");

                //見ているところが演算子だったら処理終了
                if(
                    n=="+"
                    || n=="-"
                    || n=="*"
                    || n=="/"
                ){
                    return;
                //それ以外ならカウントアップ
                }else{
                    //小数点だったら限界桁数+1
                    if(n == "."){
                        max = 9;
                    }
                    count++;

                    //カウントが最大桁数超えたらエラーフラグ上げ
                    if(count>max){
                        j_error=1;
                        //console.log("error");
                        return;
                    }
                }
            }
        }

        //入力値受け取り処理
        function get_input(){
            //指定キーだったら
            if(dsp != "no_in"){
                
                //入力値が小数点だったら
                if(dsp == "."){
                    //小数点入力していいかどうか
                    //小数点が既に入力されていたら制限
                    if(j_dp==1){
                        //console.log("j_dp:1")
                        dsp="";

                    //小数点入力されていなかったら、
                    }else{
                        //小数点フラグ上げ
                        j_dp = 1;
                    }
                    
                    //既入力値が演算子なら,
                    if(j_op == 1){
                        dsp = "0.";
                    }

                }

                //入力値が演算子なら
                if(
                    dsp == "+"
                    || dsp == "-"
                    || dsp == "*"
                    || dsp == "/"
                ){
                    //演算子フラグ上げ
                    j_op=1;
                    //小数点フラグ下げ
                    j_dp=0;

                    //演算子以外の入力で演算子フラグ下げ
                }else{
                    j_op=0;
                }
            
                dsp_old = ""+ dsp_old + dsp;
            }
        }

        //表示処理
        function view(text){

            if(j_error==1){
                text = "ERROR";
            }

            var testarea = document.getElementById("DSP");
            testarea.innerHTML = text;
        }

        //入力済みの値を見て、先頭が0になってもいいか判断、処理
        function judge_head(){

            //デバッグ用
            //console.log("judge_head起動");

            //先頭が0かどうか(0.も0としてはんだんされてしまうため小数点フラグも見る)
            if(dsp_old=="0" && j_dp==0){

                //デバッグ用
                //console.log("in1");

                //小数点が打たれた場合
                if(dsp=="."){

                    //デバッグ用
                    //console.log("in4");

                    return 0;
                }else{

                    //初期化後入力されているか
                    if(j_in==1){

                        //デバッグ用
                        //console.log("in2");

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

                        //デバッグ用
                        //console.log("in3");

                        dsp_old = "";
                        return 0;
                    }
                }
            }
            return 0;
        }

        //3桁区切り処理
        function cut(){

        var len,fake,view,c,i,n,del;

        dsp_old = String(dsp_old);
        len = dsp_old.length;
        fake = "";
        view = "";
        c = 0;

        //デバッグ用
        //console.log("len:"+len);
        //console.log("dsp_old:"+dsp_old);

        //末尾から順に抽出

        for(i=1;i<=len;i++){
            n = dsp_old.substr(-i,1);

            //console.log("n:"+n);

            //*と/を変換
            if(n=="*"){
                n = "×";
            }
            if(n=="/"){
                n = "÷";
            }
            
            
            //抽出文字が数字だったら
            if(isNaN(n)==false){

                //console.log("n=number");

                //書き込み済み数字が3桁だったら"，"を挟む
                if(c>2){
                    fake = ","+fake;      
                    c=1;  
                }else{
                    //3桁いってなかったらカウントアップ  
                    c++;
                }
            
            //数字じゃなかったらカウンタリセット
            }else{

                //console.log("n=not_number");

                c=0;
            }
                //表示用文字列として書き込む
                fake = ""+n+fake;

                //デバッグ用
                //console.log("[count:"+c+"]");
                //console.log("[fake:"+fake+"]");
        }


        //改めて先頭から見て、小数部に","があったら消す。
        len = fake.length;
        del = 0;

        //デバッグ用
        //console.log("[fake:"+fake+"]");

        for(i=0;i<len;i++){
            n = fake.substr(i,1);

            //削除フラグがあがっているときは、","を無視
            if(del==1){
                if(n!=","){
                    view = "" + view + n;
                }
                //数字以外の文字（,は除く）が出てきたら、削除フラグ下げる
                if(isNaN(n)==true && n!=","){
                    del=0;
                }
            }else{
                view = "" + view + n;
            }

            //追加した文字が小数点だったら、","削除フラグ上げる
            if(n=="."){
                del=1;
            }

            //デバッグ用
            //console.log("[del_flg:"+del+"]");
            

        }
            return view;
        }

        //計算結果が、8桁を超える場合は、上から8桁分表示
        function after_count_digit(){

        dsp_old = String(dsp_old);

        //最大桁数8桁
        len_max = 8;

        //負の数の時の符号は含まないので+1桁
        if(dsp_old<0){
            len_max++;
        } 

        //少数点も含まないので+1桁
        if(dsp_old.indexOf(".")!=-1){
            len_max++;
        }

        //入力済みの桁が限界をこえてたら
        if(len_max<dsp_old.length){
            dsp_old = dsp_old.substr(0,len_max);
        }

            return dsp_old;
        }

        //キーボード入力時の処理
        function keydownEvent(event) {
            
            var key_code = event.keyCode;
    
            //入力キーごとに関数呼び出し（入力値設定）
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
                default :   dsp="";
            }

            //入力なしの時は何もしないで終了
            if(dsp==""){
                return;
            }

            if(dsp=="="){

                judge_head();
                
                get_input();

                calculate();

                after_count_digit();

                view(cut());
                
                initialize();

            }else{

                //入力がACだった時は、再起動
                if(dsp=="AC"){
                    stand_up();
                }else{

                    //console.log(dsp);

                    judge_head();
                    
                    get_input();

                    count_digit();

                    view(cut());
                    //console.log(dsp_old);

                    j_in=1;
                }
            }
        }
    
        //クリック時の処理
        function clickEvent(event){

            //ボタン以外をクリックしたら入力なし判定
            if(!(event.target.closest(".b1") || event.target.closest(".b2")))
            {
                dsp="";
            }

            //入力なしの時は何もしないで終了
            if(dsp==""){
                return;
            }

            if(dsp=="="){

                judge_head();

                get_input();

                calculate();

                after_count_digit();

                view(cut());

                initialize();

            }else{

            //入力がACだった時は、再起動
            if(dsp=="AC"){
                stand_up();
            }else{

                //console.log(dsp);

                judge_head();
                
                get_input();

                count_digit();

                view(cut());

                //console.log(dsp_old);

                j_in=1;
            }

        }
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