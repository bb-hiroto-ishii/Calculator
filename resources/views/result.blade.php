<!DOCTYPE html>
<html>
    <a href="http://localhost/Calculator/public/calculator">戻る</a>
    <div>
    <p>結果だよ</p>
    <?PHP
    if(isset($dsp)){ 
        echo "{$dsp}だよ";    
    }else{
        echo "nullだよ";
    }
    

    ?>
    </div>    
</html>