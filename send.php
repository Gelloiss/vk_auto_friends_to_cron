<?
include 'db.php';
$recipient_id = "-114484380"; //id кому отправляем. Группа начинается со знака -
$text_mess = urlencode("+"); //Текст сообщения который отправляем
echo "To: ".$recipient_id." Text: ".$text_mess." Decode: ".urldecode($text_mess)."<br/>";

$query = $mysqli->query("SELECT * FROM `tokens` ORDER BY `id` DESC LIMIT 1"); //Получаем последнюю запись в базе
if (mysqli_num_rows($query) == 0) { //Если данных в базе нет, останавливаем скрипт
  echo "База пуста!!!";
  exit();
}
while($row = $query->fetch_assoc()) {
  $max_id = $row['id']; //Записываем максимально возможный id токена в базе
}

$i = 0;
$test_count = 0;
while ($i == 0) { //Пока i = 0
  $rand = mt_rand(1, $max_id); //Получаем случайный токен
  $query = $mysqli->query("SELECT * FROM `tokens` WHERE `id` = '$rand'"); //Получаем данные по этому токену
  if (mysqli_num_rows($query) == 1) { //Если токен есть в базе
    while($row = $query->fetch_assoc()) { //Декодируем ответ с базы
      $token = $row['token']; //Сохраняем токен
    }
    $i = 1; //Выходим из цикла
  }
  $test_count ++; //Счетчик для проверки кол-ва раз затраченного на получения токена
}
//Можно было просто считать все токены, записать их в массив и срандомить с первого раза по индексу. Это намного ресурсо экономнее. Но идея пришла уже под конец реализации той, что описана выше, так что переписывать, пожалуй, лень

echo $test_count."<br/>";
echo $token."<br/>";
echo file_get_contents("https://api.vk.com/method/messages.send?peer_id=".$recipient_id."&message=".$text_mess."&access_token=".$token."&v=5.65"); //Отправляем сообщение

echo "<br/><br/><br/><br/><br/><br/><br/>Автор: <a href='http://Gelloiss.ru' target='_blank'>Gelloiss.ru</a>";