<?php
namespace MyApp;
class Bingo {
    public function create(){
        $random_nums =[];
        for($i = 0;$i<5; $i++){#B,I,N,G,Oの5回分繰り返す
            $col = range($i*15+1 , $i*15+15);
            shuffle($col);
            $random_nums[$i] =  array_slice($col,0,5); #colを配列にし、0番目から5番目をrandom_numsのi番目に代入
        }
        $random_nums[2][2] = "FREE";
        return $random_nums;
    }
}
?>
