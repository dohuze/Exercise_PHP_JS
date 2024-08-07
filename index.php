<?
	/* Запрос в БД */
	$dbh = new PDO('mysql:dbname=***;host=***', '***', '***');
	$sth = $dbh->prepare("SELECT * FROM `list`");
	$sth->execute();
	$list = $sth->fetchAll(PDO::FETCH_ASSOC);
	//print_r($list);
?>
	<script src="script.js"></script>
	
	<style>
		.list {
			margin: 0 0 20px 24px;
			padding: 0;
			list-style-type: "⚡ ";
		}
		.list li {
			margin: 7px 0;
			font-size: 14px;
		}
		span {
			cursor: pointer;
		}
	</style>
	
	<ul class="list" id="list">
		<?foreach ($list as $row):?>
		<li id="li_<?=$row['id']?>"><?=$row['stroka']?> <span onclick="update(<?=$row['id']?>)">ИЗМЕНИТЬ</span> <span onclick="del(<?=$row['id']?>)">УДАЛИТЬ</span>					</li>
		<?endforeach?>
	</ul>
	<span id="create">Создать новый элемент</span>
	
	<script>
		let numder;
		document.getElementById("create").addEventListener("click", function() {
			//
			
			let navbar = document.getElementById("list").querySelectorAll("li");
			navbar.forEach((item, index) => {
				//console.log(navbar[index].id);
				numder = navbar[index].id.replace("li_", "");
			});
			//alert(numder);
			
			var xhr = new XMLHttpRequest();
			xhr.open("POST", "/70332/api.php" , true);
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xhr.send("type=create&id=" + numder);
			xhr.onreadystatechange = function() {
				if (xhr.readyState == 4) {
					if(xhr.status == 200) {
						//alert(xhr.responseText);
						const newListItem = document.createElement("li");
						newListItem.innerHTML = "Элемент списка № " + xhr.responseText + " <span onclick='update(" + xhr.responseText + ")'>ИЗМЕНИТЬ</span> <span onclick='del(" + xhr.responseText + ")'>УДАЛИТЬ</span>" ;
						newListItem.setAttribute("id", "li_" + xhr.responseText);
						document.querySelector('#list').appendChild(newListItem);
					}
				}
			}
		}, false);

		function del(i) {
			var xhr = new XMLHttpRequest();
			xhr.open("POST", "/70332/api.php" , true);
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xhr.send("type=del&id=" + i);
			xhr.onreadystatechange = function() {
				if (xhr.readyState == 4) {
					if(xhr.status == 200) {
						//alert(xhr.responseText);
						let li_id = "#li_" + i;
						var parent = document.querySelector(li_id).parentNode;
						parent.removeChild(document.querySelector(li_id));
					}
				}
			}
		}
		
		function update(i) {
			const newstr = prompt("Введите новое содержимое:");
			if (newstr) {
				//alert(newstr);
				var xhr = new XMLHttpRequest();
				xhr.open("POST", "/70332/api.php" , true);
				xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
				xhr.send("type=update&id=" + i + "&newstr=" + newstr);
				xhr.onreadystatechange = function() {
					if (xhr.readyState == 4) {
						if(xhr.status == 200) {
							//alert(xhr.responseText);
							const li = document.getElementById("li_" + i);
							li.innerHTML = newstr + " <span onclick='update(" + i + ")'>ИЗМЕНИТЬ</span> <span onclick='del(" + i + ")'>УДАЛИТЬ</span>" ;
						}
					}
				}
			}
		}
	</script>
