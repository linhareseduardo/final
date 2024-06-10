<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Insert Products</title>

  <style>
    /* Basic styles */
    body {
      font-family: sans-serif; /* Choose a readable font */
      line-height: 1.5; /* Improve spacing between lines */
    }

    h2 {
      margin-bottom: 1rem; /* Add some space after the heading */
    }

    label {
      display: block; /* Display labels on their own line */
      margin-bottom: 0.5rem;
    }

    input[type="text"],
    input[type="submit"] {
      padding: 0.5rem;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    input[type="submit"] {
      background-color: #4CAF50; /* Green button */
      color: white;
      cursor: pointer; /* Indicate clickable button */
    }

    .success,
    .error {
      padding: 0.5rem;
      border-radius: 4px;
      margin-top: 1rem;
    }

    .success {
      background-color: #4CAF50; /* Green for success message */
      color: white;
    }

    .error {
      background-color: #f44336; /* Red for error message */
      color: white;
    }
  </style>
</head>
<body>
  <h2>Inserir novo estabelecimento</h2>

  <?php
  $connection = pg_connect("host = localhost dbname = projeto user = postgres password = root");

  if (!$connection) {
    echo "Erro ao conectar ao banco de dados. <br>";
    exit;
  }

  // Form to capture product data
  echo '<form method="post" action="">';
  echo '<label for="cnpj">CNPJ:</label>';
  echo '<input type="text" id="cnpj" name="cnpj"  maxlength="14" required><br><br>';
  echo '<label for="razaosocial">Razão Social:</label>';
  echo '<input type="text" id="razaosocial" name="razaosocial" required><br><br>';
  echo '<label for="nomefantasia">Nome Fantasia:</label>';
  echo '<input type="text" id="nomefantasia" name="nomefantasia" required><br><br>';
  echo '<input type="submit" value="Cadastrar">';
  echo '</form>';

  // Handle form submission and insert data
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cnpj = pg_escape_string($connection, $_POST['cnpj']); // Escape for security
    $razaosocial = pg_escape_string($connection, $_POST['razaosocial']); // Escape for security
    $nomefantasia = pg_escape_string($connection, $_POST['nomefantasia']); // Escape for security

    $query = "INSERT INTO estabelecimento (cnpj, razaosocial, nomefantasia) VALUES ('$cnpj', '$razaosocial', '$nomefantasia')";

    $result = pg_query($connection, $query);

    if ($result) {
      echo "<p class='success'>Estabelecimento inserido com sucesso!</p>";
    } else {
      echo "<p class='error'>Erro ao inserir o Estabelecimento. Verifique os dados.</p>";
      // Consider logging the error for debugging
    }
  }

  pg_close($connection); // Close the connection after use
  ?>
</body>
</html>
