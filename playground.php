<div class="container">
    <div class="card">
        <h2>Lets play with some dice animations</h2>
<?php
$dice = array( rand(1,6), rand(1,6), rand(1,6), rand(1,6) );
    foreach ($dice as &$value){
        for ($i = 1; $i < 7; $i++){

            if ($value == $i){
                echo '<img src="img/dice'.$i.'.png" class="die">';
            }
        }
    }
    unset($value);
   // var_dump($dice);
?>
    </div>
    <div class="card">
        <h2>Lets play with some dice animations</h2>
<?php
$rando = rand(4,20);
$rando = -$rando;
$dice = array( rand(1,6), rand(1,6), rand(1,6), rand(1,6) );
    foreach ($dice as &$value){
        for ($i = 1; $i < 7; $i++){

            if ($value == $i){
                echo '<img src="img/dice'.$i.'.png" class="die">';
            }
        }
    }
    unset($value);
    echo '<br><br>';
    echo $rando;
   // var_dump($dice);
?>
    </div>
</div>

<script src="playground.js"></script> 