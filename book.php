<?php
	if (isset($_GET["id"])){ //если мы передали номер книги, а не просто случайно нашли страницу
		$i = htmlentities($_GET["id"]); //нужна ли эта проверка?
		$file_comments = fopen("comments.txt", "a"); //открываем файл комментариев для чтения и записи
		//если нажата кнопка добавления комментария
		/*if ($_POST["public"]){ //сделать, чтобы не выводилась ошибка, если кнопка не нажата, а мы просто перешли на страницу книги
			if ($_POST["nm"] != "" && $_POST["review"] != ""){ //если пользователь ввел имя и комментарий
				$autor = htmlentities($_POST["nm"]); //модифицируем для защиты от взлома
				$comment = htmlentities($_POST["review"]); //модифицируем для защиты от взлома
				$cmnt = "\r\n".$i.".\r\n".$autor."\r\n".$comment; //инициализируем введенные данные
				fwrite ($file_comments, $cmnt); //и записываем их в файл комментариев
			}
		}*/
		$file_books = fopen("books.txt", "r"); //открываем файл книг для чтения
		$datab = file("books.txt"); //считываем построчно из него данные
		$f = 0; //флаг, показывающий, нашли ли мы книгу с таким id
		//построчно ищем нужную книгу
		foreach ($datab as $v){
			if (preg_match("/^$i/",$v)){ //если номер книги совпадает с нужным, то
				$f = 1; //устанавливаем флаг, что мы нашли книгу
				//находим в строке автора
				preg_match_all("/(\s\b\w+\b\s(\w{1,2}\.)*\,)*\s\b\w+\b\s(\w{1,2}\.)*(\r\n)*$/", $v, $autor);
				//находим в строке название книги
				preg_match_all("/\"(.*)\"/", $v, $book);
				//находим в строке жанр
				preg_match_all("/\s\d\s/", $v, $genre);
				$a = $autor[0][0];
				$b = $book[0][0];
				$title = $a." ".$b; //задаем заголовок старницы как название книги и автора
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
				//выводим на странице полученные данные
				$content = "
					<div id=\"booki\">
						<br><br>
						<b>Автор:</b>
						<br>
						$a
						<br><br>
						<b>Название книги:</b>
						<br>
						$b
						<br><br>
						<b>Жанр:</b>
						<br>
						$g
					</div>
					<div id=\"bookf\">
						<image src=\"images/books/$i.jpg\" height=\"500\">
					</div>
					<div id=\"comment\">
						<form method=\"post\" action=\"book.php?id=$i\">
							Ваше имя: 
							<input type=\"text\" name=\"nm\" size=\"20\"
									maxlength=\"30\">
							<br>
							<br>
							Ваш отзыв:
							<br>
							<textarea name=\"review\" cols=\"100\"
									rows=\"10\" wrap=\"hard\"></textarea>
							<br><br>
							<input type=\"submit\" name=\"public\"
									value=\"Отправить\">
						</form>
					</div>
				";
				//вывод комментариев
				$datac = file("comments.txt"); //считываем файл комментариев построчно
				$k = count($datac); //считаем количество строк в файле
				$s = 0; //переменная для перехода по строкам
				while ($s < $k){ //пока не конец файла
					if (preg_match("/^$i\.\r\n$/", $datac[$s])){ //если строка - это номер книги
						$s = $s + 1;
						$user = $datac[$s]; //считываем следующую строку с именем комментатора
						$t = true;
						$commt = "";
						$s = $s + 1;
						//построчно считываем весь комментарий этого пользователя
						while ($t && $s < $k){
							if (preg_match("/^\d+\.\r\n$/", $datac[$s])){ //если строка содержит номер книги, то комментарий закончился и выходим из цикла
								$t = false;
								$s = $s - 1;
							}
							else { //иначе записываем в переменную комментарий
								$commt .= $datac[$s]."<br>";
								$s = $s + 1;
							}
						}
						//выводим комментарий
						$content .= "
							<div id=\"cc\">
								<strong>
									$user
								</strong>
								<br><br>
								$commt
							</div>
						";
					}
					$s = $s + 1;
				}
			}
		}
		if ($f == 0){ //если книга по id не найдена, то выводим сообщение
			$title = "Ошибка!";
			$content = "
				<h1>
					Книга не найдена!
				</h1>
			";
		}
		include('shablon.php');
		fclose($file_books); //закрываем файл книг
		fclose($file_comments); //закрываем файл комментариев
	}
?>