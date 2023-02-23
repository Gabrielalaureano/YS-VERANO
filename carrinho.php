<?php

require_once 'conexao.php';

session_start();
ob_start();

$_SESSION["quant"]+=1;

echo $_SESSION["quant"];

$cesta = filter_input_array(INPUT_POST, FILTER_DEFAULT);
//var_dump($cesta);

$ID_PRODUTO = $cesta["ID_PRODUTO"];
$QUANTCOMPRA = $cesta["QUANTCOMPRA"];

$sql = "SELECT ID_PRODUTO,PRODUTO_NOME,QUANTIDADE,TAMANHO, VALOR,FOTO,
FROM roupa
WHERE ID_PRODUTO = $ID_PRODUTO LIMIT 1";

$resultado= $conn->prepare($sql);
$resultado->execute();

if(($resultado)and($resultado->RowCount()!=0)){
    $linha=$resultado->fetch(PDO::FETCH_ASSOC);
    extract($linha);
    
    if($QUANTIDADE <$QUANTCOMPRA){        
        header("Location:index.php");
    }
    else{
        $sql2 = "INSERT into carrinho(CODIGOPRODUTO,NOME,VALOR,QUANTCOMPRA,FOTO)
        values(:CODIGOPRODUTO,:NOME,:VALOR,:QUANTCOMPRA,:FOTO)";
        $salvar2= $conn->prepare($sql2);
        $salvar2->bindParam(':CODIGOPRODUTO', $CODIGOPRODUTO, PDO::PARAM_INT);
        $salvar2->bindParam(':NOME', $NOME, PDO::PARAM_STR);
        $salvar2->bindParam(':VALOR', $VALOR, PDO::PARAM_STR);
        $salvar2->bindParam(':QUANTCOMPRA', $QUANTCOMPRA, PDO::PARAM_INT);
        $salvar2->bindParam(':FOTO', $FOTO, PDO::PARAM_STR);
        $salvar2->execute();


    }


    $pag = $_SERVER['HTTP_REFERER'] ;
    header("Location:$pag");




}







?>
