<div class="main">
    <div class="main-inner">
        <div class="container">
            <div class="row">

                <div class="span12">
                    <?php
                    //sumir com o bem vindo quando clicar em outra coisa
                    if(isset($_GET['acao'])){
                        if(!isset($_POST['logar'])){
                            $acao = $_GET['acao'];
                            if($acao=='welcome'){
                                echo '<div class="alert alert-info">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>OLÁ ADMINISTRADOR!</strong> Seja bem vindo.
              </div>';
                            }
                        }
                    }
                    ?>

                </div>
                <div class="span12">
                    <div id="target-1" class="widget">
                        <div class="widget-content">
                            <h1>JEYZIEL</h1>
                            <p>O <strong>WVA System</strong> é um Sistema de Postagem desenvolvido pelo canal '<strong>Web Vídeo Aulas</strong>', cujo objetivo é gerenciar toda parte de postagens e
                                algumas funções internas do próprio sistema.	<br>
                                O Sistema foi desenvolvido na linguagem <strong>PHP</strong>, utilizando juntamente com a classe <strong>PDO</strong>. O banco de dados utilizado é o famoso <strong>MySQL</strong>.</p>

                            <p>O desenvolvimento desse Sistema tem como objetivo, ensinar aos apaixonados por <strong>Web Design</strong>, ensinar uma maneira de desenvolver
                                um sistema p/ gerenciamento de dados, seja ele para um site instituicional, portal de notícias, loja virtual, etc.</p>

                            <p>Espero que todos tenha um ótimo aprendizado, que vocês usem os conceitos aprendidos nesse projeto p/ aplicações em outros.</p>
                            <p><strong>Forte abraço, e até a próxima!</strong></p>
                        </div> <!-- /widget-content -->
                    </div> <!-- /widget -->
                </div><!-- span 12 -->
            </div><!-- row -->
            <div class="widget widget-table action-table">
                <div class="widget-header"> <i class="icon-th-list"></i>
                    <h3>Últimos Posts</h3>
                </div>
                <!-- /widget-header -->
                <div class="widget-content">
                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>Nº</th>
                            <th> Título da Postagem </th>
                            <th> DATA</th>
                            <th> IMAGEM</th>
                            <th> EXIBIÇÃO</th>
                            <th> RESUMO</th>
                            <th class="td-actions"> </th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php
                        include ("functions/limita-texto.php");
                        //selecionando as postagem
                        $select = "SELECT * from tb_postagens ORDER BY id DESC LIMIT 5";
                        $contagem =1;
                        try{
                        $result = $conexao->prepare($select);
                        $result->execute();
                        $contar = $result->rowCount();
                        if($contar>0){
                            while($mostra = $result->fetch(PDO::FETCH_OBJ)){
                        ?>
                        <!-- html-->
                                <tr>
                                    <td><?php echo $contagem++; ?></td>
                                    <td> <?php echo $mostra->titulo  ?> </td>
                                    <td> <?php echo $mostra->data  ?> </td>
                                    <td><img src="../upload/postagens/<?php echo $mostra->imagem;?>" width="50"/></td>
                                    <td> <?php echo $mostra->exibir ?> </td>
                                    <td> <?php echo limitarTexto($mostra->descricao,$limite=200)  ?> </td>
                                    <td class="td-actions"><a href="home.php?acao=editar-postagem&id=<?php echo $mostra->id;?>" class="btn btn-small btn-success"><i class="btn-icon-only icon-edit"> </i></a><a href="javascript:;" class="btn btn-danger btn-small"><i class="btn-icon-only icon-remove"> </i></a></td>
                                </tr>
                        <!-- html-->

                        <?php
                            }

                        }else{
                        echo '<div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>Aviso!</strong> Não há Post cadastrado.
                        </div>';
                        }

                        }catch(PDOException $e){
                        echo $e;
                        }
                        ?>

                        </tbody>
                    </table>
                </div>
                <!-- /widget-content -->
            </div>
            <!-- /widget -->
        </div>
        <!-- /span6 -->
    </div>
    <!-- /row -->
</div>
<!-- /container -->
</div>
<!-- /main-inner -->
</div>
<!-- /main -->
