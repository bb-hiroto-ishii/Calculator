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
    

    $dsp_old = "10+8-6*4/2=";

    //i:何番目の文字を見るか
    //j:何番目の配列に入れるか
 
    ?>
</p>
<p>
    <?php



$j=0;
for($i=0;$i<5;$i++){
    $fm[$i]="";
    $op[$i]="";
}
    for($i=0;$i<=strlen($dsp_old);$i++){
        $t=substr($dsp_old,$i,1);
        if($t=="="){
            break;
        }
        if(
            $t=="+"
            || $t=="-"
            || $t=="*"
            || $t=="/"
        ){
            $op[$j]=$t;
            $j++;
        }else{
            $fm[$j].=$t;
        }
    }

    for($i=0;$i<5;$i++){
        echo $fm[$i].$op[$i];
    }

    ?>
</p><p>
    <?php

    for($i=0;$i<5;$i++){
        if($op[$i]=="/"){
            $fm[$i+1] = 1 / $fm[$i+1];
            $op[$i] = "*";
        }
    }

    for($i=0;$i<5;$i++){
        echo $fm[$i].$op[$i];
    }

    ?>
</p><p>
    <?php

    for($i=0;$i<5;$i++){
        if($op[$i]=="-"){
            $fm[$i+1] = -$fm[$i+1];
            $op[$i] = "+";
        }
    }

    for($i=0;$i<5;$i++){
        echo $fm[$i].$op[$i];
    }

    ?>
</p><p>
    <?php

//*1しかなくなるまで何回も回す
    for($i=0;$i<5;$i++){
        if($op[$i]=="*"){
            $fm[$i] = $fm[$i] * $fm[$i+1];
            $fm[$i+1] = "1";
        }
    }



    for($i=0;$i<5;$i++){
        echo $fm[$i].$op[$i];
    }

    $ans=0;
    for($i=0;$i<5;$i++){
        echo $ans += $fm[$i];
    }

    
    //$fm1=var_dump((float)$fm1);
    //$fm2=var_dump((float)$fm2);

    //$ans = $fm1+$fm2;

    //echo $ans;


    /*
    if($j_op==1){
        fm[$i] = $dsp;
        $i++; 
        $j_op=0;
    }
    */

?>
</p>
</html>