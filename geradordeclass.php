<?php

session_start();

if (isset($_SESSION['tabela'])) {
    //Pega a configuração para realizar a conexao
    $config = $_SESSION['db']['config'];
    //pega o nome da tabela selecionada
    $tabelas = $_SESSION['tabela'];
    //monta o dsn para conexao com o banco de dado postgres
    $dsn = "pgsql:dbname={$config['dbname']};host={$config['host']};user={$config['user']};password={$config['password']}";
    //cria a conexao
    $conexao = new PDO($dsn);

    for ($i = 0; $i < count($tabelas); $i++) {
        $tabela = $tabelas[$i];
        //monta a consulta
        $sql = 'SELECT rel.nspname, rel.relname, attrs.attname, "Type", "Default",   attrs.attnotnull 
            FROM (
	          SELECT c.oid, n.nspname, c.relname FROM pg_catalog.pg_class c 
	    LEFT JOIN pg_catalog.pg_namespace n ON n.oid = c.relnamespace 
            WHERE pg_catalog.pg_table_is_visible(c.oid)   ) rel 
            JOIN (
                SELECT a.attname, a.attrelid, pg_catalog.format_type(a.atttypid,   a.atttypmod) as "Type",
         	(SELECT substring(d.adsrc for 128) FROM pg_catalog.pg_attrdef   d 
            WHERE d.adrelid = a.attrelid AND d.adnum = a.attnum AND a.atthasdef) as "Default",   
            a.attnotnull, a.attnum FROM pg_catalog.pg_attribute a WHERE a.attnum > 0   AND NOT a.attisdropped ) 
            attrs ON (attrs.attrelid = rel.oid ) WHERE relname = \'' . $tabela . '\' ORDER BY attrs.attnum;';
        //executa a consulta
        $consulta_de_coluna = $conexao->query($sql);
        //pega o retorno da consulta em forma de objeto
        $lista_de_coluna = $consulta_de_coluna->fetchAll(PDO::FETCH_OBJ);
        //cria o arquivo
        if (($fp = fopen('gen/'.ucfirst($tabela) . '.php', 'w'))) {
            //seta a tag php e quebra duas linhas
            fprintf($fp, "<?php");
            fprintf($fp, "\n");
            fprintf($fp, "\n");
            //monta o cabecalho da class
            vfprintf($fp, "class %s {", array(ucfirst($tabela)));
            fprintf($fp, "\n");
            fprintf($fp, "\n");
            //monta os atributos da class
            foreach ($lista_de_coluna as $coluna):
                vfprintf($fp, "    protected $%s;\n", array($coluna->attname));
            endforeach;

            fprintf($fp, "\n");
            //montando os metodos get's 
            foreach ($lista_de_coluna as $coluna):
                vfprintf($fp, "    public function get%s(){", array(ucfirst($coluna->attname)));
                fprintf($fp, "\n");
                vfprintf($fp, "        return \$this->%s;", array($coluna->attname));
                fprintf($fp, "\n");
                fprintf($fp, "    }");
                fprintf($fp, "\n");
                fprintf($fp, "\n");
            endforeach;
            //montando os metodos set's
            foreach ($lista_de_coluna as $coluna):
                vfprintf($fp, "    public function set%s(\$%s){", array(ucfirst($coluna->attname), $coluna->attname));
                fprintf($fp, "\n");
                vfprintf($fp, "        return \$this->%s = \$%s;", array($coluna->attname, $coluna->attname));
                fprintf($fp, "\n");
                fprintf($fp, "    }");
                fprintf($fp, "\n");
                fprintf($fp, "\n");
            endforeach;
            //montando o metodo getArrayCopy
            fprintf($fp, "    public function getArrayCopy(){");
            fprintf($fp, "\n");
            fprintf($fp, "        return get_object_vars(\$this);");
            fprintf($fp, "\n");
            fprintf($fp, "    }");
            fprintf($fp, "\n");
            fprintf($fp, "\n");
            //montando o metodo exchangeArray($data)
            fprintf($fp, "    public function exchangeArray(\$data){");
            fprintf($fp, "\n");
            foreach ($lista_de_coluna as $coluna):
                vfprintf($fp, "        \$this->%s = (isset(\$data['%s'])) ? \$data['%s'] : null;", array($coluna->attname, $coluna->attname, $coluna->attname));
                fprintf($fp, "\n");
            endforeach;
            fprintf($fp, "    }");
            fprintf($fp, "\n");
            fprintf($fp, "\n");
            //finalizando a class
            fprintf($fp, "}");
            //fechando o arquivo
            fclose($fp);
        }
    }
echo 'Classe gerada com sucesso !';
}else {
    header('Location: index.php');
}


