//Criar conexão com banco
<?php
   $host        = "host=localhost";
   $port        = "port=5432";
   $dbname      = "postgres";
   $credentials = "user=postgres password=root";

   $db = pg_connect("$host $port dbname=$dbname $credentials");
   
   if(!$db) {
      echo "Erro : Não foi possível conectar ao banco de dados PostgreSQL.";
   } else {
      echo "Conexão bem sucedida.";
   }
?>

// INSERT ----------------------------------------------------------------------------------------
<?php
// Conexão com postgreSQL 
$conn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=root");

// Obter os dados do formulário
$nome = isset($_POST['nome']) ? pg_escape_string($conn, $_POST['nome']) : "";
$sobrenome = isset($_POST['sobrenome']) ? pg_escape_string($conn, $_POST['sobrenome']) : "";
$rua = isset($_POST['rua']) ? pg_escape_string($conn, $_POST['rua']) : "";


// validação dos dados do formulário
$nome = htmlspecialchars($nome);
$sobrenome = htmlspecialchars($sobrenome);
$rua = htmlspecialchars($rua);

// Construção da consulta SELECT 
$sql_select = "SELECT * FROM usuarios WHERE nome = $1 AND sobrenome = $2 AND rua = $3";

// Execução da consulta SELECT
$result_select = pg_query_params($conn, $sql_select, array($nome, $sobrenome, $rua));

// Verificar se já existe um registro com os mesmos valores
if (pg_num_rows($result_select) > 0) {
    //echo "Os dados já existem no banco de dados.";
    echo "";
} else {
    // Construção do INSERT 
    $sql_insert = "INSERT INTO usuarios (nome, sobrenome, cep, rua, bairro, cidade, uf, numero, complemento)
    VALUES ($1, $2, $3)";

    // Execução do INSERT
    $result_insert = pg_query_params($conn, $sql_insert, array($nome, $sobrenome, $rua));

    // Checar se o INSERT funcionou
    if ($result_insert) {
        echo "Formulário enviado!";
        //header('location:display.php');
    } else {
        echo "Erro ao inserir" . pg_last_error($conn);
    }
}

// Fechar conexão
pg_close($conn);
?>


// SELECT ----------------------------------------------------------------------------------------
<?php
// Define as credenciais de conexão ao banco de dados
$dbname = "postgres";
$user = "postgres";
$password = "root";
$host = "localhost";
$port = "5432";

// Conecte-se ao banco de dados
$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

// Defina a consulta que deseja executar
$sql = "SELECT * FROM usuarios" ;

// Execute a consulta
$result = pg_query($conn, $sql);

// Itere sobre os dados e exiba o nome de cada usuário
while ($row = pg_fetch_assoc($result)) {
    $id=$row['id'];
    $name=$row['nome'];
    $sobrenome=$row['sobrenome'];
    $rua=$row['rua'];
    echo '            
    <tr>
        <td scope="row">'.$id.'</td>
        <td>'.$name.'</td>
        <td>'.$sobrenome.'</td>
        <td>'.$rua.'</td>
        
        <div class="button-group">
        <td>

        <button class="btn"><a href="editregistros.php?updateid='.$id.'"title="Editar">
        </a>
        </button>

        
        <button><a href="delete.php?deleteid='.$id.'" onclick="return confirmDelete();" title="Deletar">
        </a>
        </button>
        
       </td>
    </tr>';
}
?>

//UDPATE ----------------------------------------------------------------------------------------
<?php
// Conexão com postgreSQL 
$conn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=root");
$id = $_GET['updateid'];

// Obter os dados do formulário
$nome = isset($_POST['nome']) ? pg_escape_string($conn, $_POST['nome']) : "";
$sobrenome = isset($_POST['sobrenome']) ? pg_escape_string($conn, $_POST['sobrenome']) : "";
$cep = isset($_POST['cep']) ? pg_escape_string($conn, $_POST['cep']) : "";
$rua = isset($_POST['rua']) ? pg_escape_string($conn, $_POST['rua']) : "";
$bairro = isset($_POST['bairro']) ? pg_escape_string($conn, $_POST['bairro']) : "";
$cidade = isset($_POST['cidade']) ? pg_escape_string($conn, $_POST['cidade']) : "";
$uf = isset($_POST['uf']) ? pg_escape_string($conn, $_POST['uf']) : "";
$numero = isset($_POST['numero']) ? pg_escape_string($conn, $_POST['numero']) : "";
$complemento = isset($_POST['complemento']) ? pg_escape_string($conn, $_POST['complemento']) : "";

// validação dos dados do formulário
$nome = htmlspecialchars($nome);
$sobrenome = htmlspecialchars($sobrenome);
$cep = htmlspecialchars($cep);
$rua = htmlspecialchars($rua);
$bairro = htmlspecialchars($bairro);
$cidade = htmlspecialchars($cidade);
$uf = htmlspecialchars($uf);
$numero = htmlspecialchars($numero);
$complemento = htmlspecialchars($complemento);

// Construção da consulta SELECT 
$sql_select = "SELECT * FROM usuarios WHERE nome = $1 AND sobrenome = $2 AND cep = $3 AND rua = $4 AND bairro = $5 AND cidade = $6 AND uf = $7 AND numero = $8 AND complemento = $9";
$params_select = array($nome, $sobrenome, $cep, $rua, $bairro, $cidade, $uf, $numero, $complemento);

// Execução da consulta SELECT
$result_select = pg_query_params($conn, $sql_select, $params_select);

// Verificar se já existe um registro com os mesmos valores
if (pg_num_rows($result_select) > 0) {
    //echo "Os dados já existem no banco de dados.";
    echo "";
} else {
    // Construção do UPDATE 
    $sql_update = "UPDATE usuarios SET nome=$1, sobrenome=$2, cep=$3, rua=$4, bairro=$5, cidade=$6, uf=$7, numero=$8, complemento=$9 WHERE id=$10";
    $params_update = array($nome, $sobrenome, $cep, $rua, $bairro, $cidade, $uf, $numero, $complemento, $id);

    // Execução do UPDATE
    $result_update = pg_query_params($conn, $sql_update, $params_update);

    // Checar se o UPDATE funcionou
    if ($result_update) {
        echo "Formulário atualizado!";
        //header('location:display.php');
    } else {
        echo "Erro ao atualizar" . pg_last_error($conn);
    }
}

// Fechar conexão
pg_close($conn);
?>


// DELETE ----------------------------------------------------------------------------------------
<?php
// Define as credenciais de conexão ao banco de dados
$dbname = "postgres";
$user = "postgres";
$password = "root";
$host = "localhost";
$port = "5432";

// Conecte-se ao banco de dados
$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

if (isset($_GET['deleteid'])) {
    $id = $_GET['deleteid'];

    $sql = "DELETE FROM \"usuarios\" WHERE id=$id";
    $result = pg_query($conn, $sql);

    if ($result) {
        echo "Usuário deletado!";
    }
}
?>

// Incluir conexao 
<?php
include 'config.php';
?>

// verificar se o banco esta conectado
<?php
  phpinfo();
?>

