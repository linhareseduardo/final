<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cadastro de Estabelecimento</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      margin: 0;
      padding: 0;
    }
    .container {
      max-width: 600px;
      margin: 50px auto;
      background-color: #fff;
      padding: 20px;
      border-radius: 5px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    h1 {
      text-align: center;
      margin-bottom: 20px;
    }
    label {
      display: block;
      margin-bottom: 5px;
    }
    input[type="text"] {
      width: 100%;
      padding: 8px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box;
    }
    input[type="submit"] {
      background-color: #4CAF50;
      color: #fff;
      padding: 10px 20px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }
    input[type="submit"]:hover {
      background-color: #45a049;
    }
    .success, .error {
      padding: 10px;
      border-radius: 5px;
      margin-top: 10px;
      text-align: center;
    }
    .success {
      background-color: #4CAF50;
      color: white;
    }
    .error {
      background-color: #f44336;
      color: white;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Cadastro de Estabelecimento</h1>
    <form method="POST" action="">
      <label for="cnpj">CNPJ:</label>
      <input type="text" id="cnpj" name="cnpj" maxlength="14" required>
      <label for="razaosocial">Razão Social:</label>
      <input type="text" id="razaosocial" name="razaosocial" required>
      <label for="nomefantasia">Nome Fantasia:</label>
      <input type="text" id="nomefantasia" name="nomefantasia" required>
      <input type="submit" value="Cadastrar">
    </form>

    <?php
    $connection = pg_connect("host=localhost dbname=projeto user=postgres password=root");

    if (!$connection) {
      echo "<p class='error'>Erro ao conectar ao banco de dados.</p>";
      exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $cnpj = pg_escape_string($connection, $_POST['cnpj']);
      $razaosocial = pg_escape_string($connection, $_POST['razaosocial']);
      $nomefantasia = pg_escape_string($connection, $_POST['nomefantasia']);

      $query = "INSERT INTO estabelecimento (cnpj, razaosocial, nomefantasia) VALUES ('$cnpj', '$razaosocial', '$nomefantasia')";
      $result = pg_query($connection, $query);

      if ($result) {
        echo "<p class='success'>Estabelecimento cadastrado com sucesso!</p>";
      } else {
        echo "<p class='error'>Erro ao cadastrar o estabelecimento. Verifique os dados.</p>";
      }
    }

    pg_close($connection);
    ?>
  </div>
</body>
</html>
