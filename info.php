<?
include 'db.php';

?>

<p>Аккаунт</p>
<p style='width: 400px;'>Друзья</p>
<p>Подписчики</p>
<br/>

<?
$query = $mysqli->query("SELECT * FROM `tokens`"); //Получаем все токены
$row_count = mysqli_num_rows($query); //Количество токенов
$i = 1;
while ($i <= $row_count) { //Проходим по всем токенам
  while($row = $query->fetch_assoc()) {
    $token = $row['token']; //Записываем в буфер токен с которым работаем в данный момент
    $comment = $row['comment'];// -//- комментарий
    $friends = file_get_contents("https://api.vk.com/method/friends.get?count=1&access_token=".$token."&v=5.80"); //Выполняем запрос по получению друзей
    echo "<p>".$comment."</p>"; //Выводим комментарий в таблицу
    $json_decode = json_decode($friends, true); //Декодируем ответ
    if (isset($json_decode['error']['error_code'])) { //Если в ответе есть ошибка, выводим ошибки
      echo "<p style='width: 400px;'>Неверный токен или аккаунт удален</p>";
      echo "<p>error</p>";
    }
    else { //Если ошибок нет
      echo "<p style='width: 400px;'>".$json_decode['response']['count']."</p>"; //Выводим количество друзей
      $requests = file_get_contents("https://api.vk.com/method/friends.getRequests?count=1&out=0&access_token=".$token."&v=5.80"); //Выполяем запрос по получению подписчиков
      $json_decode = json_decode($requests, true); //Декодируем ответ
      echo "<p>".$json_decode['response']['count']."</p>"; //Выводим количество подписчиков
    }
    echo "<br/>";
  }

  $i++;
}
echo "<p style='width:100%;box-sizing: border-box;'>Автор: <a href='http://Gelloiss.ru' target='_blank'>Gelloiss.ru</a></p>";
?>

<style type="text/css">
/* А вот тут такой бред, что лучше даже не разбираться, а переписать все.
Хз почему, но выводит лишь <p> и чтобы было красиво надо много подбирать....
Да, другие теги просто нафиг не отображаются на сайт
Да, я был пьян. */
  body {
    font-size: 0;
    border: 1px solid black;
    border-right: 0;
    border-top: 0;
    display: inline-block;
    margin: 20px 35px;
  }

  p {
    border: 1px solid black;
    padding: 15px;
    display: inline-block;
    margin: 0;
    border-bottom: 0;
    font-size: 20px;
    border-left: 0;
    width: 100px;
    text-align: center;
  }
</style>