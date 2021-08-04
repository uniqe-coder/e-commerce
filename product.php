<?php
 
 if (isset($_GET['id'])) {

 // $current_page = isset($_GET['p']) && is_numeric($_GET['p']) ? (int)$_GET['p'] : 1;
// Select products ordered by the date added
$stmt = $pdo->prepare("SELECT * FROM products WHERE id=".$_GET['id']." ");
$stmt->execute([$_GET['id']]);
// Fetch the products from the database and return the result as an Array
$product = $stmt->fetch(PDO::FETCH_ASSOC);
// Get the total number of products
}

?>


<?=template_header('Products')?>

<div class="product content-wrapper">

                <img src="images/<?php echo $product['img'] ?>" alt="<?php  echo $product['name']; ?>" width="200" height="200" >
                <div class="product-wrapper">
                <h1 class="name" > <?php echo $product['name']; ?> </h1>
                <span class="price" > <?php echo '$'.$product['price']; ?> </span>  
            <form id="product-form" class="product" action="index.php?page=cart" method="POST">

                <input type="hidden" name="quantity" value="1" min="1" max="<?=$product['quantity']?>" >
                <input type="hidden" name="product_id" value="<?php echo $product['id'] ?>" >
                <input type="submit" name="add_to_cart" value="Add to Cart" >
            </form>
            <div class="description">
            <?=$product['desc']?>
        </div>
            
         
    </div>
    </div>

<?=template_footer()?>