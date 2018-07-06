<?php

namespace MyApp;

class Calendar{
    public $[]; #index.phpよりプロパティ設定
    public $[]; #index.phpよりプロパティ設定
    public $[]; #index.phpよりプロパティ設定
    private $_thisMonth;


    public function __construct(){
        try{
            if(!isset($_GET['t']) || !preg_match(' /\A\d{4}-\d{2}\z/ ', $_GET['t'])){
                throw new \Exception();
            }
            $this -> _thisMonth = new \DateTime([]); #aタグから送られてきたkey名を取得
        }catch(\Exeption $e){
            $this -> _thisMonth = new \DateTime('first day of this month');
        }

        $this -> prev = []; #prevプロパティを作成
        $this -> next = $this -> _createNextLink();
        $this -> yearMonth = $this -> _thisMonth -> format('F Y');
    }

    private function _createPrevLink(){
        $dt =clone $this -> _thisMonth;
        []; #先月のリンクなので、今月から1ヶ月引いたものを返す
    }

    private function _createNextLink(){
        []; #$_thisMonthプロパティのクローンを作成
        return $dt->modify('+1 month') -> format('Y-m');
    }

    public function []{ #index.phpよりメソッド設定
        $tail = $this -> _getTail();
        $body = []; #_getBodyメソッド(今月の日付全てを取得するメソッド)を呼ぶ
        $head = $this -> _getHead();
        $html = []; #日付を一列で表示し、<tr></tr>で挟む
        echo $html;
    }

    private function _getTail(){ #その月の第1週が先月の末週の曜日にかかっている時、その数字をグレーで表示する
        $tail ='';
        $lastDayOfPrevtMonth = new \DateTime('last day of ' . $this -> yearMonth . '-1 month');
        while([]){ #グレーで表示する箇所の分岐点
            $tail =sprintf('<td class="gray">%d</td>',$lastDayOfPrevtMonth->format('d')).$tail;
            []);#最後にP1D期間だけ減らす
        }
        return $tail;
    }

    private function _getBody(){ #その月の日付全てを取得するメソッド
        $body ='';
        $period = new \DatePeriod(
            new \DateTime('first day of ' . $this -> yearMonth ),
            new \DateInterval('P1D'),
            new \DateTime('first day of' . $this-> yearMonth . '+1 month')
        );

        $today = new \Datetime('today');

        foreach ($period as $day) {
            if($day->format('w') === '0'){$body .= '</tr><tr>'; #日曜日（＝０）なら改行
            $todayClass = ($day -> format('Y-m-d')===$today->format('Y-m-d'))? 'today' : ''; #dayが今日の日付なら$todayClassにtodayを代入、違うなら何も代入しない
            $body .=sprintf('<td class="youbi_%d %s">%d</td>', $day->format('w'), $todayClass ,$day->format('d')); #dayが今日の日付ならtdにtodayクラスが付与され、太字になる
        }
        return $body;
    }

    private function _getHead(){ #その月の末週が来月の第1週の曜日にかかっている時、その数字をグレーで表示する
        $head = '';
        $firstDayOfNextMonth = []; #来月の先頭の日付を取得
        while([]){ #グレーで表示する箇所の分岐点
            $head .=sprintf('<td class="gray">%d</td>',$firstDayOfNextMonth->format('d'));
            $firstDayOfNextMonth->add(new \DateInterval('P1D'));
        }
        return $head;
    }

}

?>
