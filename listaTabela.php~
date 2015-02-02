<?php
session_start();

$lista_tabela = false;

//Funcao para fazer debug de variavel
function Debug($variavel) {
    echo '<pre>';
    print_r($variavel);
    echo '</pre>';
}

if(isset($_POST['btn_tabela'])){
   if(isset($_POST['grp_tabela'])){
       $_SESSION['tabela']= $_POST['grp_tabela'];
       header('Location: listaTabelaCampos.php');
   }  else {
       echo 'Selecione uma pagina';
   }
}

if(isset($_SESSION['db'])){
    $lista_tabela = true;
    $config = $_SESSION['db']['config'];
    $dbh = "pgsql:dbname={$config['dbname']};host={$config['host']};user={$config['user']};password={$config['password']}";
    $conexao = new PDO($dbh);
    $consulta_de_tabela = $conexao->query("SELECT tablename AS tabela FROM pg_catalog.pg_tables WHERE schemaname NOT IN ('pg_catalog', 'information_schema', 'pg_toast') ORDER BY tablename");
    $lista_de_tabela    = $consulta_de_tabela->fetchAll(PDO::FETCH_OBJ);
}else{
    header('Location: index.php');
}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <!-- (INICIO) Responsavel por lista os atributos da tabela selecionada -->
        <?php if ($lista_tabela): ?>
            <h3>Lista de tabelas encontradas</h3>
            <form action="listaTabela.php" method="post" name="form-tabela">
                <fieldset>
                    <legend>Tabelas encotradas nº (<?php echo count($lista_de_tabela); ?>)</legend>
                    <?php foreach ($lista_de_tabela as $tabela): ?>
                        <input type="checkbox" name="grp_tabela[]" value="<?php echo $tabela->tabela; ?>"><?php echo $tabela->tabela; ?><br>
                    <?php endforeach; ?>
                        <input type="submit" value="Selecionar Tabela" name="btn_tabela" style="margin-top: 20px;"/>
                </fieldset>
            </form>
        <?php endif; ?>
        <!-- (FIM) Responsavel por lista os atributos da tabela selecionada -->
    </body>
</html>


