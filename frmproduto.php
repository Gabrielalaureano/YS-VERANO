<?php
    require_once 'head.php'; 
    require_once 'menu.php';
    require_once 'conexao.php';

    $sql = "SELECT * from categoria";
    $resultado=$conn->prepare($sql);
    $resultado->execute();
    

?>

<form method="POST" action="controleproduto.php" enctype="multipart/form-data">
    <div class="container">
        <div class="row">
                <div class="col-md-12 text-center">
                    <h3>Cadastro de Produto</h3>
                </div>
        </div>

        <div class="row">
                       
            <div class="col-md-8">
                <div class="form-group">
                    <label for="nome">Nome</label>
                    <input type="text" class="form-control" name="nome">    
                </div>
            </div>   
            
            <div class="col-md-2">
                <div class="form-group">
                    <label for="cor">Cor</label>
                    <input type="text" class="form-control" name="cor">    
                </div>
            </div>   
            
            <div class="col-md-2">
                <div class="form-group">
                    <label for="tamanho">Tamanho</label>
                    <input type="text" class="form-control" name="tamanho">    
                </div>
            </div>  
</div>

<div class="row">

            <div class="col-md-2">
                <div class="form-group">
                    <label for="quantidade">Quantidade</label>
                    <input type="text" class="form-control" name="quantidade">    
                </div>
            </div>  

            <div class="col-md-2">
                <div class="form-group">
                    <label for="valor">Preço Compra</label>
                    <input type="text" class="form-control" name="custo" onchange="this.value = this.value.replace(/,/g, '.')">    
                </div>
            </div>  

            <div class="col-md-2">
                <div class="form-group">
                    <label for="valor">Preço Venda</label>
                    <input type="text" class="form-control" name="valor" onchange="this.value = this.value.replace(/,/g, '.')">    
                </div>
            </div>  

            <div class="col-md-8">
                <div class="form-group">
                    <label for="categoria">Categoria</label>
                    <select name="categoria" class="form-control">

                        <?php

                            if (($resultado) and ($resultado->rowCount() != 0)) { 
                                while ($linha = $resultado->fetch(PDO::FETCH_ASSOC)) {

                                    extract($linha);


                        ?>
                        <option value="<?php echo $ID_CATEGORIA;?>"> <?php echo $DESCRICAO; ?> </option>
                        
                        <?php
                                }
                            }
                            ?>

                    </select>                    
                </div>
            </div> 

            <div class="col-md-8">
                <div class="form-group">
                    <label for="fornecedor">Fornecedor</label>
                    <select name="fornecedor" class="form-control">

                        <?php

                            $sql2 = "SELECT * from fornecedor";
                            $resultado2=$conn->prepare($sql2);
                            $resultado2->execute();


                            if (($resultado2) and ($resultado2->rowCount() != 0)) { 
                                while ($linha2 = $resultado2->fetch(PDO::FETCH_ASSOC)) {

                                    extract($linha2);


                        ?>
                        <option value="<?php echo $ID_FORNECEDOR;?>"> <?php echo $NOME; ?> </option>
                        
                        <?php
                                }
                            }
                            ?>

                    </select>                    
                </div>
            </div> 
</div>

<div class="row">
            <div class="col-md-5">
                <div class="form-group">
                    <label for="foto">Imagem</label>
                    <input type="file" class="form-control" name="foto">    
                </div>
            </div>  
</div>

<div class="row">
            <div class="col-md-12 text-right">
                <div class="form-group">
                   
                    <input type="submit" class="btn btn-primary" value="Enviar" name="btncad">
                </div>  
            </div>

</div>
</form>

<?php
    require_once 'footer.php';
?>