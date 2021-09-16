<!-- Collapsable Card  -->
<div class="card shadow mb-4">
    <!-- Card Header - Accordion -->
    <a href="#collapseCardExample" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
        <h6 class="m-0 font-weight-bold text-primary"><?= $this->data['pregao']->nome; ?></h6>
    </a>
    <!-- Card Content - Collapse -->
    <div class="collapse" id="collapseCardExample">
        <div class="card-body"><?= $this->data['pregao']->objeto ?></br>
        VALOR TOTAL:<?= $this->data['pregao']->valor_total ?></br>
        VALOR SOLICITADO:<?= $this->data['pregao']->valor_solicitado ?></br>
        QUANTIDADE TOTAL:<?= $this->data['pregao']->qtd_total ?></br>
        QUANTIDADE DISPONÍVEL:<?= $this->data['pregao']->qtd_disponivel ?></div>
    </div>
</div>