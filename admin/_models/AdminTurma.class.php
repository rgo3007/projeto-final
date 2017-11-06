<?php

/**
 * AdminCategory.class [ MODEL ADMIN ]
 * Responável por gerenciar as turmas do sistema no admin!

 */
class AdminCategory {

    private $Data;
    private $TurmaId;
    private $Error;
    private $Result;

    //Nome da tabela no banco de dados!
    const Entity = 'turma';

    /**
     * <b>Cadastrar Turma:</b> Envelope titulo, descrição, data e sessão em um array atribuitivo e execute esse método
     * para cadastrar a turma. Case seja uma sessão, envie o category_parent como STRING null.
     * @param ARRAY $Data = Atribuitivo
     */
    public function ExeCreate(array $Data) {
        $this->Data = $Data;

        if (in_array('', $this->Data)):
            $this->Result = false;
            $this->Error = ['<b>Erro ao cadastrar:</b> Para cadastrar uma turma, preencha todos os campos!', SOS_ALERT];
        else:
            $this->setData();
            $this->setName();
            $this->Create();
        endif;
    }

    /**
     * <b>Atualizar Turma:</b> Envelope os dados em uma array atribuitivo e informe o id de uma
     * turma para atualiza-la!
     * @param INT $Codigo = Id da turma
     * @param ARRAY $Data = Atribuitivo
     */
    public function ExeUpdate($Codigo, array $Data) {
        $this->TurmaId = (int) $Codigo;
        $this->Data = $Data;

        if (in_array('', $this->Data)):
            $this->Result = false;
            $this->Error = ["<b>Erro ao atualizar:</b> Para atualizar a turma {$this->Data['descricao']}, preencha todos os campos!", SOS_ALERT];
        else:
            $this->setData();
            $this->setName();
            $this->Update();
        endif;
    }

    /**
     * <b>Deleta turma:</b> Informe o ID de uma turma para remove-la do sistema. Esse método verifica
     * o tipo de turma e se é permitido excluir de acordo com os registros do sistema!
     * @param INT $Codigo = Id da turma
     */
   public function ExeDelete($TurmaId) {
        $this->CatId = (int) $TurmaId;

        $read = new Read;
        $read->ExeRead(self::Entity, "WHERE codigo = :delid", "delid={$this->TurmaIdId}");

        if (!$read->getResult()):
            $this->Result = false;
            $this->Error = ['Oppsss, você tentou remover uma categoria que não existe no sistema!', SOS_INFOR];
        else:
            extract($read->getResult()[0]);
            if (!$cod_curso && !$this->checkTurma()):
                $this->Result = false;
                $this->Error = ["A <b>seção {$descricao}</b> possui categorias cadastradas. Para deletar, antes altere ou remova os cursos!", SOS_ALERT];
            elseif ($cod_curso && !$this->checkCursos()):
                $this->Result = false;
                $this->Error = ["A <b>categoria {$descricao}</b> possui cursos cadastrados. Para deletar, antes altere ou remova todos os curso desta turma!", SOS_ALERT];
            else:
                $delete = new Delete;
                $delete->ExeDelete(self::Entity, "WHERE codigo = :deletaid", "deletaid={$this->TurmaIdId}");

                $tipo = ( empty($cod_curso) ? 'seção' : 'turma' );
                $this->Result = true;
                $this->Error = ["A <b>{$tipo} {$descricao}</b> foi removida com sucesso do sistema!", SOS_ACCEPT];
            endif;
        endif;
    }

    /**
     * <b>Verificar Cadastro:</b> Retorna TRUE se o cadastro ou update for efetuado ou FALSE se não. Para verificar
     * erros execute um getError();
     * @return BOOL $Var = True or False
     */
    public function getResult() {
        return $this->Result;
    }

    /**
     * <b>Obter Erro:</b> Retorna um array associativo com a mensagem e o tipo de erro!
     * @return ARRAY $Error = Array associatico com o erro
     */
    public function getError() {
        return $this->Error;
    }

    /*
     * ***************************************
     * **********  PRIVATE METHODS  **********
     * ***************************************
     */

    //Valida e cria os dados para realizar o cadastro
    private function setData() {
        $this->Data = array_map('strip_tags', $this->Data);
        $this->Data = array_map('trim', $this->Data);
        $this->Data['category_name'] = Check::Name($this->Data['category_title']);
        $this->Data['category_date'] = Check::Data($this->Data['category_date']);
        $this->Data['category_parent'] = ($this->Data['category_parent'] == 'null' ? null : $this->Data['category_parent']);
    }

    //Verifica o NAME da turma. Se existir adiciona um pós-fix +1
    private function setName() {
        $Where = (!empty($this->TurmaId) ? "codigo != {$this->TurmaId} AND" : '' );

        $readName = new Read;
        $readName->ExeRead(self::Entity, "WHERE {$Where} desci = :t", "t={$this->Data['category_title']}");
        if ($readName->getResult()):
            $this->Data['descricao'] = $this->Data['descricao'] . '-' . $readName->getRowCount();
        endif;
    }

    //Verifica turmas da seção
    private function checkTurma() {
        $readSes = new Read;
        $readSes->ExeRead(self::Entity, "WHERE cod_curso = :cursorel", "cursorel={$this->TurmaId}");
        if ($readSes->getResult()):
            return false;
        else:
            return true;
        endif;
    }

    //Verifica artigos da turma
    private function checkCursos() {
        $readCursos = new Read;
        $readCursos->ExeRead("curso", "WHERE cod_curso = :turma", "turma={$this->TurmaId}");
        if ($readCursos->getResult()):
            return false;
        else:
            return true;
        endif;
    }

    //Cadastra a turma no banco!
    private function Create() {
        $Create = new Create;
        $Create->ExeCreate(self::Entity, $this->Data);
        if ($Create->getResult()):
            $this->Result = $Create->getResult();
            $this->Error = ["<b>Sucesso:</b> A turma {$this->Data['descricao']} foi cadastrada no sistema!", SOS_ACCEPT];
        endif;
    }

    //Atualiza Turma
    private function Update() {
        $Update = new Update;
        $Update->ExeUpdate(self::Entity, $this->Data, "WHERE codigo = :turmaid", "turmaid={$this->TurmaId}");
        if ($Update->getResult()):
            $tipo = ( empty($this->Data['cod_curso']) ? 'seção' : 'turma' );
            $this->Result = true;
            $this->Error = ["<b>Sucesso:</b> A {$tipo} {$this->Data['descricao']} foi atualizada no sistema!", SOS_ACCEPT];
        endif;
    }

}
