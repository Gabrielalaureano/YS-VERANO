<?php
    session_start();
    ob_start();

    require_once 'conexao.php';

   
    if(isset($_POST["excluir"])){

        $codigoproduto = $_POST["excluir"]; 

        $sqlexcluir = "DELETE from carrinho where CODIGOPRODUTO = $CODIGOPRODUTO";
        $resulexcluir=$conn->prepare($sqlexcluir);
        $resulexcluir->execute();
        $_SESSION["quant"]-=1;
    }else{
        if(!isset($_SESSION['nome'])){
            $_SESSION["carrinho"] = true;
            echo "<script>
            alert('Faça Login para Finalizar sua Compra!!!');
            parent.location = 'login.php';
            </script>";
        }
        else{
            //acessar pagamento;
            $data = date('y-m-d');
            $valor = $_SESSION['totalcompra'];            
            $matricula = $_SESSION["cliente"];
          
            $sqlvenda = "INSERT into venda(DATA,VALOR,ID_CLIENTE)values
            (:DATA,:VALOR,:ID_CLIENTE)";
            $salvarvenda= $conn->prepare($sqlvenda);
            $salvarvenda->bindParam(':DATA', $DATA, PDO::PARAM_STR);
            $salvarvenda->bindParam(':VALOR', $VALOR, PDO::PARAM_STR);
            $salvarvenda->bindParam(':ID_CLIENTE',$ID_CLIENTE , PDO::PARAM_STR);        
            $salvarvenda->execute();

            $venda = "Select LAST_INSERT_ID()";
            $resulvenda=$conn->prepare($venda);
            $resulvenda->execute();

            $linhavenda = $resulvenda->fetch(PDO::FETCH_ASSOC);     
           
            $idvenda = ($linhavenda["LAST_INSERT_ID()"]);

        $busca = "select * from carrinho";
        $resulbusca=$conn->prepare($busca);
        $resulbusca->execute();

        if(($resulbusca) && ($resulbusca->rowCount()!=0)){
            while ($linha = $resulbusca->fetch(PDO::FETCH_ASSOC)) {
                extract($linha);
                

               $sqlitem = "INSERT into roupa and venda_roupa(roupa.ID_PRODUTO,venda_roupa.ID_VENDA,roupa.QUANTIDADE,roupa.VALOR)
                values(:ID_PRODUTO,:ID_VENDA,:QUANTIDADE,:VALOR)";
                $salvaritem= $conn->prepare($sqlitem);
                $salvaritem->bindParam(':ID_PRODUTO', $ID_PRODUTO, PDO::PARAM_INT);
                $salvaritem->bindParam(':ID_VENDA', $ID_VENDA, PDO::PARAM_INT);
                $salvaritem->bindParam(':QUANTIDADE', $QUANTIDADE, PDO::PARAM_INT);
                $salvaritem->bindParam(':VALOR', $VALOR, PDO::PARAM_STR);
                $salvaritem->execute();

                $estoque = "UPDATE roupa set quantidade=(QUANTIDADE- $QUANTIDADE)
				where ID_PRODUTO = $ID_PRODUTO";
				$atualiza=$conn->prepare($estoque);
				$atualiza->execute();
            }

    }

    $sqllimpa = "delete from carrinho";
    $limpa= $conn->prepare($sqllimpa);
    $limpa->execute();
    $_SESSION["quant"] = 0;                                                                      


    header("Location:index.php");
    
    }

   
    }


    ?>