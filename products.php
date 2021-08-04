<?php
// The amounts of products to show on each page
$num_products_on_each_page = 4;
// The current page, in the URL this will appear as index.php?page=products&p=1, index.php?page=products&p=2, etc...
$current_page = isset($_GET['p']) && is_numeric($_GET['p']) ? (int)$_GET['p'] : 1;
// Select products ordered by the date added
$stmt = $pdo->prepare("SELECT * FROM products ORDER BY date_added LIMIT 4 ");
// bindValue will allow us to use integer in the SQL statement, we need to use for LIMIT
$stmt->bindValue(1, ($current_page - 1) * $num_products_on_each_page, PDO::PARAM_INT);
$stmt->bindValue(2, $num_products_on_each_page, PDO::PARAM_INT);
$stmt->execute();
// Fetch the products from the database and return the result as an Array
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
// Get the total number of products
$total_products = $pdo->query('SELECT * FROM products')->rowCount();
?>


<?=template_header('Products')?>

<div class="products content-wrapper">
    <h1>Products</h1>
    <p><?=$total_products?> Products</p>
    <div class="products-wrapper">
        <?php
    	foreach ($products as $key => $value) { ?>
    		<a class="product" href="index.php?page=product&id=<?php echo $value['id']; ?>">
    			<img src="images/<?php echo $value['img'] ?>" alt="<?php  echo $value['name']; ?>" width="200" height="200" >
    			<span class="name" > <?php echo $value['name']; ?> </span>
    			<span class="price" > <?php echo '$'.$value['price']; ?> </span>
    		</a>
    		
    	<?php }
    	?>
    </div>
     
</div>

<?=template_footer()?>