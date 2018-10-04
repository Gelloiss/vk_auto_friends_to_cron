<meta charset="utf-8">
<?
  include 'path.php';
  if (isset($_POST['token'])) {
    include 'db.php';

    $token = $_POST['token'];
    $comment = $_POST['comment'];

    $mysqli->query("INSERT INTO `tokens`(`token`, `comment`) VALUES ('$token', '$comment')");
  }
?>

<h2>Добавление токенов в базу</h2>
<form method="POST" action="<?echo $path;?>/base.php">
  <input style="width: 40%;" type="text" name="token" placeholder="Токен"><br/>
  <input style="width: 40%;" type="text" name="comment" placeholder="Комментарий (чтобы лучше ориентироваться при удалении)"><br/>
  <input type="submit" value="Добавить">
</form>
<br/><br/><br/>

<?
include 'db.php';

$query = $mysqli->query("SELECT * FROM `tokens` ORDER BY `id` DESC");

if (mysqli_num_rows($query)==0) {
  echo "База пуста";
}

else {
  while($row = $query->fetch_assoc()){
    echo $row['token']."<br/>".$row['comment']."<br/><a href='".$path."/base_del.php?id=".$row['id']."'>Удалить с базы</a><br/><br/><br/>";
  }
}

echo "<br/><br/><br/><br/><br/><br/><br/>Автор: <a href='http://Gelloiss.ru' target='_blank'>Gelloiss.ru</a>";