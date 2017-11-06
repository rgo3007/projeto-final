<?php

/**
 * AdminUser.class [ MODEL ADMIN ]
 * Respnsável por gerenciar os usuários no Admin do sistema!
 */
class AdminUser {

    private $Data;
    private $User;
    private $Error;
    private $Result;

    //Nome da tabela no banco de dados
    const Entity = 'usuario';
   

    /**
     * <b>Cadastrar Usuário:</b> Envelope os dados de um usuário em um array atribuitivo e execute esse método
     * para cadastrar o mesmo no sistema. Validações serão feitas!
     * @param ARRAY $Data = Atribuitivo
     */
    public function ExeCreate(array $Data) {
        $this->Data = $Data;
        $this->checkData();

        if ($this->Result):
            $this->Create();
        endif;
    }

    /**
     * <b>Atualizar Usuário:</b> Envelope os dados em uma array atribuitivo e informe o id de um
     * usuário para atualiza-lo no sistema!
     * @param INT $Codigo = Id do usuário
     * @param ARRAY $Data = Atribuitivo
     */
    public function ExeUpdate($Codigo, array $Data) {
        $this->User = (int) $Codigo;
        $this->Data = $Data;

        if (!$this->Data ['senha']):
            unset($this->Data['senha']);
        endif;

        $this->checkData();

        if ($this->Result):
            $this->Update();
        endif;
    }

    /**
     * <b>Remover Usuário:</b> Informe o ID do usuário que deseja remover. Este método não permite deletar
     * o próprio perfil ou ainda remover todos os ADMIN'S do sistema!
     * @param INT $UserId = Id do usuário
     */
    public function ExeDelete($Codigo) {
        $this->User = (int) $Codigo;

        $readUser = new Read;
        $readUser->ExeRead(self::Entity, "WHERE codigo = :id", "id={$this->User}");

        if (!$readUser->getResult()):
            $this->Error = ['Oppsss, você tentou remover um usuário que não existe no sistema!',SOS_ERROR];
            $this->Result = false;
        elseif ($this->User == $_SESSION['userlogin']['codigo']):
            $this->Error = ['Oppsss, você tentou remover seu usuário. Essa ação não é permitida!!!',SOS_INFOR];
            $this->Result = false;
        else:
            if ($readUser->getResult()[0]['cod_tipo_usuario'] == 3):

                $readAdmin = $readUser;
                $readAdmin->ExeRead(self::Entity, "WHERE codigo != :id AND cod_tipo_usuario = :lv", "id={$this->User}&lv=4");

                if (!$readAdmin->getRowCount()):
                    $this->Error = ['Oppsss, você está tentando remover o único ADMIN do sistema. Para remover cadastre outro antes!!!',SOS_ERROR];
                    $this->Result = false;
                else:
                    $this->Delete();
                endif;

            else:
                $this->Delete();
            endif;

        endif;
    }

    /**
     * <b>Verificar Cadastro:</b> Retorna TRUE se o cadastro ou update for efetuado ou FALSE se não.
     * Para verificar erros execute um getError();
     * @return BOOL $Var = True or False
     */
    public function getResult() {
        return $this->Result;
    }

    /**
     * <b>Obter Erro:</b> Retorna um array associativo com um erro e um tipo.
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

    //Verifica os dados digitados no formulário
    private function checkData() {
        if (in_array('', $this->Data)):
            $this->Error = ["Existem campos em branco. Favor preencha todos os campos!",SOS_ALERT];
            $this->Result = false;
        elseif (!Check::Email($this->Data['email'])):
            $this->Error = ["O e-email informado não parece ter um formato válido!",SOS_ALERT];
            $this->Result = false;
        elseif (isset($this->Data['senha']) && (strlen($this->Data['senha']) < 6 || strlen($this->Data['senha']) > 12)):
            $this->Error = ["A senha deve ter entre 6 e 12 caracteres!",SOS_INFOR];
            $this->Result = false;
        else:
            $this->checkEmail();
        endif;
    }

    //Verifica usuário pelo e-mail, Impede cadastro duplicado!
    private function checkEmail() {
        $Where = ( isset($this->User) ? "codigo != {$this->User} AND" : '');

        $readUser = new Read;
        $readUser->ExeRead(self::Entity, "WHERE {$Where} email= :email", "email={$this->Data['email']}");

        if ($readUser->getRowCount()):
            $this->Error = ["O e-mail informado foi cadastrado no sistema por outro usuário! Informe outro e-mail!",SOS_ERROR];
            $this->Result = false;
        else:
            $this->Result = true;
        endif;
    }

    //Cadasrtra Usuário!
    private function Create() {
        $Create = new Create;
        $this->Data['data_registro'] = date('Y-m-d H:i:s');
        $this->Data['senha'] = md5($this->Data['senha']);

       // $Create->ExeCreate(self::Entity, $this->Data);
        
        $Create->ExeCreate($this->tabela, $this->Data);

        if ($Create->getResult()):
            $this->Error = ["O usuário <b>{$this->Data['nome']}</b> foi cadastrado com sucesso no sistema!",SOS_ACCEPT];
            $this->Result = $Create->getResult();
        endif;
    }

    //Atualiza Usuário!
    private function Update() {
        $Update = new Update;
        if (isset($this->Data['senha'])):
            $this->Data['senha'] = md5($this->Data['senha']);
        endif;

        $Update->ExeUpdate(self::Entity, $this->Data, "WHERE codigo = :id", "id={$this->User}");
        if ($Update->getResult()):
            $this->Error = ["O usuário <b>{$this->Data['nome']}</b> foi atualizado com sucesso!",SOS_ACCEPT];
            $this->Result = true;
        endif;
    }

    //Remove Usuário
    private function Delete() {
        $Delete = new Delete;
        $Delete->ExeDelete(self::Entity, "WHERE codigo = :id", "id={$this->User}");
        if ($Delete->getResult()):
            $this->Error = ["Usuário removido com sucesso do sistema!",SOS_ACCEPT];
            $this->Result = true;
        endif;
    }

}
