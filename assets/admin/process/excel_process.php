<?php
# DATABASE
include "../../database/database.php";

# SESSION
include "../inc/session.php";

# CLASS
include "../class/product.php";
$product = new Product($conn);
$rs = $product -> getOrders();
header("Content-Type: applications/vnd.ms-excel");
header("Content-Disposition: attachment; filename=order.xls");
header("Content-Description:PHP8 Generated Data");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th scope="col">순번</th>
                <th scope="col">주문 번호</th>
                <th scope="col">주문자</th>
                <th scope="col">휴대폰번호</th>
                <th scope="col">상품명</th>
                <th scope="col">개당 가격</th>
                <th scope="col">구매 상품 수</th>
                <th scope="col">총 가격</th>
                <th scope="col">주소</th>
                <th scope="col">우편번호</th>
                <th scope="col">결제일</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rs as $r) { ?>
            <tr>
                <td><?= $r["idx"] ?></td>
                <td><?= $r["order_uid"] ?></td>
                <td><?= $r["m_name"] ?></td>
                <td><?= $r["m_phone"] ?></td>
                <td><?= $r["p_name"] ?></td>
                <td><?= $r["p_one_price"] ?></td>
                <td><?= $r["p_cnt"] ?></td>
                <td><?= $r["p_total_price"] ?></td>
                <td><?= $r["m_addr"] ?></td>
                <td><?= $r["m_zipcode"] ?></td>
                <td><?= $r["create_at"] ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>