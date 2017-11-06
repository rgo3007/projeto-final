<?php
if (empty($login)) :
    header('Location: ../../painel.php');
    die;
endif;
?>
<div class="content form_create">

    <article>

        <?php extract($_SESSION['userlogin']); ?>

        <h1>Olá <?= "{$nome} {$sobrenome}"; ?>, atualize seu perfíl!</h1>

        <?php
        $UsuarioData = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $codigo= $_SESSION['userlogin']['codigo'];

        if ($UsuarioData && $UsuarioData['SendPostForm']):
            unset($UsuarioData['SendPostForm']);
            extract($UsuarioData);

            require('_models/AdminUser.class.php');
            $cadastra = new AdminUser;
            $cadastra->ExeUpdate($codigo, $UsuarioData);

            if ($cadastra->getResult()):
                WSErro("Seus dados foram atualizados com sucesso! <i>O sistema será atualizado no próximo login!!!</i>", SOS_ACCEPT);
            else:
                WSErro($cadastra->getError()[0], $cadastra->getError()[1]);
            endif;
        else:
            extract($_SESSION['userlogin']);
        endif;
        ?>

        <form action = "" method = "post" name = "UserEditForm">

            <label class="label">
                <span class="field">Nome:</span>
                <input
                    type = "text"
                    name = "nome"
                    value = "<?= $nome; ?>"
                    title = "Informe seu primeiro nome"
                    required
                    />
            </label>

            <label class="label">
                <span class="field">Sobrenome:</span>
                <input
                    type = "text"
                    name = "sobrenome"
                    value = "<?= $sobrenome; ?>"
                    title = "Informe seu sobrenome"
                    required
                    />
            </label>

            <label class="label">
                <span class="field">E-mail:</span>
                <input
                    type = "email"
                    name = "user_email"
                    value = "<?= $email; ?>"
                    title = "Informe seu e-mail"
                    required
                    />
            </label>

            <div class="label_line">

                <label class="label">
                    <span class="field">Senha:</span>
                    <input
                        style="width: 260px;"
                        type = "password"
                        name = "senha"
                        value = ""
                        title = "Informe sua senha [ de 6 a 12 caracteres! ]"
                        pattern = ".{6,12}"
                        />
                </label>                
            </div>

            <input type="submit" name="SendPostForm" value="Atualizar Perfil" class="btn blue" />

        </form>


    </article>

    <div class="clear"></div>
</div> <!-- content home -->