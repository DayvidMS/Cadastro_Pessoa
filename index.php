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
    <section id="esquerda">
        <form>
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
           if(count($dados)>0){
               for($i=0;$i < count($dados);$i++){
                echo "<tr>";
                foreach($dados[$i] as $k => $v)
                {
                    if($k != "id"){
                        echo "<td>".$v."</td>";
                    }
                }
                ?><td><a href="">editar</a> <a href="">Excluir</a></td>
                <?php
                echo "</tr>";
           }
           ?>
           
       <?php 
        }
        ?>  
        </table>
    </section>
</body>
</html>