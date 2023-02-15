<?php

require_once 'conexao.php';

session_start();
ob_start();

$_SESSION["quant"]+=1;

echo $_SESSION["quant"];

$cesta = filter_input_array(INPUT_POST, FILTER_DEFAULT);
//var_dump($cesta);

$codigoproduto = $cesta["codigoproduto"];
$quantcompra = $cesta["quantcompra"];

$sql = "SELECT roupa.ID_PRODUTO,roupa.PRODUTO_NOME,roupa.VALOR,roupa.QUANTIDADE,roupa.FOTO 
FROM roupa,categotia
WHERE CODIGOPRODUTO = $CODIGOPRODUTO LIMIT 1";

$resultado= $conn->prepare($sql);
$resultado->execute();

if(($resultado)and($resultado->RowCount()!=0)){
    $linha=$resultado->fetch(PDO::FETCH_ASSOC);
    extract($linha);
    
    if($quantidade<$quantcompra){        
        header("Location:index.php");
    }
    else{
        $sql2 = "INSERT into carrinho(CODIGOPRDUTO,NOME,VALOR,QUANTCOMPRA,FOTO)
        values(:CODIGOPRODUTO,:NOME,:QUANTCOMPRA,:VALOR,:FOTO)";
        $salvar2= $conn->prepare($sql2);
        $salvar2->bindParam(':CODIGOPRDUTO', $CODIGOPRDUTO, PDO::PARAM_INT);
        $salvar2->bindParam(':NOME', $NOME, PDO::PARAM_STR);
        $salvar2->bindParam(':VALOR', $VALOR, PDO::PARAM_STR);
        $salvar2->bindParam(':QUANTCOMPRA', $QUANTCOMPRA, PDO::PARAM_INT);
        $salvar2->bindParam(':FOTO', $FOTO, PDO::PARAM_STR);
        $salvar2->execute();


    }





}



?>