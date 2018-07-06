<?php
$menus = array(
  array('name' => 'CURRY', 'price' => 900),
  array('name' => 'PASTA', 'price' => 1200),
  array('name' => 'COFFEE', 'price' => 600)
);


$total = 0;
$maxprice = 0;
$maxPriceMenuName = "";
foreach($menus as $menu){
  echo "{$menu['name']}は{$menu['price']}円です";
  echo "</br>";
  $total += $menu['price'];
  if($maxprice < $menu['price']){
    $maxprice = $menu['price'];
    $maxPriceMenuName = $menu['name'];
  }
}

echo "合計金額は{$total}円です";
echo "</br>";
echo "{$maxPriceMenuName}が最高価格で{$maxprice}円です";
?>
