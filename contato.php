<?php
    // Verifica se existe a variável txtnome
    if (isset($_GET["txtnome"])) {
        $nome = $_GET["txtnome"];
        
        // Conexao com o banco de dados
        $server = "localhost";
        $user = "root";
        $senha = "";
        $base = "agenda";
        
        $conexao = mysql_connect($server, $user, $senha) or die("Erro na conexão!");
        mysql_select_db($base);

        // Verifica se a variável está vazia
        if (empty($nome)) {
            $sql = "SELECT * FROM contato";
        } else {
            $nome .= "%";
            $sql = "SELECT * FROM contato WHERE nome like '$nome'";
        }

        sleep(1);
        $result = mysql_query($sql);
        $cont = mysql_affected_rows($conexao);

        // Verifica se a consulta retornou linhas 
        if ($cont > 0) {
            // Atribui o código HTML para montar uma tabela
            $tabela = "<table border='1'>
                        <thead>
                            <tr>
                                <th>NOME</th>
                                <th>TELEFONE</th>
                                <th>CELULAR</th>
                                <th>EMAIL</th>
                            </tr>
                        </thead>
                        <tbody>
                        <tr>";
            $return = "$tabela";
            // Captura os dados da consulta e inseri na tabela HTML
            while ($linha = mysql_fetch_array($result)) {
                $return.= "<td>" . utf8_encode($linha["nome"]) . "</td>";
                $return.= "<td>" . utf8_encode($linha["telefone"]) . "</td>";
                $return.= "<td>" . utf8_encode($linha["celular"]) . "</td>";
                $return.= "<td>" . utf8_encode($linha["email"]) . "</td>";
                $return.= "</tr>";
            }
            echo $return.="</tbody></table>";
        } else {
            // Se a consulta não retornar nenhum valor, exibi mensagem para o usuário
            echo "Não foram encontrados registros!";
        }
    }
?>