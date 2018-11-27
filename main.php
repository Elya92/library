<?php
	$title = "Национальная Библиотека РБ"; //задаем заголовок главной страницы
	$file_books = fopen("books.txt", "r"); //открываем файл со списком книг для чтения
	$data = file("books.txt"); //читаем файл в переменную $data
	$i = count($data); //считаем количество строк в файле books.txt
	$x = 0; //для того, чтобы в ряд выводилось по 4 книги
	$content = "
		<div id=\"content\">
			<div id=\"textc\">
				<h1 align=\"center\">Новинки</h1>
			</div>
	";
	//выводим в цикле последние 4 добавленные книги
	for ($j = ($i - 4); $j < $i; $j++){ //в цикле построчно выполняем:
		$x = $x + 1;
		//ищем в строке автора
		preg_match_all("/(\s\b\w+\b\s(\w{1,2}\.)*\,)*\s\b\w+\b\s(\w{1,2}\.)*(\r\n)*$/", $data[$j], $autor);
		//ищем в строке название книги
		preg_match_all("/\"(.*)\"/", $data[$j], $book);
		//ищем в строке жанр
		preg_match_all("/\s\d\s/", $data[$j], $genre);
		//ищем в строке номер книги
		preg_match_all("/^\d+/", $data[$j], $number);
		$a = $autor[0][0];
		$b = $book[0][0];
		switch ($genre[0][0]){
			case " 1 ":
				$g = "Classics";
				break;
			case " 2 ":
				$g = "Detective";
				break;
			case " 3 ":
				$g = "Poetry";
				break;
		}
		$n = $number[0][0];
		//добавляем полученные данные для вывода на страницу
		$content .= "
			<div id=\"b$x\">
				<a href=\"book.php?id=$n\">
					<img src=\"images/books/$n.jpg\" height=\"300\">
				</a>
				<br clear=\"all\">
				<a href=\"book.php?id=$n\">
					$a
					<br>
					$b
				</a>
				<br>
				$g
			</div>
		";
	}
	$content .= "</div>";
	include("shablon.php");
	fclose($file_books); //закрываем открытый файл
?>