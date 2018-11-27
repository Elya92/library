<html>
	<head>
		<title>
			<?php
				echo $title; //выводим полученное название страницы
			?>
		</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	
	<body>
		<div id="main">
			<!--шапка сайта-->
			<div id="menu">
				<!--фотография библиотеки-->
				<div id="foto">
					<a href="main.php">
						<img src="images/foto.jpg">
					</a>
				</div>
				<!--название и время работы библиотеки-->
				<div id="text">
					<a href="main.php" id="anb">
						Национальная библиотека<br>
						Республики Беларусь
					</a>
					<br><br>
					<b>Наш адрес:</b>
					<br>
					пр-т Независимости, 116
					<br>
					Минск, 220114
					<br><br>
					<b>Наш телефон:</b>
					<br>
					+375(17)266-37-37
					<br><br>
					<b>Время работы:</b>
					<br>
					пн-пт 10-21
					<br>
					сб-вс 10-18
				</div>
				<!--фотография книг-->
				<div id="books">
					<a href="main.php">
						<img src="images/books.jpg">
					</a>
				</div>
				<!--строка поиска-->
				<div id="search">
					<form method="get" action="search.php">
						<input type="text" name="search" size="30" value="нажмите 'поиск' для поиска всех книг">
						<input type="submit" name="oks" value="Поиск">
					</form>
				</div>
				<!--форма входа на страницу управления сайтом-->
				<div id="admin">
					<form method="post" action="admin.php">
					<input type="password" name="pswd" size="10">
					<input type="submit" name="oka" value="Вход">
					</form>
				</div>
				<!--ссылка на страницу списка авторов-->
				<div id="autors">
					<a id="aa" href="autors.php">
						Список всех авторов
					</a>
				</div>
				<!--контент-->
				<div id="content">
					<?php
						echo $content;
					?>
				</div>
			</div>
			<!--низ сайта-->
			<div id="footer">
				Минск, 
				<?php
					echo date("Y"); //выводим текущий год
				?>
				<br>
				Разработка сайта: Метлицкая Елена
			</div>
		</div>
	</body>
</html>