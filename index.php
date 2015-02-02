<?php
/*
 * * configurando variavel
 */
session_start();
//informações sobre error
$msg = "";
$error = FALSE;
if (isset($_POST['btn-conf'])) {
    //Pegar os valores enviado do post
    $config = $_POST;

    unset($config['btn-conf']);

    //validando as informações
    if (empty($config['host']) || empty($config['username']) || empty($config['dbname'])) {
        $error = true;
        $msg = "informe o servidor, usuario e senha!";
    }
    if ($error) {
        echo $msg;
    } else {
        try {
            $dbh = "pgsql:dbname={$config['dbname']};host={$config['host']};user={$config['username']};password={$config['password']}";
            $conexao = new PDO($dbh);
            $_SESSION['db'] = array(
                'conectado' => true,
                'config' => array(
                    'dbname' => $config['dbname'],
                    'host' => $config['host'],
                    'user' => $config['username'],
                    'password' => $config['password']
                )
            );
            header('Location: listaTabela.php');
        } catch (Exception $ex) {
            $error = true;
            $msg   = "Erro ao se conectar ao banco de dado!";
            $_SESSION['db'] = false;
            echo $msg;
        }    
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>

        <!-- (INICIO) Formulario para inserir as informações utilizada na conexao -->
        <h3>Preencha os campos</h3>
        <form action="index.php" method="post" name="form-config">
            <fieldset>
                <legend>Informações para conexão</legend>
                <fieldset>
                    <legend>Servidor/IP</legend>
                    <input type="text" value="127.0.0.1" name="host"/>
                </fieldset>
                <fieldset>
                    <legend>Usuário</legend>
                    <input type="text" value="postgres" name="username"/>
                </fieldset>
                <fieldset>
                    <legend>Senha</legend>
                    <input type="text" value="123456" name="password"/>
                </fieldset>
                <fieldset>
                    <legend>Banco de Dado</legend>
                    <input type="text" value="nome do banco" name="dbname"/>
                </fieldset>
                <input type="submit" value="Salvar informações" name="btn-conf"/>
            </fieldset>    
        </form>
        <!-- (FIM) Formulario para inserir as informações utilizada na conexao -->
    </body>
</html>
