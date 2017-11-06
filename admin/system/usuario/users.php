<?php
if (empty($login)) :
    header('Location: ../../painel.php');
    die;
endif;
?>
<div class="content form_create">

    <article>

        <h1>Usuários: <a href="painel.php?exe=usuario/create" title="Cadastrar Novo" class="user_cad">Cadastrar Usuário</a></h1>

        <?php
        $delete = filter_input(INPUT_GET, 'delete', FILTER_VALIDATE_INT);
        if ($delete):
            require('_models/AdminUser.class.php');
            $delUser = new AdminUser;
            $delUser->ExeDelete($delete);
            SOSErro($delUser->getError()[0], $delUser->getError()[1]);
        endif;
        ?>

        <ul class="ultable">
            <li class="t_title">
                <span class="ui center">Res:</span>
                <span class="un">Nome:</span>
                <span class="ue">E-mail:</span>
                <span class="ur center">Registro:</span>
                <span class="ua center">Atualização:</span>
                <span class="ul center">Nível:</span>
                <span class="ed center">-</span>
            </li>

            <?php
            $read = new Read;
            $read->ExeRead("usuario", "ORDER BY cod_tipo_usuario DESC, nome ASC");
            if ($read->getResult()):
                foreach ($read->getResult() as $usuario):
                    extract($usuario);
                    $data_atualizacao = ($data_atualizacao ? date('d/m/Y H:i', strtotime($data_atualizacao)) . ' hs' : '-');
                    $nivel = ['', 'Aluno', 'Professor', 'Coordenador', 'Administrador'];
                    ?>            
                    <li>
                        <span class="ui center"><?= $codigo ?></span>
                        <span class="un"><?= $nome . ' ' . $sobrenome; ?></span>
                        <span class="ue"><?= $email; ?></span>
                        <span class="ur center"><?= date('d/m/Y', strtotime($data_registro)); ?></span>
                        <span class="ua center"><?= $data_atualizacao; ?></span>
                        <span class="ul center"><?= $nivel[$cod_tipo_usuario]; ?></span>
                        <span class="ed center">
                            <a href="painel.php?exe=usuario/update&codigo=<?= $codigo; ?>" title="Editar" class="action user_edit">Editar</a>
                            <a href="painel.php?exe=usuario/users&delete=<?= $codigo; ?>" title="Deletar" class="action user_dele">Deletar</a>
                        </span>
                    </li>
                    <?php
                endforeach;
            endif;
            ?>

        </ul>


    </article>

    <div class="clear"></div>
</div> <!-- content home -->