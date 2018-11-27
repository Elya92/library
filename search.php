<?php
	$title = "Результаты поиска"; //задаем заголовок страницы
	if (isset($_GET['search'])){ //проверка, введен ли поисковый запрос, если пользователь попал на страницу поиска случайно
		$text = htmlentities($_GET['search']); //поисковый запрос, модифицированный, чтобы не взломали сайт через строку поиска
		if ($text == "нажмите 'поиск' для поиска всех книг"){ //если пользователь хочет найти все книги
			$text = "";
		}
		$content = "
			<div id=\"content\">
				<h1 align=\"center\">Результаты поиска</h1>
				<h2 align=\"center\">по запросу: $text</h2>
		";
		$file_books = fopen("books.txt", "r"); //открываем файл со списком книг для чтения
		$data = file("books.txt"); //считываем построчно файл в $data
		$x = 0; //для вывода по 4 книги в строке
		$j = 0; //переменная для массива найденных соответствий и одновременно флаг, нашли ли мы соответствие поисковому запросу
		//работаем с данными из файла книг
		foreach ($data as $v){ //построчно выполняем:
			//находим автора
			preg_match_all("/(\s\b\w+\b(\s)*(\w{1,2}\.)*\,)*\s\b\w+\b\s(\w{1,2}\.)*(\r\n)*$/", $v, $autor);
			//находим название книги
			preg_match_all("/\"(.*)\"/", $v, $book);
			//находим жанр
			preg_match_all("/\s\d\s/", $v, $genre);
			//находим номер книги
			preg_match_all("/^\d+/", $v, $number);
			$a = $autor[0][0];
			$b = $book[0][0];
			$n = $number[0][0];
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
			//если поисковый запрос соответствует данной книге...
			if (preg_match("/$text/i", $a) or preg_match("/$text/i", $b) or ($text == $g)){
				//...то заносим данные о книге в массив
				$sortb[$j][0] = $a;
				$sortb[$j][1] = $b;
				$sortb[$j][2] = $g;
				$sortb[$j][3] = $n;
				$j = $j + 1;
			}
		}
		if ($j == 0){
			//если мы ничего не нашли подходящего
			$content .= "
					<h3 align=\"center\">
						По вашему запросу \"$text\" ничего не найдено...
					</h3>
			";
		}
		else{
			//иначе сортируем массив найденных соответствующих поисковому запросу книг
			array_multisort($sortb);
			for ($h = 0; $h < $j; $h++){
				if ($x == 4){ //и выводим по 4 книги в строке
					$x = 0;
				}
				$x = $x + 1;	
				$a = $sortb[$h][0];
				$b = $sortb[$h][1];
				$g = $sortb[$h][2];
				$n = $sortb[$h][3];	
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
		}
		$content .= "</div>";
		include('shablon.php');
		fclose($file_books); //закрываем файл книг
	}	
?>