<?php
function pdo_connect_mysql() {

   $db_host = 'localhost';
   $db_name = 'e-commerce';
   $db_user = 'root';
   $db_pwd = '';

   try{
   	return new PDO('mysql:host=' .$db_host. '; dbname='.$db_name.';',$db_user,$db_pwd  );
   }
   catch(PDOException $exception){
   	return "No DB Found" ;
   }
}
// Template header, feel free to customize this
function template_header($title) {
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>E-commerce</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">

</head>
<body>
	        <header>
            <div class="content-wrapper">
                <h1>E-commerce</h1>
                <nav>
                    <a href="index.php">Home</a>
                    <a href="index.php?page=products">Products</a>
                </nav>
                <div class="link-icons">
                    <a href="index.php?page=cart">
						<i class="fas fa-shopping-cart"></i>
					</a>
                </div>
            </div>
        </header>
        <main>
        <?php }  

        function template_footer() {
		$year = date('Y'); ?>
        </main>
        <footer>
            <div class="content-wrapper">
                <p>Contact Us</p>
                <p>About Us</p>
            </div>
        </footer>
        <script src="script.js"></script>
</body>
</html>	
<?php } ?>