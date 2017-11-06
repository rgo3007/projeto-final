<?php
if (empty($login)) :
    header('Location: ../../painel.php');
    die;
endif;
?>
<div class="content form_create">

    <article>

        <h1>Cadastrar Turma</h1>

        <?php
        $Turma = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if ($Turma && $Us['SendPostForm']):
            unset($Turma['SendPostForm']);

            require('_models/AdminTurma.class.php');
            $cadastra = new AdminTurma;
            $cadastra->ExeCreate($Turma);

            if ($cadastra->getResult()):
                header("Location: painel.php?exe=turma/update&create=true&codigo={$cadastra->getResult()}");
            else:
                SOSErro($cadastra->getError()[0], $cadastra->getError()[1]);
            endif;
        endif;
        ?>

        <form action = "" method = "post" name = "UserCreateForm">
            <label class="label">
                <span class="field">Nome da turma:</span>
                <input
                    type = "text"
                    name = "descricao"
                    value="<?php if (!empty($Turma['descricao'])) echo $Turma['descricao']; ?>"
                    title = "Informe o nome da Turma"
                    required
                    />
            </label>

            <label class="label">
                <span class="field">Informe o Curso</span>
                <input
                    type = "text"
                    name = "Curso"
                    value="<?php if (!empty($Turma['cod_curso'])) echo $Turma['cod_curso']; ?>"
                    title = "Informe o curso"
                    required
                    />
            </label>

            <label class="label">
                <span class="field">data</span>
                <input
                    type = "date"
                    name = "data_turma"
                    value="<?php if (!empty($Turma['data_turma'])) echo $Turma['data_turma']; ?>"
                    title = "Informe data turma"
                    required
                    />
            </label>


            <label class="label">
                <span class="field">Periodo</span>
                <select name="cod_periodo">
                    <option value="1">matutino</option>
                    <option value="2">vespertino</option>
                    <option value="3">noturno</option>
                </select>
            </label>


            <label class="label">

                <span class="field">Série</span>
                <select name="cod_serie">
                    <option value="1">1ª Série</option>
                    <option value="2">2ª Série</option>
                    <option value="3">3ª Série</option>
                </select>
            </label>





            </div><!-- LABEL LINE -->

            <input type="submit" name="SendPostForm" value="Cadastrar Turma" class="btn green" />
        </form>

    </article>
    <div class="clear"></div>
</div> <!-- content home -->