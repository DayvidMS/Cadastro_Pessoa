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
    if(isset($_POST['nome'])){//Clicou no botão cadastrar ou editar
        //-------------------Editar-------------------------
        if(isset($_GET['id_up']) && !empty($_GET['id_up'])){
            $id_upd = addslashes($_GET['id_up']);
            $nome = addslashes($_POST['nome']);
            $telefone = addslashes($_POST['telefone']);
            $email = addslashes($_POST['email']);
            if(!empty($nome) && !empty($telefone) && !empty($email)){
                //editar
                $p->atualizarDados($id_upd, $nome, $telefone, $email);
                header("location: index.php");
            }else{
                ?>
                    <div class="aviso">
                        <h4>Preencha todos os campos</h4>
                    </div>
                <?php
            }
        }
        //------------------cadastrar------------------------
        else{
                $nome = addslashes($_POST['nome']);
            $telefone = addslashes($_POST['telefone']);
            $email = addslashes($_POST['email']);
            if(!empty($nome) && !empty($telefone) && !empty($email)){
                //cadastrar
                if (!$p->cadastrarPessoa($nome, $telefone, $email)){
                    ?>
                    <div class="aviso">
                        <h4>Email já está cadastrado</h4>
                    </div>
                <?php
                }

            }else{
                ?>
                    <div class="aviso">
                        <h4>Preencha todos os campos</h4>
                    </div>
                <?php
            }
        }
       
    }
?>
<?php
    if(isset($_GET['id_up'])){ //Esse if se verifica se a pessoa clicou em Editar
        $id_update = addslashes($_GET['id_up']);
        $res = $p->buscarDadosPessoa($id_update);
    }
?>
    <section id="esquerda">
        <form method="POST">
            <h2>CADASTRAR PESSOA</h2>
            <label for="nome">Nome</label>
            <input type="text" name="nome" id="nome" value="<?php if(isset($res)){echo $res['nome'];} ?>">
            <label for="telefone">Telefone</label>
            <input type="text" name="telefone" id="telefone" value="<?php
            if(isset($res)){echo $res['telefone'];}?>">
            <label for="email">Email</label>
            <input type="text" name="email" id="email" value="<?php if(isset($res)){echo $res['email'];}?>">
            <input type="submit" value="<?php if(isset($res)){echo "Atualizar";}else{echo "Cadastrar";}?>">
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
                    <a href="index.php?id_up=<?php echo $dados[$i]['id'];?>">editar</a>
                    <a href="index.php?id=<?php echo $dados[$i]['id'];?>">Excluir</a>
                </td>
                <?php
                echo "</tr>";
           }
        }else { //banco de dados está vazio
            ?>
            <div class="aviso">
                <h4>Ainda não há pessoas cadastradas!</h4>
            </div>
                
               
               <?php
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