<?php
    include_once 'conexao.php';
    

    if(isset($_SESSION['msg'])){
        echo $_SESSION['msg'];
        unset($_SESSION['msg']);
    }    


    try{

    $dadoscad = filter_input_array(INPUT_POST, FILTER_DEFAULT);

   var_dump($dadoscad);


    if(isset($_FILES['foto'])){
        $arquivo = ($_FILES['foto']);
        

        if($arquivo['error']){
            echo 'Erro ao carregar arquivo';
            header ("Location: frmproduto.php");
        }

        $pasta = "img/";
        $nomearquivo = $arquivo['name'];
        $novonome = uniqid();
        $extensao = strtolower(pathinfo($nomearquivo, PATHINFO_EXTENSION));

        if($extensao!="jpg" && $extensao!="png"){
            die("Tipo não aceito");
        }
        else{
            $salvaimg = move_uploaded_file($arquivo['tmp_name'], $pasta . $novonome . "." . $extensao);

             if($salvaimg){
                 $path = $pasta . $novonome . "." . $extensao;
                 echo "ok";
             }

        }


    }
    if (!empty($dadoscad['btncad'])) {

        $vazio = false;

        $dadoscad = array_map('trim', $dadoscad);
        if (in_array("", $dadoscad)) {
            $vazio = true;
           
            echo "<script>
        alert('Preencher todos os campos!!!');
        parent.location = 'frmproduto.php';
        </script>";

        }
   
}

if (!$vazio) {

    

    $sql = "insert into roupa(id_produtos,produto_nome,quantidade,tamanho,cor,custo,valor,fornecedor_id_fornecedor,foto)
    values(:id_produto,:produto_nome,:quantidade,:tamanho,:cor,:custo,:valor,:fornecedor_id_fonecedor,:foto)";

    $salvar= $conn->prepare($sql);
    $salvar->bindParam(':id_produto', $dadoscad['id_produto'], PDO::PARAM_STR);
    $salvar->bindParam(':produto_nome', $dadoscad['produto_nome'], PDO::PARAM_STR);
    $salvar->bindParam(':quantidade', $dadoscad['quantidade'], PDO::PARAM_STR);
    $salvar->bindParam(':tamanho', $dadoscad['tamanho'], PDO::PARAM_STR);
    $salvar->bindParam(':cor', $dadoscad['cor'], PDO::PARAM_STR);
    $salvar->bindParam(':custo',$dadoscad['custo'], PDO::PARAM_STR);
    $salvar->bindParam(':valor',$dadoscad['valor'] , PDO::PARAM_STR);
    $salvar->bindParam(':fornecedor_id_fornecedor',$dadoscad['fornecedor_id_fornecedor'], PDO::PARAM_STR);
    $salvar->bindParam(':foto',$path , PDO::PARAM_STR);
    $salvar->execute();
    if ($salvar->rowCount()) {
        
        echo "<script>
        alert('Usuário cadastrado com sucesso!!');
        parent.location = 'frmproduto.php';
        </script>";

        unset($dadoscad);
    } else {
        echo "<script>
        alert('Usuário não cadastrado!');
        parent.location = 'frmproduto.php';
        </script>";
        
    }

}
}


catch(PDOException $erro){
    echo $erro;

}

?>
