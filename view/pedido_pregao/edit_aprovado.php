<div class="card shadow mb-4">
    <div class="card-header py-1">
        <form action="<?= $this->action("PedidoPregao", "save"); ?>" method="post">
            <input type="hidden" id="_id" name="_id" value="<?= $this->data['pedido']->_id ?>">
            <div class="input-group">
            <?php if (in_array($this->data['pedido']->status,$this->data['status'])) : ?>
                <div class="input-group-prepend">
                    <select class="custom-select" name="status" required="required">
                    <?php foreach ($this->data['status'] as $value) : ?>
                    <option value="<?=$value?>" <?= $value == $this->data['pedido']->status ? "selected" : "" ?>><?=$value?></option>
                    <?php endforeach; ?>
                    </select>
                </div>
                <input type="submit" value="ATUALIZAR" />
                <?php else : ?>
                    <p><?=$this->data['pedido']->status ?></p>
                <?php endif; ?>                
            </div>
        </form>
    </div>
    <div class="row">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Solicitante</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?=$this->data['pedido']->solicitante ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>    
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Setor</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?=$this->data['pedido']->setor ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>    
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Valor</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">R$ <?=$this->data['pedido']->pedido_valor_total ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Quantidade</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?=$this->data['pedido']->pedido_quantidade_total ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Collapsable Card Example -->
    <div class="card shadow mb-4">
        <!-- Card Header - Accordion -->
        <a href="#collapseCardExample" class="d-block card-header py-3" data-toggle="collapse"
            role="button" aria-expanded="true" aria-controls="collapseCardExample">
            <h6 class="m-0 font-weight-bold text-primary">
                <?=$this->data['pregao']->nome ?>
                <?=empty($this->data['pregao']->termo_referencia_origem) ? "" : " | " . $this->data['pregao']->termo_referencia_origem ?>
            </h6>
        </a>
        <!-- Card Content - Collapse -->
        <div class="collapse show" id="collapseCardExample">
            <div class="card-body">
                <p>Objeto:<?=$this->data['pregao']->objeto ?></p>
                <p>PAG:<?=$this->data['pregao']->numero_processo_PAG ?></p>
                <?=empty($this->data['pregao']->url_proposta) ? "" : "<a class='btn btn-primary' target='_blank' href='" . $this->data['pregao']->url_proposta . "'>PROPOSTA</a>" ?>
                <?=empty($this->data['pregao']->url_anexo) ? "" : "<a class='btn btn-primary' target='_blank' href='" . $this->data['pregao']->url_anexo . "'>ANEXOS</a>" ?>
                <?=empty($this->data['pregao']->url_siasg_net) ? "" : "<a class='btn btn-primary' target='_blank' href='" . $this->data['pregao']->url_siasg_net . "'>SIASG.NET</a>" ?>
            </div>
        </div>
    </div>
    <!-- Basic Card Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Basic Card Example</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <th>COD</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Fornecedor</th>
                    <th>Valor Unitário</th>
                    <th>Valor Solicitado</th>
                    <th>Qtd Disponível</th>
                    <th>Qtd Solicitada</th>
                    <th>Qtd Pedido</th>
                    <th>Valor Pedido</th>
                </thead>
                <tfoot>
                    <th>COD</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Fornecedor</th>
                    <th>Valor Unitário</th>
                    <th>Valor Solicitado</th>
                    <th>Qtd Disponível</th>
                    <th>Qtd Solicitada</th>
                    <th>Qtd Pedido</th>
                    <th>Valor Pedido</th>
                </tfoot>
                <?php foreach ($this->data['pedido']->itens_pedido as $row) : ?>
                    <tr>
                        <td><?= $row->cod_item_pregao ?></td>
                        <td><?= $row->nome ?></td>
                        <td><?= $row->descricao ?></td>
                        <td><?= $row->fornecedor ?></td>
                        <td><?= $row->valor_unitario ?></td>
                        <td><?= $row->valor_solicitado ?></td>
                        <td><?= $row->qtd_disponivel ?></td>
                        <td><?= $row->qtd_solicitada ?></td>
                        <td><?= $row->pedido_quantidade ?></td>
                        <td><?= $row->pedido_valor ?></td>
                    </tr>
                <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>
</div>