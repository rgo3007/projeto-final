<?php
if (empty($login)) :
    header('Location: ../../painel.php');
    die;
endif;
?>
<div class="content form_create">

    <article>

        <h1>Cadastrar Usuário!</h1>

        <?php
        $Usuario = filter_input_array(INPUT_POST, FILTER_DEFAULT);
  
        
/* @var $cod_tipo_usuario type */
$cod_tipo_usuario = filter_input_array(INPUT_POST,"cod_tipo_usuario") ;
        
        //var_dump($Usuario);
        //echo "to Aki";
        //exit;
        
        if ($Usuario && $Usuario['SendPostForm']):
            unset($Usuario['SendPostForm']);

            require('_models/AdminUser.class.php');
            
            $cadastra = new AdminUser;
            
            //$cadastra->ExeCreate($Usuario);
           
            $cadastra->ExeCreate("usuario",$Usuario);
            
           
           // $cod_tipo_usuario = implode(",", $cod_tipo_usuario);
            //var_dump($cod_tipo_usuario);
            
            $cod_usuario = $Create->getResult();//possui o ultimo id cadastrado
            
            foreach ($cod_tipo_usuario as $linha){
                //echo $linha;
                
                $Permissao = array("cod_usuario" => $cod_usuario, "cod_tipo_usuario" => $linha);
                $cadastra->ExeCreate("permissao", $Permissao);
            } 
            
            /*
            1 1
            1 4
            1 2
             */
            //exit;
            
            
           //$usuarioPermissao = array("cod_usuario"=>"", "cod_tipo_usuario"=>"");
            
            //$usuarioPermissao = ();
            
            
            
            //$cadastra->ExeCreate("permissao",$Usuario);
            
            if ($cadastra->getResult()):
                header("Location: painel.php?exe=usuario/update&create=true&codigo={$cadastra->getResult()}");
            else:
                SOSErro($cadastra->getError()[0], $cadastra->getError()[1]);
            endif;
        endif;
        ?>

        <form action = "" method = "post" name = "UserCreateForm">
            <label class="label">
                <span class="field">Nome:</span>
                <input
                    type = "text"
                    name = "nome"
                    value="<?php if (!empty($Usuario['nome'])) echo $Usuario['nome']; ?>"
                    title = "Informe seu primeiro nome"
                    required
                    />
            </label>

            <label class="label">
                <span class="field">Sobrenome:</span>
                <input
                    type = "text"
                    name = "sobrenome"
                    value="<?php if (!empty($Usuario['sobrenome'])) echo $Usuario['sobrenome']; ?>"
                    title = "Informe seu sobrenome"
                    required
                    />
            </label>

            <label class="label">
                <span class="field">E-mail:</span>
                <input
                    type = "email"
                    name = "email"
                    value="<?php if (!empty($Usuario['email'])) echo $Usuario['email']; ?>"
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
                        value="<?php if (!empty($Usuario['senha'])) echo $Usuario['senha']; ?>"
                        title = "Informe sua senha [ de 6 a 12 caracteres! ]"
                        pattern = ".{6,12}"
                        required
                        />
                </label>


                <label class="label_medium">
                    <span class="field">Nível:</span>
                    <?php
                    $read = new Read;
                    $read->ExeRead("tipo_usuario", "ORDER BY descricao ASC");
                    //$teste = $read->getResult();
                    //print_r($teste);
                    //exit;
                    if ($read->getResult()):
                        ?>
                        <select  multiple name = "cod_tipo_usuario[]" title = "Selecione o nível de usuário" required >
                            <?php
                            foreach ($read->getResult() as $valor):
                                ?>
                                <option value = "<?php echo $valor ["codigo"] ?> "> <?php echo $valor ["descricao"] ?> </option>                                     
                                <?php
                            endforeach;
                            ?>
                        </select>                     
                        <?php
                    endif;
                    ?>
                </label>

                    <input type="submit" name="SendPostForm" value="Cadastrar Usuário" class="btn green" />
                    </form>

                    </article>
                    <div class="clear"></div>
            </div> <!-- content home -->
            