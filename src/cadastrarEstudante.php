<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  require_once('./app/models/estudanteModel.php');

  session_start();

  $nome = $_POST['nome'];
  $rg = $_POST['rg'];
  $cpf = $_POST['cpf'];
  $dataNascimento = $_POST['dataNascimento'];
  $telefones = $_POST['telefones'];
  $nomePai = $_POST['nomePai'];
  $nomeMae = $_POST['nomeMae'];

  $estudanteModel = new EstudanteModel();

  $id = $estudanteModel->createEstudante(
    $nome,
    $rg,
    $cpf,
    $dataNascimento,
    $telefones,
    $nomePai,
    $nomeMae,
  );

  $_SESSION['id'] = $id;

  header('Location: index.php');
  exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Cadastro de Estudante</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body
  class="bg-neutral-900 flex h-screen w-screen justify-center items-center py-10">
  <div class="w-full mx-auto max-w-md bg-white rounded-lg shadow-md p-8 overflow-y-auto">
    <div class="mb-4">
      <a href="/" class="text-blue-500 hover:underline">&larr; Voltar para a página inicial</a>
    </div>
    <div class="flex justify-center mb-6">
      <button class="px-4 py-2 font-semibold text-blue-500">Cadastro de Estudante</button>
    </div>

    <form class="space-y-4" method="post">
      <input
        type="text"
        placeholder="Nome Completo"
        name="nome"
        required
        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" />
      <input
        type="text"
        placeholder="RG (somente números)"
        name="rg"
        required
        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" />
      <input
        type="text"
        placeholder="CPF (somente números)"
        name="cpf"
        required
        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" />

      <div>
        <label for="dataNascimento" class="block text-sm font-medium text-gray-700">Data de Nascimento</label>
        <input
          type="date"
          id="dataNascimento"
          name="dataNascimento"
          required
          class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" />
      </div>

      <input
        type="tel"
        placeholder="Telefone (com DDD)"
        name="telefones"
        required
        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" />
      <input
        type="text"
        placeholder="Nome do Pai"
        name="nomePai"
        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" />
      <input
        type="text"
        placeholder="Nome da Mãe"
        name="nomeMae"
        required
        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" />

      <button
        type="submit"
        class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition">
        Cadastrar
      </button>
    </form>
  </div>
</body>

</html>