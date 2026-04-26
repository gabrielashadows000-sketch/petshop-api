<?php
    $cn = new PDO("mysql:host=localhost;dbname=db_petshop","root","");
    $sql = "SELECT * FROM productos";
    $rs = $cn->prepare($sql);
    $rs->execute();

    $rows = $rs->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($rows);




?>