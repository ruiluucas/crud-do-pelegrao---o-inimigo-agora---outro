<?php
require_once('./app/models/cursoModel.php');
require_once('./app/models/estudanteModel.php');

use \MongoDB\BSON\ObjectId;

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $cursoModel = new CursoModel();
    $cursoModel->subscribeCurso($_GET['id'], $_SESSION['id']);
}

$curso_id = $_GET['id'];

$cursoModel = new CursoModel();
$estudanteModel = new EstudanteModel();

$curso = $cursoModel->getCursoById($curso_id);
$estudantes = json_decode($estudanteModel->getEstudantesByCursoId($curso_id));
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Curso: <?php echo htmlspecialchars($curso['nome']); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body
    class="bg-neutral-900 flex flex-col min-h-screen items-center py-10">
    <div class="w-full mx-auto max-w-3xl bg-white rounded-lg shadow-md p-8">
        <div class="mb-6">
            <a href="index.php" class="text-blue-500 hover:underline">&larr; Voltar para a lista de cursos</a>
        </div>
        <div class="mb-8 border-b pb-6">
            <div class="flex flex-row justify-between">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">
                    <?php echo htmlspecialchars($curso['nome']); ?>
                </h1>
                <form method="post">
                    <?php
                    $usuarioLogado = false;
                    $usuarioJaNosCurso = false;
                    if (!empty($_SESSION['id'])) {
                        $usuarioLogado = true;
                    }

                    if ($usuarioLogado) {

                        if (!empty($estudantes) && is_array($estudantes)) {
                            foreach ($estudantes as $estudante) {
                                $estudanteId = $estudante->_id->{'$oid'};
                                $sessionId = json_decode(json_encode($_SESSION['id']))->{'$oid'};

                                if ($estudanteId === $sessionId) {
                                    $usuarioJaNosCurso = true;
                                    break;
                                }
                            }
                        }
                    }
                    ?>
                    <?php if (!$usuarioLogado): ?>
                        <a href="/cadastrarEstudante.php" class="underline text-green-600 font-bold p-2 px-4">Clique aqui e inscreva-se para entrar no curso</a>
                    <?php endif; ?>

                    <?php if ($usuarioJaNosCurso && $usuarioLogado): ?>
                        <span class="text-green-600 font-bold p-2 px-4">✓ Você já está no curso</span>
                    <?php elseif (!$usuarioJaNosCurso && $usuarioLogado): ?>
                        <button type="submit" class="bg-blue-500 text-white font-bold p-2 px-4 rounded-md">Entrar</button>
                    <?php endif; ?>
                </form>
            </div>
            <p class="text-lg text-gray-600 mb-4">
                <?php echo htmlspecialchars($curso['descricao']); ?>
            </p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-gray-100 p-4 rounded-lg">
                    <span class="text-sm font-semibold text-gray-500 block">Preço</span>
                    <span class="text-xl font-bold text-gray-900">
                        R$ <?php echo number_format($curso['preco'], 2, ',', '.'); ?>
                    </span>
                </div>
                <div class="bg-gray-100 p-4 rounded-lg">
                    <span class="text-sm font-semibold text-gray-500 block">Carga Horária</span>
                    <span class="text-xl font-bold text-gray-900">
                        <?php echo htmlspecialchars($curso['carga_horaria']); ?> horas
                    </span>
                </div>
                <div class="bg-gray-100 p-4 rounded-lg">
                    <span class="text-sm font-semibold text-gray-500 block">Nível</span>
                    <span class="text-xl font-bold text-gray-900">
                        <?php echo htmlspecialchars($curso['nivel']); ?>
                    </span>
                </div>
            </div>
        </div>
        <div>
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">
                Estudantes Matriculados
            </h2>
            <?php if (!empty($estudantes) && is_array($estudantes)): ?>
                <ul class="space-y-3">
                    <?php foreach ($estudantes as $estudante): ?>
                        <li class="flex items-center bg-gray-50 p-3 rounded-lg shadow-sm">
                            <div class="ml-3">
                                <p class="text-md font-medium text-gray-900">
                                    <?php echo ($estudante->nome); ?>
                                </p>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p class="text-center text-gray-500">
                    Nenhum estudante matriculado neste curso ainda.
                </p>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>