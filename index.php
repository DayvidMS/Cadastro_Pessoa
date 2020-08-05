<?php
require_once 'pessoa.php';
$p = new Pessoa("crudpessoa","localhost","root","");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="uft-8">
    <title>Cadastro Pessoa</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
<?php
    if(isset($_POST['nome'])){
        $nome = addslashes($_POST['nome']);
        $telefone = addslashes($_POST['telefone']);
        $email = addslashes($_POST['email']);
        if(!empty($nome) && !empty($telefone) && !empty($email)){
            //cadastrar
            if (!$p->cadastrarPessoa($nome, $telefone, $email)){
                echo "email já está cadastrado!";
            }

        }else{
            echo "Preencha todos os campos";
        }
    }
?>
    <section id="esquerda">
        <form method="POST">
            <h2>CADASTRAR PESSOA</h2>
            <label for="nome">Nome</label>
            <input type="text" name="nome" id="nome">
            <label for="telefone">Telefone</label>
            <input type="text" name="telefone" id="telefone">
            <label for="email">Email</label>
            <input type="text" name="email" id="email">
            <input type="submit" value="cadastrar">
        </form>
    </section>
    <section id="direita">
    <table>
            <tr id="titulo">
                <td>nome</td>
                <td>Telefone</td>
                <td colspan="2">Email</td>
            </tr>
        <?php 
           $dados = $p->buscarDados();
           if(count($dados)>0){  //TEM PESSOAS NO BANCO
               for($i=0;$i < count($dados);$i++){
                echo "<tr>";
                foreach($dados[$i] as $k => $v)
                {
                    if($k != "id"){
                        echo "<td>".$v."</td>";
                    }
                }
                ?>
                <td>
                    <a href="">editar</a>
                    <a href="index.php?id=<?php echo $dados[$i]['id'];?>">Excluir</a>
                </td>
                <?php
                echo "</tr>";
           }
        }else { //banco de dados vazio
               echo "Ainda não há pessoas cadastradas";
           }
           ?> 
        </table>
    </section>
</body>
</html>

<?php 
    if(isset($_GET['id'])){
        $id_pessoa = addslashes($_GET['id']);
        $p->excluirPessoa($id_pessoa);
        header("location: index.php");
    }

?>