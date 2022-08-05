<?php
use function TPPA\CORE\basic\pr;
$value = $this->data['value'];
$update = @$this->data['update'];
pr($value);
pr($update);

?>

<!-- Collapsable Card  -->
<div class="card shadow mb-1">
    <!-- Card Header - Accordion -->
    <a href="#collapseCardPregaoHead" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardPregaoHead">
        <h6 class="m-0 font-weight-bold text-primary"><?= $value['nome']; ?></h6>
    </a>
    <!-- Card Content - Collapse -->
    <div class="collapse" id="collapseCardPregaoHead">
        <div class="card-body">
            <div class="text-xs text-primary text-uppercase mb-1">OBJETO</div>
            <?= $value['objeto'] ?>
            <div class="text-xs text-primary text-uppercase mb-1">PROJETO</div>
            <?= $value['projeto'] ?>
            <div class="text-xs text-primary text-uppercase mb-1">JUSTIFICATIVA</div>
            <?= $value['justificativa_necessidade'] ?>
            <div class="text-xs text-primary text-uppercase mb-1">INTEGRANTES</div>
            TECNICO: <?= $value['integrante_tecnico'] ?> / REQUISITANTE: <?= $value['integrante_requisitante'] ?> 
        </div>    
    </div>    
</div>


<div class="card">
    <form action="<?= $this->action("necessidade", "save_item"); ?>" method="post">
        <input type="hidden" id="necessidade_id" name="necessidade_id" value="<?= $value['_id'] ?>">
        <div class="card-header">
            <button type="submit" class="btn btn-success btn-icon-split btn-sm" value="Enviar">
                <span class="icon text-white-50">
                    <i class="fas fa-check"></i>
                </span>
                <span class="text">Salvar</span>
            </button>
            <?php if($update['cod_item'] <= 0) : ?><span>Novo Item</span><?php else: ?><span>ATUALIZAR CODIGO: <?=$update['cod_item']?></span><?php endif; ?>
            <input type="hidden" id="cod_item" name="cod_item" value="<?= $update['cod_item'] ?>">
            
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-4">
                    <div class="form-group">
                        <label for="nome">Nome:</label>
                        <input type="text" id="nome" name="nome" class="form-control" aria-describedby="nomeHelp" value="<?= $update['nome'] ?>">
                        <small id="nomeHelp" class="form-text text-muted">Nome Resumido</small>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="requisicaoMinima">Qtd. Min.:</label>
                        <input type="number" id="requisicaoMinima" name="requisicao_minima" class="form-control" aria-describedby="requisicaoMinimaHelp" value="<?= $update['requisicao_minima'] ?>">
                        <small id="requisicaoMinimaHelp" class="form-text text-muted">Requisição Mínima.</small>
                    </div>
                </div>        
                <div class="col">
                    <div class="form-group">
                        <label for="requisicaoMaxima">Qtd. Max.:</label>
                        <input type="number" id="requisicaoMaxima" name="requisicao_maxima" class="form-control" aria-describedby="requisicaoMaximaHelp" value="<?= $update['requisicao_maxima'] ?>">
                        <small id="requisicaoMaximaHelp" class="form-text text-muted">Requisição Máxima.</small>
                    </div>
                </div>       
                <div class="col">
                    <div class="form-group">
                        <label for="valorMedio">Valor Médio:</label>
                        <input type="text" id="valorMedio" name="valor_medio" class="form-control" aria-describedby="valorMedioHelp" value="<?= $update['valor_medio'] ?>">
                        <small id="valorMedioHelp" class="form-text text-muted">Aproximado.</small>
                    </div>
                </div>        
                <div class="col">
                    <div class="form-group">
                        <label for="numeroCatalogo">CATMAT/CATSER:</label>
                        <input type="text" id="numeroCatalogo" name="numero_catalogo" class="form-control" aria-describedby="numeroCatalogoHelp" value="<?= $update['numero_catalogo'] ?>">
                        <small id="numeroCatalogoHelp" class="form-text text-muted"><a href='https://www.gov.br/compras/pt-br/acesso-a-informacao/consulta-detalhada/planilha-catmat-catser' target="_blank" >CATMAT/CATSER</a></small>
                    </div>
                </div>        
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="descricao">Descrição:</label>
                        <textarea class="form-control" id="descricao" name="descricao" class="form-control" aria-describedby="descricaoHelp" rows="5"><?= $update['descricao'] ?></textarea>
                        <small id="descricaoHelp" class="form-text text-muted">Detalhes do Item.</small>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="justificativaQuantidade">Justificativa da Quantidade:</label>
                        <textarea class="form-control" id="justificativaQuantidade" name="justificativa_quantidade" class="form-control" aria-describedby="justificativaQuantidadeHelp" rows="5"><?= $update['justificativa_quantidade'] ?></textarea>
                        <small id="justificativaQuantidadeHelp" class="form-text text-muted">Local de Aplicação.</small>
                    </div>
                </div>
            </div>    
        </div>
    </form>
</div>

<div class="card shadow mb-1">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>COD</th>
                        <th>Nome</th>
                        <th>Descricao</th>
                        <th>Min</th>
                        <th>Max</th>
                        <th>Val.Med.</th>
                        <th>CATMAT/CATSER</th>
                        <th>Justificativa</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($value['necessidade_itens'] as $row) : ?>
                        <?php pr($row); ?>
                        <tr>
                            <td><?= $row['cod_item'] ?></td>
                            <td><?= $row['nome'] ?></td>
                            <td><?= $row['descricao'] ?></td>
                            <td><?= $row['requisicao_minima'] ?></td>
                            <td><?= $row['requisicao_maxima'] ?></td>
                            <td><?= $row['valor_medio'] ?></td>
                            <td><?= $row['numero_catalogo'] ?></td>
                            <td><?= $row['justificativa_quantidade'] ?></td>
                            <td class="table-action">
                                <a href="<?= $this->action("Necessidade", "edit", array('id' => $row['_id'])); ?>" class="btn-sm btn-primary btn-circle" title="EDITAR"><i class="fas fa-edit"></i></a>
                                <a href="<?= $this->action("Necessidade", "delete", array('id' => $row['_id'])); ?>" class="btn-sm btn-danger btn-circle delete_others" related="Pedidos e Itens" title="EXCLUIR"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?> 
                </tbody>
            </table>
        </div>
    </div>
</div>