
<div class="main">
	<div class="main-inner">
		<div class="container">
			<div class="row">
				<div class="span12">
				<?php
				//excluir
				if(isset($_GET['delete'])){
					$id_delete = $_GET['delete'];

					//seleciona a imagem
					$select ="SELECT * FROM tb_postagens WHERE id=:id_delete";
					try{
						$result = $conexao->prepare($select);
						$result->bindParam('id_delete',$id_delete,PDO::PARAM_INT);
						$result->execute();
						$contar = $result->rowCount();
						if($contar>0){
							$loop =$result->fetchAll();
							foreach($loop as $exibir){
							}
							$fotoDeleta = $exibir['imagem'];
							$arquivo = "../upload/postagens/".$fotoDeleta;
							unlink($arquivo);


							//exclui o registro
							$select ="DELETE FROM tb_postagens WHERE id=:id_delete";
							try{
								$result = $conexao->prepare($select);
								$result->bindParam('id_delete',$id_delete,PDO::PARAM_INT);
								$result->execute();
								$contar = $result->rowCount();
								if($contar>0){
									echo '<div class="alert alert-sucess">
                      					 <button type="button" class="close" data-dismiss="alert">×</button>
                      					 <strong>post deletado!</strong> o post foi deletado.
                						 </div>';
								}else{
									echo '<div class="alert alert-danger">
                     				 <button type="button" class="close" data-dismiss="alert">×</button>
                     				 <strong>Erro ao deletar!</strong> Não foi possível deletar o post.
               						 </div>';

							}
						}catch (PDOException $erro){
								echo $erro;
							}



						}else{
							echo 'já excluiu ou nao existe';

						}

					}catch (PDOException $erro){
						echo $erro;
					}
				}
				?>
				</div>

				<div class="span12">
					<div class="widget widget-table action-table">
						<div class="widget-header"> <i class="icon-th-list"></i>
							<h3>Todos os post</h3>
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
								//paginação
								if(empty($_GET['pg'])){}
								else{
									$pg = $_GET['pg'];
									if(!is_numeric($pg)){
										echo'<script language="JavaScript">location.href="home.php?acao=ver-postagens";</script>';
									}

								}


								if(isset($pg)){$pg = $_GET['pg'];}else{$pg=1;}
								if(isset($_POST['palavra-busca'])){
									$quantidade = 10000;
								}else{
								$quantidade=10;
								}
								$inicio = ($pg*$quantidade) - $quantidade;
								if(isset($_POST['palavra-busca'])){
									$busca = addslashes($_POST['palavra-busca']);
									$select = "SELECT * FROM tb_postagens WHERE titulo LIKE '%$busca%' OR descricao LIKE '%$busca%' ORDER BY id DESC LIMIT $inicio,$quantidade";
								}else{
									//selecionando as postagem
									$select = "SELECT * from tb_postagens ORDER BY id DESC LIMIT $inicio,$quantidade";
								}

								$contagem =$inicio + 1;
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
												<td class="td-actions">
													<a href="home.php?acao=editar-postagem&id=<?php echo $mostra->id;?>" class="btn btn-small btn-success"><i class="btn-icon-only icon-edit"> </i></a>
													<a href="home.php?acao=ver-postagens&pg=<?php echo $pg?>&delete=<?php echo $mostra->id;?>" class="btn btn-danger btn-small" onClick="return confirm('Deseja realmente excluir?')"><i class="btn-icon-only icon-remove"> </i></a>
												</td>
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
						<!--inicio botoes paginacao -->

						<style>
						/*paginação*/
						.paginas{
						background: #FFFFFF;
						width: 100%;
						padding: 10px 0;
						text-align: center;
						height: auto;
						margin: 10px auto;
						}
						.paginas a{
						width: auto;
						padding: 4px 10px;
						background:#ccc;
						color: #333333;
						margin: 0px 2.5px;
						}
						.paginas a:hover{
						text-decoration: none;
						background: #00ba8b;
						color: #fff;
						}
						<?php
						if(isset($_GET['pg'])){
						$num_pg = $_GET['pg'];

						}else{
						$num_pg = 1;
						}

 						?>
						.paginas a.ativo<?php echo $num_pg ?>{
						background: #00ba8b;
						color: #fff;

						}
						</style>
						<?php
						//paginação
						if(isset($_POST['palavra-busca'])){
							$busca = addslashes($_POST['palavra-busca']);
							$sql = "SELECT * FROM tb_postagens WHERE titulo LIKE '%$busca%' OR descricao LIKE '%$busca%'";
						}else{

							$sql = "SELECT * FROM tb_postagens";
						}
						try{
						$result = $conexao->prepare($sql);
						$result->execute();
						$totalRegistros = $result->rowCount();
						}catch(PDOException $e){
							echo $e;
						}
						if($totalRegistros <= $quantidade){

						}else{
							$paginas = ceil($totalRegistros/$quantidade);
							if($pg>$paginas){
								echo'<script language="JavaScript">location.href="home.php?acao=ver-postagens";</script>';


							}
							$links = 5;

							if(isset($i)){

							}else{
								$i=1;
							}
						?>
							<div class="paginas">
								<a href="home.php?acao=ver-postagens&pg=1">Primeira Página</a>

								<?php

								if(isset($_GET['pg'])) {
									$num_pg = $_GET['pg'];
								}
								for($i= $pg - $links; $i<=$pg-1; $i++){
									if($i<=0){

									}else{
								?>


										<a href="home.php?acao=ver-postagens&pg=<?php echo $i; ?>" class="ativo<?php echo $i; ?>"><?php echo $i; ?></a>
								<?php
									}
								}
								?>
								<a href="home.php?acao=ver-postagens&pg=<?php echo $pg; ?>" class="ativo<?php echo $i; ?>"><?php echo $pg; ?></a>

								<?php
								for($i= $pg+1; $i<=$pg+$links; $i++){
									if($i>$paginas){


									}else{
								?>

										<a href="home.php?acao=ver-postagens&pg=<?php echo $i; ?>" class="ativo<?php echo $i; ?>"><?php echo $i; ?></a>

								<?php
									}
								}

								?>

								<a href="home.php?acao=ver-postagens&pg=<?php echo $paginas; ?>">Ultima página</a>
							</div><!-- paginação -->
						<?php
						   }
						?>

					</div>

					</div><!-- span 12 -->
				</div><!-- row -->
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

<script type="text/javascript" src="editor/nicEdit.js"></script>
<script type="text/javascript">
	bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
</script>