<?php
if (empty($login)) :
    header('Location: ../../painel.php');
    die;
endif;
?>
<div class="content form_create">

    <article>

        <h1>Atualizar Usuário!</h1>

        <?php
        $UsuarioData = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $codigo = filter_input(INPUT_GET, 'codigo', FILTER_VALIDATE_INT);

        if ($UsuarioData && $UsuarioData['SendPostForm']):
            unset($UsuarioData['SendPostForm']);

            require('_models/AdminUser.class.php');
            $cadastra = new AdminUser;
            $cadastra->ExeUpdate($codigo, $UsuarioData);

            SOSErro($cadastra->getError()[0], $cadastra->getError()[1]);
        else:
            $ReadUser = new Read;
            $ReadUser->ExeRead("usuario", "WHERE codigo = :codigo", "codigo={$codigo}");
            if (!$ReadUser->getResult()):

            else:
                $UsuarioData = $ReadUser->getResult()[0];
                unset($UsuarioData['senha']);
            endif;
        endif;

        $checkCreate = filter_input(INPUT_GET, 'create', FILTER_VALIDATE_BOOLEAN);
        if ($checkCreate && empty($cadastra)):
            SOSErro("O usuário <b>{$UsuarioData['nome']}</b> foi cadastrado com sucesso no sistema!", SOS_ACCEPT);
        endif;
        ?>

        <form action = "" method = "post" name = "UserCreateForm">
            <label class="label">
                <span class="field">Nome:</span>
                <input
                    type = "text"
                    name = "nome"
                    value="<?php if (!empty($UsuarioData['nome'])) echo $UsuarioData['nome']; ?>"
                    title = "Informe seu primeiro nome"
                    required
                    />
            </label>

            <label class="label">
                <span class="field">Sobrenome:</span>
                <input
                    type = "text"
                    name = "sobrenome"
                    value="<?php if (!empty($UsuarioData['sobrenome'])) echo $UsuarioData['sobrenome']; ?>"
                    title = "Informe seu sobrenome"
                    required
                    />
            </label>

            <label class="label">
                <span class="field">E-mail:</span>
                <input
                    type = "email"
                    name = "email"
                    value="<?php if (!empty($UsuarioData['email'])) echo $UsuarioData['email']; ?>"
                    title = "Informe seu e-mail"
                    required
                    />
            </label>

            <div class="label_line">
                <label class="label_medium">
                    <span class="field">Senha:</span>
                    <input
                        type = "password"
                        name = "senha"
                        value="<?php if (!empty($UsuarioData['senha'])) echo $UsuarioData['senha']; ?>"
                        title = "Informe sua senha [ de 6 a 12 caracteres! ]"
                        pattern = ".{6,12}"
                        />
                </label>


                <label class="label_medium">
                    <span class="field">Nível:</span>
                    <select name = "cod_tipo_usuario" title = "Selecione o nível de usuário" required >
                        <option value = "">Selecione o Nível</option>
                        <option value = "1" <?php if (isset($UsuarioData['cod_tipo_usuario']) && $UsuarioData['cod_tipo_usuario'] == 1) echo 'selected="selected"'; ?>>Aluno</option>
                        <option value="2" <?php if (isset($UsuarioData['cod_tipo_usuario']) && $UsuarioData['cod_tipo_usuario'] == 2) echo 'selected="selected"'; ?>>Professor</option>
                        <option value="3" <?php if (isset($UsuarioData['cod_tipo_usuario']) && $UsuarioData['cod_tipo_usuario'] == 3) echo 'selected="selected"'; ?>>Coordenador</option>
                        <option value="3" <?php if (isset($UsuarioData['cod_tipo_usuario']) && $UsuarioData['cod_tipo_usuario'] == 4) echo 'selected="selected"'; ?>>Administrador</option>
                    </select>
                </label>
            </div><!-- LABEL LINE -->

            <input type="submit" name="SendPostForm" value="Atualizar Usuário" class="btn blue" />
        </form>

    </article>
    <div class="clear"></div>
</div> <!-- content home -->