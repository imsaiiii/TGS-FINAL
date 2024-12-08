<?php

$product_list = array();
while ($row = mysqli_fetch_assoc($result)) {
    $product_list[] = array(
        'image' => $row['image'],
        'name' => $row['name'],
        'price' => $row['price']
    );
}


$html = '';
foreach ($product_list as $product) {
    $html .= '<div class="card">';
    $html .= '<div class="image"><img src="Images/' . $product['image'] . '" alt=""></div>';
    $html .= '<span class="name-order">' . $product['name'] . '</span>';
    $html .= '<span class="price-order">' . $product['price'] . '</span>';
    $html .= '<div class="button"><button type="button" class="Add">Order</button></div>';
    $html .= '</div>';
}

echo $html;
?>