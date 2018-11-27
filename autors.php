<?php
	$title = "Список авторов"; //задаем название страницы
	$file_book = fopen("books.txt", "r"); //открываем файл со списком книг для чтения
	$data = file("books.txt"); //построчно считываем его в переменную $data
	$content = "
		<h1 align=\"center\">
			Список всех авторов:
		</h1>
		<br><br><br><br>
	";
	$x = 0; //переменная для записи в массив (можно обойтись без нее!!!)
	//в цикле считываем всех авторов из файла
	foreach ($data as $v){
		//находим в строке соответствие на автора или авторов
		preg_match_all("/(\s\b\w+\b(\s)*(\w{1,2}\.)*\,)*\s\b\w+\b\s(\w{1,2}\.)*(\r\n)*$/", $v, $autor);
		foreach ($autor[0] as $val){ //именно 0! позволяет считать все значения массива $autor
			//разбиваем массив найденных авторов по одному автору
			preg_match_all("/\s\b\w+\b(\s)*(\w{1,2}\.)*/", $val, $autors);
			foreach ($autors[0] as $value){
				$a[$x] = $value;
				$x = $x + 1;
			}
		}
	}
	$auts = array_unique($a); //убираем повторяющиеся значения
	asort($auts); //сортируем массив авторов по алфавиту
	//в цикле выводим всех авторов
	foreach ($auts as $v){
		$content .= "
			<div id=\"autor\">
				<a href=\"search.php?search=$v\">
					<h3>$v</h3>
				</a>
				<br>
			</div>
		";
	}
	include('shablon.php');
	fclose($file_book); //закрываем файл книг
?>