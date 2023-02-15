<?php  
  require_once 'head.php';
  include_once 'conexao.php';
  session_start();
  ob_start();

  $id = filter_input(INPUT_GET, "ID_PRODUTO", FILTER_SANITIZE_NUMBER_INT);

  if (empty($id)) {
      $_SESSION['msg'] = "Erro:produto não encontrado!";
      header("Location: relaproduto.php");
      exit();
  }


  $sql = "UPDATE produto set status='I' where ID_PRODUTO = $id LIMIT 1";
  $resultado= $conn->prepare($sql);
  $resultado->execute();



  if(($resultado) AND ($resultado->rowCount() != 0)){
    echo "<script>
    alert('Produto excluido com sucesso!');
    parent.location = 'relaproduto.php';
    </script>";

  }else{
    echo "<script>
    alert('Exclusão não realizada!');
    parent.location = 'relproduto.php';
    </script>";
  }

?>


