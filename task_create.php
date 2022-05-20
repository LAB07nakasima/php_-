<?php 
// var_dump($_POST);
// exit();

$deadline = $_POST['deadline'];
$weight = $_POST['weight'];

// 一つ上の階層にstorageというディレクトリ(フォルダ)を作成する
$directory_path="./storage";

// mldir=makedirectory「$directory_path」で指定されたディレクトリを作成する 0777:何でも権限あげる

if(mkdir($directory_path,0777)){
  // 作成したら作成
  var_dump('作成');
}else{
  // 作成しなかったらnot
  var_dump('not');
}
//---------------------------------
$data = array(
  // 連想配列
  "deadline" => $deadline,
  "weight" => $weight,
);

// ファイルを開けて追加する
$file= fopen('./storage/weight.csv', 'a+');
// fputcsv($file, $data);

// 配列でファイルに保存。
// だけどcsvではキー,値の形で保存される。
foreach($data as $key => $value){
  fputcsv($file, array($key, $value));
}

fclose($file);
// -------------------------------------



// $data = [
//   ['ID', '名前', '年齢'],
//   ['1', '田中', '30'],
//   ['2', '小林', '26'],
//   ['3', '江口', '32']
// ];

// $fp = fopen('./storage/member.csv', 'w+');

// foreach ($data as $line) {
// fputcsv($fp, $line);
// }

// fclose($fp);
// exit();

// $deadline = $_POST['deadline'];
// $weight = $_POST['weight'];

// // 配列にする
// // $write_data = compact('deadline' , 'weight' );

// $write_data = array(
//   "deadline" => $deadline,
//   "weight" => $weight,
// )
// // $write_data = "compact('deadline' , 'weight' )";
// // ファイルを開く
// $file = fopen('data/weight.csv' , 'w');
// flock($file, LOCK_EX);

// // 配列をcsvの形にして、fileに保存
// // var_dump($write_data);
// // var_dump($data);
// // exit();

// fputcsv($file , $write_data);

// flock($file, LOCK_UN);
// fclose($file);
// var_dump($write_data);


// foreach文の繰り返し処理で配列の値をファイルに書き込む

// flock($file, LOCK_UN);
// fclose($file);

// inputのファイルに移る
header('Location:task_input.php');

?>


<!-- fgetcsv

fgetcsv 行ごとに取得する
foreach($write_data as )
fputcsv -->