<?php
 
 $get_products = $pdo->prepare("SELECT * FROM products ORDER BY date_added LIMIT 4 ");
 $get_products->execute();
 $final_data = $get_products->fetchAll(PDO::FETCH_ASSOC);
 // print_r($final_data);die;

?>

<?php template_header('Home')?>

<div class="featured">
    <h2>Gadgets</h2>
    <p>Essential gadgets for everyday use</p>
</div>
<div class="recentlyadded content-wrapper">
    <h2>Recently Added Products</h2>
    <div class="products">
    	<?php
    	foreach ($final_data as $key => $value) { ?>
    		<a class="product" href="index.php?page=product&id=<?php echo $value['id']; ?>">
    			<img src="images/<?php echo $value['img'] ?>" alt="<?php  echo $value['name']; ?>" width="200" height="200" >
    			<span class="name" > <?php echo $value['name']; ?> </span>
    			<span class="price" > <?php echo '$'.$value['price']; ?> </span>
    		</a>
    		
    	<?php }
    	?>
    </div>
</div>

<?php template_footer() ?>