<!DOCTYPE html>
<html>
<body>
    
<pre>
    <?php
    $a = 5;
    $b = 5.4;
    $c = "Hello, World!";
    $d = true;
    $e = NULL;

    $a = (string)$a;
    $b = (string)$b;
    $d = (string)$d;
    $e = (string)$e;

    var_dump($a);
    var_dump($b);
    var_dump($c);
    var_dump($d);
    var_dump($e);

    echo"nilai pi : ".pi();
    echo"<br>NIlai Min :" .min(3,5,1,6,7,8,0,-2);
    echo"<br>NIlai Max :" .max(3,5,1,6,7,8,0,-2);
    echo"<br>Nilai Absolute :".abs(-6.7);
    echo"<br>Nilai Pembulatan :".round(4.3);
    echo"<br>Nilai Pembulatan ke atas :".ceil(4.3);
    echo"<br>Nilai Pembulatan ke bawah :".floor(4.7);
    echo"<br>Nilai Random :".rand(1,100);

    $t = date("H");
    echo"<br>Jam : $t ";
    if ($t < "20") {
        echo "Have a good day!";
    }

    $d = date("D");
    echo "<br>Hari : $d ";
    switch ($d) {
        case "Mon":
            echo "It's Monday, start of the work week!";
            break;
        case "Tue":
            echo "It's Tuesday, keep going!";
            break;
        case "Wed":
            echo "It's Wednesday, halfway there!";
            break;
        case "Thu":
            echo "It's Thursday, almost the weekend!";
            break;
        case "Fri":
            echo "It's Friday, last day of the work week!";
            break;
        case "Sat":
            echo "It's Saturday, enjoy your weekend!";
            break;
        case "Sun":
            echo "It's Sunday, relax and prepare for the week ahead!";
            break;
        default:
            echo "Unknown day!";
        }

        $i = 1 ;
        while($i <= 5) {
            if($i == 3) {
                echo "<br>Ini adalah nilai tiga!";
                $i++;
                continue;
            }
            echo "<br>Nilai i : $i";
            $i++;
        }

        for($j = 1; $j <= 5; $j++) {
            if($j == 4) break;
            echo "<br>Nilai j : $j";
        }
        for($j = 1; $j <= 5; $j++) {
            if($j == 4) continue  ;
            echo "<br>Nilai j : $j";
        }

        






        ?>
</pre>
</body>
</html>