<!-- Collapsable Card  -->
<div class="card shadow mb-1">
    <!-- Card Header - Accordion -->
    <a href="#collapseCardPregaoHead" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardPregaoHead">
        <h6 class="m-0 font-weight-bold text-primary"><?= $this->data['pregao']['nome']; ?></h6>
    </a>
    <!-- Card Content - Collapse -->
        <div class="collapse" id="collapseCardPregaoHead">
            <p><div class="card-body"><?= $this->data['pregao']['objeto'] ?></p>
            <p>DATA HOMOLOGAÇÃO: <?= $this->data['pregao']['data_homologacao'] ?></p>
            <p>DATA LIMITE SOLICITAÇÃO: <?= $this->data['pregao']['data_limite_solicitacao'] ?></p>
            <?=empty($this->data['pregao']['url_proposta']) ? "" : "<a class='btn btn-primary' target='_blank' href='" . $this->data['pregao']['url_proposta'] . "'>PROPOSTA</a>" ?>
            <?=empty($this->data['pregao']['url_anexo']) ? "" : "<a class='btn btn-primary' target='_blank' href='" . $this->data['pregao']['url_anexo'] . "'>ANEXOS</a>" ?>
            <?=empty($this->data['pregao']['url_siasg_net']) ? "" : "<a class='btn btn-primary' target='_blank' href='" . $this->data['pregao']['url_siasg_net'] . "'>SIASG.NET</a>" ?>
        </div>    
    </div>
</div>