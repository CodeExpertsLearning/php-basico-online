<?php
   if($_SERVER['REQUEST_METHOD'] == 'POST'
      && isset($_POST['send'])) {
       print_r($_POST);
   }
?>   
<html>
<head>
	<title>Manipulando formulário</title>
</head>
<body>
	<h1>Formulário</h1>
	<hr>
	<form action="" method="post">
		<p>
		<strong>Nome</strong> <br>
			<input type="text" name="name">
		</p>

		<p>
		<strong>Email</strong> <br>
			<input type="text" name="email">
		</p>
		<input type="submit" name="send" value="Enviar">
	</form>
</body>
</html>