<?	error_reporting(E_ERROR | E_PARSE);

	try {
		/* Запрос в БД */
		$dbh = new PDO('mysql:dbname=***;host=***', '***', '***');
		$dbh->exec("set names utf8");
	} catch (PDOException $e) {
		echo $e->getMessage();
		exit;
	}
	
	if($_POST['type'] == 'create') {
		$_POST['id'] = $_POST['id'] + 1;
		$sth = $dbh->prepare("INSERT INTO `list` SET `id` = :id, `stroka` = :stroka");
		$sth->execute(array('id' => $_POST['id'], 'stroka' => 'Элемент списка № ' . $_POST['id']));
		$insert_id = $dbh->lastInsertId();
		echo $insert_id;
	}
	
	if($_POST['type'] == 'del') {
		$sth = $dbh->prepare("DELETE FROM `list` WHERE `id` = :id");
		$sth->execute(array('id' => $_POST['id']));
	}
	
	if($_POST['type'] == 'update') {
		$sth = $dbh->prepare("UPDATE `list` SET `stroka` = :stroka WHERE `id` = :id");
		$sth->execute(array('stroka' => $_POST['newstr'], 'id' => $_POST['id']));
	}
