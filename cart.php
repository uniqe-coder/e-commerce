 
<?php
// If the user clicked the add to cart button on the product page we can check for the form data
if (isset($_POST['product_id'], $_POST['quantity']) && is_numeric($_POST['product_id']) && is_numeric($_POST['quantity'])) {
    // Set the post variables so we easily identify them, also make sure they are integer
    $product_id = (int)$_POST['product_id'];
    $quantity = (int)$_POST['quantity'];
    // Prepare the SQL statement, we basically are checking if the product exists in our databaser
    $stmt = $pdo->prepare('SELECT * FROM products WHERE id = ?');
    $stmt->execute([$_POST['product_id']]);
    // Fetch the product from the database and return the result as an Array
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    // Check if the product exists (array is not empty)
    if ($product && $quantity > 0) {
        // Product exists in database, now we can create/update the session variable for the cart
        if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
            if (array_key_exists($product_id, $_SESSION['cart'])) {
                // Product exists in cart so just update the quanity
                $_SESSION['cart'][$product_id] += $quantity;
            } else {
                // Product is not in cart so add it
                $_SESSION['cart'][$product_id] = $quantity;
            }
        } else {
            // There are no products in cart, this will add the first product to cart
            $_SESSION['cart'] = array($product_id => $quantity);
        }
    }
    // Prevent form resubmission...
    header('location: index.php?page=cart');
    exit;
}

$products_added_to_cart = isset($_SESSION['cart'])? $_SESSION['cart'] : array();
$products = array();
$subtotal = 0.0;
if ($products_added_to_cart) {

     $count_products_incart = implode(',', array_fill(0, count($products_added_to_cart), '?'));
$stmt = $pdo->prepare(" SELECT * FROM products WHERE id in (".$count_products_incart.") ");
    $stmt->execute(array_keys($products_added_to_cart));
     $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

foreach( $products as $product ){
	$subtotal += (float)$product['price']  * (int)$products_added_to_cart[$product['id']];
}

if ( isset( $_POST['update']) && isset($_SESSION['cart']) )  {
 foreach ($_POST as $key => $val) {
        if (strpos($key, 'quantity') !== false && is_numeric($val)) {
            $id = str_replace('quantity-', '', $key);
            $quantity = (int)$val;
            //Validation
            if (isset($_SESSION['cart'] ) && $quantity > 0) {
                // Update new quantity
                $_SESSION['cart'][$id] = $quantity;
            }
        }
    }
    header('location: index.php?page=cart');
    exit;
}
 

if (isset($_GET['remove']) && isset($_SESSION['cart']) ) {
    unset($_SESSION['cart'][$_GET['remove']]);
    header('location: index.php?page=cart');
    exit;
}



 ?>

<?=template_header('Cart')?>

<div class="cart content-wrapper">
    <h1>Shopping Cart</h1>
    <form action="index.php?page=cart" method="post">
        <table>
            <thead>
                <tr>
                    <td colspan="2">Product</td>
                    <td>Price</td>
                    <td>Quantity</td>
                    <td>Total</td>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($products)): ?>
                <tr>
                    <td colspan="5" style="text-align:center;">You have no products added in your Shopping Cart</td>
                </tr>
                <?php else: ?>
                <?php foreach ($products as $product): ?>
                <tr>
                    <td class="img">
                        <a href="index.php?page=product&id=<?=$product['id']?>">
                            <img src="images/<?=$product['img']?>" width="50" height="50" alt="<?=$product['name']?>">
                        </a>
                    </td>
                    <td>
                        <a href="index.php?page=product&id=<?=$product['id']?>"><?=$product['name']?></a>
                        <br>
                        <a href="index.php?page=cart&remove=<?=$product['id']?>" class="remove" name="remove">Remove</a>
                    </td>
                    <td class="price">&dollar;<?=$product['price']?></td>
                    <td class="quantity">
                        <input type="number" name="quantity-<?=$product['id']?>" value="<?=$products_added_to_cart[$product['id']]?>" min="1" max="<?=$product['quantity']?>" placeholder="Quantity" required>
                    </td>
                    <td class="price">&dollar;<?=$product['price'] * $products_added_to_cart[$product['id']]?></td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        <div class="subtotal">
            <span class="text">Subtotal</span>
            <span class="price">&dollar;<?=$subtotal?></span>
        </div>
        <div class="buttons">
            <input type="submit" value="Update" name="update">
            <input type="submit" value="Place Order" name="placeorder">
        </div>
    </form>
</div>

<?=template_footer()?>