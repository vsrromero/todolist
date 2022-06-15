<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <form action="#" method="POST">
            Nome: <input type="text" name="nome" value="1">
            Idade: <input type="text" name="idade" />
            <input type="submit" value="POST"/>
        </form>
        <pre>
            <?php
            // Habilitar a exibição de erros em tempo de execução.
            ini_set("display_errors", "on");
            // Depurar a super global POST.
            print_r($_POST);
            // Testar a tipagem da super global POST.
            var_dump($_POST);
            ?>
        </pre>

    </body>
</html>
<?php
$nome = $_POST["nome"];
$idade = $_POST["idade"];
echo "Olá $nome, você tem $idade ano(s)... legal!!!";
?>