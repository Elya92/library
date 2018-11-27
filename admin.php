<?php
	//форма добавления книги и кнопки перехода на страницу удаления книг
	$cntnt = "
		<form method=\"post\" enctype=\"multipart/form-data\" action=\"admin.php\">
			<br><br>
			Введите автора:
			<br>
			<input type=\"text\" name=\"atr\" size=\"30\">
			<br><br>
			Введите название книги:
			<br>
			<input type=\"text\" name=\"bk\" size=\"40\">
			<br><br>
			Выберите жанр книги:
			<br>
			<input type=\"radio\" name=\"gnr\" value=\"1\" checked>
			Классика
			<br>
			<input type=\"radio\" name=\"gnr\" value=\"2\" checked>
			Детектив
			<br>
			<input type=\"radio\" name=\"gnr\" value=\"3\" checked>
			Поэзия
			<br><br>
			<input type=\"file\" name=\"img\" accept=\"image/jpeg\">
			<br><br>
			<input type=\"submit\" name=\"add\" value=\"Добавить\">
		</form>
		<form method=\"post\" action=\"delete.php\">
			<br><br>
			<input type=\"submit\" name=\"del\" value=\"Перейти на страницу удаления книг\">
		</form>
	";
	//если введен пароль, а не случайно пользователь нашел эту страницу
	if (isset($_POST["oka"]) AND $_POST["oka"]){
		$title = "Страница администратора"; //задаем название страницы
		$pswd = htmlentities($_POST["pswd"]); //введенный пароль преобразуем для защиты от взлома
		$file_pswd = fopen("password.txt", "r"); //открываем файл с паролем
		$data = file("password.txt"); //считываем пароль
		if (preg_match("/^$pswd$/", $data[0])){	//проверяем правильность пароля		
			$content = $cntnt; //если пароль верный, выводим форму
		}
		else{ //иначе пишем об ошибке
			$content = "
				<br><br><br><br>
				<h1 align=\"center\">
					Ошибка! Введите верный пароль или перейдите на другую страницу!
				</h1>
			";
		}
		include('shablon.php');
		fclose($file_pswd); //закрываем файл с паролем
	}
	//если добавлена книга
	if (isset($_POST["add"]) AND $_POST["add"]){
		$title = "Страница администратора"; //задаем название страницы
		//проверка, были ли введены нужные данные
		if ($_POST["atr"] != "" && $_POST["bk"] != "" && $_POST["gnr"] != ""){
			$autor = htmlentities($_POST["atr"]); //преобразуем введенные данные для защиты от взлома
			$name = htmlentities($_POST["bk"]); //преобразуем введенные данные для защиты от взлома
			$g = htmlentities($_POST["gnr"]); //преобразуем введенные данные для защиты от взлома
			$f_bks = fopen ("books.txt", "a"); //открываем файл со списком книг для добавления новой книги
			$data = file("books.txt"); //считываем все данные из файла построчно
			$i = count($data); //считаем количество строк
			preg_match_all("/^\d+/", $data[$i-1], $num); //находим номер последней книги
			$n = $num[0][0] + 1; //увеличиваем найденный номер на 1
			$book = "\r\n".$n.". ".$g." \"".$name."\" ".$autor; //инициализируем информацию о добавленной книге
			fwrite($f_bks, $book); //записываем информацию в файл
			//сохраняем фотографию обложки книги
			copy($_FILES["img"]["tmp_name"],
				"D:/USR/www/Biblio/images/books/$n.jpg");
			//и выводим сообщение об успешном добавлении
			$content = "
				<h2>
					Книга успешно добавлена.
				</h2>
			";
			//и повторно форму добавления и кнопку перехода на страницу удаления книг
			$content .= $cntnt;
		}
		else { //иначе выводим сообщение об ошибке
			$content = "
				<h2>
					Ошибка! Книга не была добавлена!
				</h2>
			";
			//и повторно форму добавления и кнопку перехода на страницу удаления книг
			$content .= $cntnt;
		}
		include('shablon.php');
		fclose($f_bks); //закрываем файл книг
	}
?>