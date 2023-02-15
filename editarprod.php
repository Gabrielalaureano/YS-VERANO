<?php

   require_once 'head.php';
    include_once 'conexao.php';
    session_start();
    ob_start();

    $cod = filter_input(INPUT_GET, "ID_PRODUTO", FILTER_SANITIZE_NUMBER_INT);

    if (empty($cod)) {
        $_SESSION['msg'] = "Erro: Produto não encontrado!";
        header("Location: relproduto.php");
        exit();
    }

    $sql = "SELECT * from roupa where ID_produto = $cod LIMIT 1";
    $resultado= $conn->prepare($sql);
    $resultado->execute();

    if(($resultado) AND ($resultado->rowCount() != 0)){
        $linha = $resultado->fetch(PDO::FETCH_ASSOC);
       
        extract($linha);
    }
    else{
        $_SESSION['msg'] = "Erro: Produto não encontrado!";
        header("Location: relproduto.php");
    }


?>


<form method="POST" action="controleproduto.php" enctype="multipart/form-data">
    <div class="container">
        <div class="row">
                <div class="col-md-12 text-center">
                    <h3>Atualização de Produtos</h3>                   
                </div>
        </div>

        <div class="row">
                <div class="col-md-12 text-center">
                   <img src="<?php echo $FOTO ?>" style = width:150px;height:150px;>  <!--acrescentar-->
                </div>
        </div>

        <div class="row">

            <div class="col-md-1">
                <div class="form-group">
                    <label for="codigo">Codigo</label>
                    <input type="hidden" class="form-control" name="codigo"
                    value="<?php echo $ID_PRODUTO;?>"
                    >    
                </div>
            </div>   

            <div class="col-md-6">
                <div class="form-group">
                    <label for="nome">Nome</label>
                    <input type="text" class="form-control" name="nome" value="<?php echo $NOME;?>">    
                </div>
            </div>           

            <div class="col-md-2">
                <div class="form-group">
                    <label for="cor">Cor</label>
                    <input type="text" name="cor" class="form-control" value="<?php echo $COR;?>">
                </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                 <label for="valor">Valor</label>
                 <input type="text" class="form-control" name="valor" onchange="this.value = this.value.replace(/,/g, '.')"/
                 value="<?php echo $VALOR;?>">  
                 </div>
            </div>
        </div>

        <div class="row">

            <div class="col-md-2">        
              <div class="form-group">            
                  <label for="dn">Tamanho</label>
                  <input type="text" class="form-control" name="tamanho" value="<?php echo $TAMANHO;?>">
              </div>
           </div>
             
           
            <div class="col-md-3">        
                <div class="form-group">            
                    <label for="cpf">Quantidade</label>
                    <input type="text" name="quantidade" class="form-control" value="<?php echo $QUANTIDADE;?>">
                </div>
            </div>

            <div class="col-md-4">        
                <div class="form-group">            
                    <label for="categoria">Categoria</label>
                   <p> <select name="categoria" class="form-control">
                        <?php

                            $categoria = $ID_CATEGORIA;
                            $sql = "SELECT * from CATEGORIA";
                            $resultado= $conn->prepare($sql);
                            $resultado->execute();

                            if (($resultado) and ($resultado->rowCount() != 0)) { 
                            while ($linha = $resultado->fetch(PDO::FETCH_ASSOC)) {

                                extract($linha);

                                ?>
                        <option value="<?php echo $ID_CATEGORIA; ?>"
                        
                        <?php
                        if ($CATEGORIA == $ID_CATEGORIA)
                            echo "selected";
                                ?>                       
                        
                        >        
                        
                        
                        <?php echo $DESCRICAO?></option>
                        <?php
                            }
                        }

                    ?>
                    </select>

                   
                </div>
            </div>
                    
            <div class="col-md-3  ">
              <div class="form-group">
                 <label for="foto">Foto</label><p>
                 <input type="file" class="form-control" name="foto">
                </div>
            </div>
           


        </div>
           
        <div class="row">
            <div class="col-md-2">
                <div class="form-group">
                   
                    <input type="submit" class="btn btn-primary" value="Enviar" name="btneditar">
                </div>  
            </div>
        </div>
    
  
</form>


<?php
    require_once 'rodape.php';
?>
