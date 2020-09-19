<?php

// COMANDOS PARA PARA A API SE APRESENTAR EM JSON
 $url = "https://reqres.in/api/users?page=1";
 $json = file_get_contents($url);
 $dados = json_decode($json, true);

?>

<!doctype html>
<html lang="pt-BR">
  <head>
    <title>Investimento</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>
  <nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <a class="navbar-brand" href="index.php">XasTree</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
            </li>
            <!-- <li class="nav-item">
                <a class="nav-link" href="#">Link</a>
            </li>
            <li class="nav-item">
                <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</a>
                <div class="dropdown-menu" aria-labelledby="dropdown01">
                <a class="dropdown-item" href="#">Action</a>
                <a class="dropdown-item" href="#">Another action</a>
                <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </li> -->
        </ul>
    </div>
    </nav>
    <main role="main" class="container pt-4 mt-4">
        <h2>Funcionários: Status Code Weekly</h2>
        <table class='table'>  
            <tr>
            <!-- Tabela feita dos dados retirados da API -->
                <th>Foto</th>
                <th># Empregado</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Investimento</th>
                <th></th>
            </tr>
            <?php
            $servidor = "localhost";
            $usuario = "root";
            $senha = "root";
            $dbname = "investe";
            $porta = "3306";

            $con = mysqli_connect($servidor, $usuario, $senha, $dbname,$porta);
            //Dados da API  organizados 
                foreach ($dados['data'] as $dado)
                {
                    $result = mysqli_query($con, "SELECT * from investetb where Cadastro=".$dado['id']);
                    $count = mysqli_num_rows($result);
                    if($count == 0) 
                    {
                        $tipo = "";
                        $valor = "";
                    } else {
                        $row = mysqli_fetch_assoc($result);
                        $tipo = $row['Resultado'];
                        $valor = " - R$".$row['valor'];
                    }
                
                    echo "<tr>
                            <td>  <img src='".$dado['avatar']."' class='figure-img img-fluid rounded' alt='...'></td>
                            <td>".$dado['id']."</td>
                            <td>".$dado['first_name']." ".$dado['last_name']."</td>
                            <td>".$dado['email']."</td>
                            <td> $tipo $valor </td>
                            <td>
                                <div class='btn-group' role='group' aria-label='Basic example'>
                                    <button type='button' class='btn btn-primary' data-toggle='modal' data-target='#funcionario".$dado['id']."'>Investir</button>
                                </div>
                            </td>
                            </tr>";


                    echo "<div class='modal fade' id='funcionario".$dado['id']."' tabindex='-1' aria-labelledby='funcionario".$dado['id']."' aria-hidden='true'>
                            <div class='modal-dialog'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                <h5 class='modal-title' id='exampleModalLabel'>Investimento</h5>
                                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                    <span aria-hidden='true'>&times;</span>
                                </button>
                                </div>
                                <form action='processa.php' method='POST'>
                                <div class='modal-body'>
                                    <input type='hidden' name='cliente_id' value='".$dado['id']."'>
                                    <h5><small>Opções de Investimento para:</small><br /> ".$dado['first_name']." ".$dado['last_name']."</h5>
                                    <label for='Valor'>Quanto você quer Investir?</label>
                                    <input type='number' name='valor' id='valor' step='0.01' min='0' class='form-control' placeholder='Valor do investimento'>
                                    <label for='tipo'>Onde você quer Investir?</label>
                                    <input type='text' name='tipo' id='tipo' class='form-control' placeholder='Tipo do investimento'>
                                </div>
                                <div class='modal-footer'>
                                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Fechar</button>
                                <button type='submit' class='btn btn-primary'>Salvar</button>
                                </form>
                                </div>
                            </div>
                            </div>
                        </div>";
                }
                ?>
        </table>

    </main>
    
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>