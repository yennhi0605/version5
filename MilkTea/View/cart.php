<?php
  require "../Database/database.php";
  require '../Model/Coffee.php';
  require "../Model/Juice_Tea.php";
  require "../Model/Milktea.php";
  require "../Model/Smoothie.php";

  session_start();

  $sql1 = "SELECT * from milktea";
  $result1 = $db->query($sql1)->fetch_all();

  $sql = "SELECT * from cart";
  $result = $db->query($sql)->fetch_all(MYSQLI_ASSOC);

  if (isset($_GET["cart"])) {
    $id = $_GET['cart'];
    $sql = "SELECT * FROM cart WHERE id =" . $id . ";";
    $result = $db->query($sql)->fetch_all();
    echo $id;
  }

  // $id = $_GET['id'];

  $carts = array();
  for ($i = 0; $i < count($result); $i++) {
    $cart = $result[$i];


    if ($cart['name'] == 'Coffee') {
      array_push($carts, new Coffee($cart['id'], $cart['name'], $cart['price'], $cart['quantity'], $cart['image']));
    }
    if ($cart['type'] == 'Juice_Tea') {
      array_push($carts, new Juice_Tea($cart['id'], $cart['name'], $cart['price'], $cart['quantity'], $cart['image']));
    }
    if ($cart['type'] == 'Milktea') {
      array_push($carts, new Milktea($cart['id'], $cart['name'], $cart['price'], $cart['quantity'], $cart['image']));
    }
    if ($cart['type'] == 'Smoothie') {
      array_push($carts, new Smoothie($cart['id'], $cart['name'], $cart['price'], $cart['quantity'], $cart['image']));
    }
  }


    function sum($result){
        $sum=0;
        for($i = 0; $i < count($result); $i++) {
            $sum += (($result[$i]['price'])*($result[$i]['quantity']));
        }
        return $sum;
    }



  $_SESSION['cart'] = json_encode($cart);


  if(isset($_POST["dele"])){
      echo "hahaha";
      $id = $_POST["dele"];
      echo $id;
      $sql = "DELETE from `milktea` where id= ".$id;
      $db->query($sql);
      }
?>
<!DOCTYPE html>
<html>

<head>
  <title></title>
  <link rel="stylesheet" type="text/css" href="../Css/cart.css">
</head>

<body>
  <h1>MY SHOPING CART</h1>
  <table style="margin-top: 50px;width: 97%;margin-left: 15px;" id="tbl" class="table table-striped">
    <tr>
      <th>ID</th>
      <th>Image</th>
      <th>Name</th>
      <th>Type</th>
      <th>Price</th>
      <th>Quantity</th>
      <th>Total</th>
      <th>Delete</th>
    </tr>

    <?php
    $cart = json_decode($_SESSION['cart'],true);
    $cart = array();

    for ($i = 0; $i < count($cart); $i++) {
    ?>
      <tr>
        <form action="" method="POST">
          <th><?php echo $i + 1 ?></th>
          <td>
            <img src=<?php "../Image/".$cart[$i]['image'] ?>>
          </td>
          <td>
            <p><?php echo $cart[$i]['name'] ?></p>
          </td>
          <td>
            <p><?php echo $cart[$i]['price'] ?></p>
          </td>
          <td>
            <p><?php echo $cart[$i]["quantity"] ?></p>
          </td>
          <td>
            <p><?php echo (($cart[$i]['price']) * ($cart[$i]['quantity'])) ?></p>
          </td>
          <td>
            <button name="dele" value="?id=<?php echo $new[$i]->id ?>"> Delete</button>
          </td>
        </form>
      </tr>
    <?php
    }
    ?>

    <!-- <div class="milk-container">
    <?php
    for ($i = 0; $i < count($milkteas); $i++) {
    ?>
    <div class="item-milk">
      <img class="item-milk-icon" src=<?php echo $milkteas[$i]->getImagePath(); ?>>
      <h1 class="item-milk-name"><?php echo $milkteas[$i]->name ?></h1>
      <p style="color: brown" class="item-milk-type"><?php echo $milkteas[$i]->getType() ?></p>
      <h2 class="item-milk-price"><?php echo $milkteas[$i]->getDisplayPrice() ?></h2>

      <form action="detail.php" method="get" class="btn">
        <button name="detail" style="background-color: sandybrown" value=<?php echo $milkteas[$i]->id; ?>>Detail</button>
      </form>
      <form action="" method="post" class="btn">
       <button name="order" style="background-color:red" value=<?php echo $milkteas[$i]->id; ?> >Order</button>
      </form>
    </div>

     <?php
    }
      ?>
      </div> -->

  </table>
  <!-- </div>
    <div class="pay">
    <h1>CỘNG GIỎ HÀNG</h1>
    <p>Tạm tính: <?php echo sum($new); ?></p>
    <p>Phí giao hàng: <?php echo (sum($new) * 0.01); ?></p>
    <p>Tổng: <?php echo (sum($new) + (sum($new) * 0.01)); ?></p>
    <form action = "" method="post">
    <button style="text-align: center;" name="order">Thanh toán</button>
    </form>
    </div> -->

  <!-- <a style="text-decoration: none"href="index.php">Home</a>
    <a style="text-decoration: none"href="indexUser.php">UserHome</a> -->
</body>

</html>