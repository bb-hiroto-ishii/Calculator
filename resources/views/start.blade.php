<!DOCTYPE html>
<html>

<head>
    <title>test</title>
</head>
<a href="http://localhost/Calculator/public/calculator">戻る</a>

<body>

    <script>

var dsp_old,j_error;
j_error=0;

dsp_old = "343.10000";

//小数値の不要な0を削除、小数値が無い時は小数点削除
//Numberで型変換すれば解決(^ω^)b
function decimal_0_clear(){

    var d_num,dp_posi,n,limit;
    limit=0;

    dsp_old = String(dsp_old);

    //小数点の位置を取得
    dp_posi = dsp_old.indexOf(".");
    console.log("dp_posi:"+dp_posi);

    //小数部取得
    d_num = dsp_old.substr(dp_posi);
    console.log("d_num:"+d_num);

    console.log("number(d_num):"+Number(d_num));

    //小数値があるか判断（小数部が0以上か）
    if(Number(d_num) > 0){
        
        n=0;
    //右から順に見て、0なら削除、0以外なら終了
        while(n!="."){
            n=dsp_old.substr(-1,1);
            console.log("n:"+n);
            if(n==0 || n=="."){
                dsp_old=dsp_old.slice(0,-1);
            }else{
                return;
            }

            //ループがバグった時強制終了させる用
            limit++;
            if(limit>100){
                j_error = 1;
                return;
            }
        }
    //小数点含む右側削除
    }else{
        dsp_old=dsp_old.slice(0,-d_num.length);
    }

    return;
}

//計算
function calculate(){

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

console.log("[op_count:"+max+"]")

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

        console.log("[fm"+i+":"+fm[i]+"]");
        console.log("[op"+i+":"+op[i]+"]");
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

        console.log("[n:"+n+"]");
    }

    for(i=0;i<max;i++){
        console.log("[formula:"+ fm[i]+op[i]+"]");
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

        console.log("[ans:"+ans+"]");
    }

    //結果格納
    dsp_old = ans;

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

}

console.log("[before:"+dsp_old+"]");

//calculate();

decimal_0_clear();

console.log("[result:"+dsp_old+"]");

//after_count_digit();



console.log("[ERROR:"+j_error+"]");


    </script>

</body>

</html>
