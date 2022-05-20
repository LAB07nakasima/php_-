<?php
// 日にち作成
$d = date("Y年m月d日");


$str = "";
$array = array();
$file= fopen('./storage/weight.csv', 'r');

flock($file, LOCK_EX);

if($file){
  while($line = fgetcsv($file)){
    // 配列を,を含めた文字列にする
    $str = implode(",",$line);
    
    // 文字列を,で分ける
    $str = explode(",", $str);
    // 分けた文字で連想配列を作る ['deadline'] => [2022-1-5] 
    $result[$str[0]] = $str[1];
    // var_dump($result);

    array_push($array, $result);
  }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>体重表</title>
</head>
<style>
  .body{
    width: 100%;
  }
  .weight_management{
    display : flex;
    /* justify-content: center; */
  }
  .management{
    display: flex;
    flex-direction: column;
    /* justify-content: center; */
    align-items: center;
    width: 40%;
  }
  .management_form{
    text-align: center;
  }
  
  .weightChart{
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
  }
</style>

<body>
<form action="task_create.php" method="POST" class=weight_management>
  <fieldset class=management>
    <legend class=management_form>体重管理</legend>
    <!-- <a href="task_read.php">一覧画面</a> -->
    <div>
      <p>今日は <?= $d ?> です！</p>
      日付: <input type="date" name= 'deadline'>
    </div>
    <div>
      年齢と体重を入力しよう〜！<br>
      年齢: 
      <select name="name" id="weight_date">
        <option value="10代~20代">10代~20代</option>
        <option value="20代~25代">20代~25代</option>
        <option value="25代~30代">25代~30代</option>
        <option value="30代~40代">30代~40代</option>
      </select>
      体重: 
      <input type="text" name="weight">
    </div>
    <div>
      <button>送信！</button>
    </div>
  </fieldset>
</form>

<div class=weightChart style="position:relative;width:1000px;height:500px;"> 
  <!-- ここにチャートJSを入れる -->
  <canvas id="myChart"></canvas>
  <p id=display></p>
</div>

<!-- Javasprict -->
<!-- chart.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.js"></script>


<script>
// phpのデータをJSONコードで受取る
const data_json = <?= json_encode($array)?>;
const output_display = document.getElementById('display');
// オブジェクトを文字列に変換
const json_text = JSON.stringify(data_json);
output_display.innnerHTML = json_text;
// console.log(json_text);

// 空の配列を準備
let deadline_data = [];
let weight_data = [];

// .map(x):配列の要素を一つずつ分けて処理し、結果を配列データとして返す forEachと類似
const map = data_json.map((x) => {

  // xの中のdeadlineのvalueを変数に入れる
  let deadline_number = x.deadline;
  // xの中のweightのvalueを変数に入れる
  let weight_number = x.weight;
  
  // .map関数内での変数は外で使えないので、グローバル変数にpush!
  deadline_data.push(deadline_number);  
  weight_data.push(weight_number)
});

// 文字⇨数字
Numbers_weight_data = weight_data.map(Number); 

console.log(weight_data);
console.log(Numbers_weight_data);

// グラフ
var ctx = document.getElementById("myChart");
var myLineChart = new Chart(ctx, {
  // 棒グラフ
  type: 'bar',
  // data: データ,
  data: {
    // x軸データ
    labels: deadline_data,  //deadline OK!
    // グラフのデータセット
    datasets: [{
      label: '体重',
      // Y軸のデータ
      data: Numbers_weight_data, 
      backgroundColor: 'rgba(255, 205, 86, 0.2)',
    borderColor: 'rgb(255, 205, 86)',
    borderWidth: 1
  // }] backgroundColor: '#f88',
    }], 
  }
});


// const config = {
//   type: 'bar',
//   data: data,
//   options: {
//     scales: {
//       y: {
//         beginAtZero: true
//       }
//     }
//   },
// };

// const labels = Utils.months({count: 7});
// const data = {
//   labels: labels,
//   datasets: [{
//     label: 'My First Dataset',
//     data: [65, 59, 80, 81, 56, 55, 40],
//     backgroundColor: [
//       'rgba(255, 99, 132, 0.2)',
//       'rgba(255, 159, 64, 0.2)',
//       'rgba(255, 205, 86, 0.2)',
//       'rgba(75, 192, 192, 0.2)',
//       'rgba(54, 162, 235, 0.2)',
//       'rgba(153, 102, 255, 0.2)',
//       'rgba(201, 203, 207, 0.2)'
//     ],
//     borderColor: [
//       'rgb(255, 99, 132)',
//       'rgb(255, 159, 64)',
//       'rgb(255, 205, 86)',
//       'rgb(75, 192, 192)',
//       'rgb(54, 162, 235)',
//       'rgb(153, 102, 255)',
//       'rgb(201, 203, 207)'
//     ],
//     borderWidth: 1
//   }]
// };

</script>


</body>
</html>