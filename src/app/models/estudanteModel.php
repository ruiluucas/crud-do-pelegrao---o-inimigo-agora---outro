<?php
require_once dirname(__FILE__) . '/../database.php';

class EstudanteModel extends Database
{
    private $collectionName = "estudantes";

    public function createEstudante($nome, $rg, $cpf, $dataNascimento, $telefones, $nomePai, $nomeMae)
    {
        return $this->insert($this->collectionName, [
            'nome' => $nome,
            'rg' => $rg,
            'cpf' => $cpf,
            'data_nascimento' => $dataNascimento,
            'telefones' => is_array($telefones) ? json_encode($telefones) : $telefones,
            'nome_pai' => $nomePai,
            'nome_mae' => $nomeMae,
        ]);
    }

    public function getEstudantesByCursoId($cursoId)
    {
        $pipeline = [
            ['$match' => ['_id' => $this->toObjectId($cursoId)]],
            ['$lookup' => [
                'from' => 'estudantes',
                'localField' => 'estudantes_id',
                'foreignField' => '_id',
                'as' => 'estudantes'
            ]]
        ];
        $cursosComDetalhes = $this->selectCollection("cursos")->aggregate($pipeline);
        return json_encode($cursosComDetalhes->toArray()[0]['estudantes']);
    }

    public function getAllEstudantes()
    {
        return $this->find($this->collectionName);
    }

    public function getEstudanteById($estudanteId)
    {
        return $this->findOne($this->collectionName, ['_id' => $this->toObjectId($estudanteId)]);
    }

    public function updateEstudante($id, $email = null, $senha = null)
    {
        return;
    }

    public function deleteEstudante($estudanteId)
    {
        return $this->delete($this->collectionName, ['_id' => $this->toObjectId($estudanteId)]);
    }
}
