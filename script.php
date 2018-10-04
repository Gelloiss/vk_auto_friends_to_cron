<?
$timing = mt_rand(100,300);
date_default_timezone_set('Europe/Moscow');
include 'db.php';

$check = $mysqli->query("SELECT * FROM `tokens`");
if (mysqli_num_rows($check) == 0) {
  echo "База пуста!<br/>";
  exit();
}

$query = $mysqli->query("SELECT * FROM `settings` WHERE `id` = 1");
while($row = $query->fetch_assoc()) {
  $time = $row['time'];
  $last_id = $row['last_id'];
}
$next_id = $last_id+1;

$query = $mysqli->query("SELECT * FROM `tokens` ORDER BY `id` DESC LIMIT 1");
while($row = $query->fetch_assoc()) {
  $max = $row['id'];
}

if (time()-$time < $timing) {
  echo "Время задержки еще не истекло<br/>";
  exit();
}

else {
  $chek = 0;
  while ($chek != 1) {
    if ($next_id <= $max) {
      $query = $mysqli->query("SELECT * FROM `tokens` WHERE `id` = '$next_id'");
      if (mysqli_num_rows($query) == 1) {
        while($row = $query->fetch_assoc()) {
          $token = $row['token'];
        }
        $time = time();
        $mysqli->query("UPDATE `settings` SET `last_id`='$next_id', `time` = '$time' WHERE `id`=1");
        $chek = 1;
      }
      else {
        $next_id++;
        echo "id не найден, ищем дальше<br/>";
      }
    }

    else {
      $next_id = 1;
    }
  }
}

echo $token."<br/>";

$no_format = file_get_contents("https://api.vk.com/method/friends.getRequests?count=999&out=0&need_viewed=1&access_token=".$token."&v=5.80");
echo $no_format."<br/>";
$json_decode = json_decode($no_format, true);
$count = count($json_decode['response']['items']); //Количество вернувшихся нам id
echo $count."<br/>";
if ($count < 1) {
  echo "Заявок нет!<br/>";
}
$i = 0;
while ($i < $count) {
  $buf = $json_decode['response']['items'][$i];
  file_get_contents("https://api.vk.com/method/friends.add?user_id=".$buf."&access_token=".$token."&v=5.80");
  echo "vk.com/id".$buf." добавлен в друзья<br/>";
  $i++;
}


echo "<br/><br/><br/><br/><br/><br/><br/>Автор: <a href='http://Gelloiss.ru' target='_blank'>Gelloiss.ru</a>";