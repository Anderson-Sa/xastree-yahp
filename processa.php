<?php

//Acessar mysql
$servidor = "localhost";
$usuario = "root";
$senha = "root";
$dbname = "investe";

$con = mysqli_connect($servidor, $usuario, $senha, $dbname);

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
    echo "Erro ao conectar com banco de dados";
}

//Dados para enviar pro Banco de dados

$tipo = $_POST['tipo'];
$valor = $_POST['valor'];
$cliente_id = $_POST['cliente_id'];

    $result = mysqli_query($con, "SELECT * from investetb where Cadastro=$cliente_id");
    $count = mysqli_num_rows($result);

    if($count == 0)
    {
        $sql = "INSERT INTO investetb (Resultado, valor, Cadastro) VALUES ('$tipo', '$valor', '$cliente_id')";

        if(mysqli_query($con, $sql)){
    
            echo "Invesitmento inserido com sucesso.<br /> voce será redirecionado em breve.";
            sleep(3);
            header("Location: index.php"); 
        } else{
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($con);
        }
    
        mysqli_close($con);
    
    } elseif($count == 1)
    {

        $sql = "UPDATE investetb set Resultado='$tipo', valor='$valor' WHERE Cadastro = $cliente_id";

        if(mysqli_query($con, $sql)){
    
            echo "Invesitmento alterado com sucesso.<br /> voce será redirecionado em breve.";
            sleep(3);
            header("Location: index.php"); 
        } else{
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($con);
        }

    } else {
        echo "erro ao operacionalizar o invertimento. Entre em contato com suporte técnico";
    }

?>
