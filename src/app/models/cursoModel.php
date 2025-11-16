<?php
require_once dirname(__FILE__) . '/../database.php';

class CursoModel extends Database
{
    private $collectionName = "cursos";

    public function createCurso($nome, $descricao, $cargaHoraria, $preco, $nivel)
    {
        return $this->insert($this->collectionName, [
            'nome' => $nome,
            'descricao' => $descricao,
            'carga_horaria' => (int) $cargaHoraria,
            'preco' => is_numeric($preco) ? (float) $preco : $preco,
            'nivel' => $nivel,
        ]);
    }

    public function subscribeCurso($cursoId, $estudanteId)
    {
        return $this->update(
            $this->collectionName,
            ['_id' => $this->toObjectId($cursoId)],
            ['$addToSet' => [
                'estudantes_id' => $estudanteId
            ]]
        );
    }

    public function getAllCursos()
    {
        return $this->find($this->collectionName);
    }

    public function getCursoById($cursoId)
    {
        return $this->findOne($this->collectionName, ['_id' => $this->toObjectId($cursoId)]);
    }

    public function updateCurso($id, $email = null, $senha = null)
    {
        return;
    }

    public function deleteCurso($cursoId)
    {
        return $this->delete($this->collectionName, ['_id' => $this->toObjectId($cursoId)]);
    }
}
