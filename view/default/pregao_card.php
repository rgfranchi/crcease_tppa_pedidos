    <!-- Collapsable Card Example -->
    <div class="card shadow mb-4">
        <!-- Card Header - Accordion -->
        <a href="#collapseCardPregao" class="d-block card-header py-3" data-toggle="collapse"
            role="button" aria-expanded="true" aria-controls="collapseCardExample">
            <h6 class="m-0 font-weight-bold text-primary">
                <?=$this->data['pregao']->nome ?>
                <?=empty($this->data['pregao']->termo_referencia_origem) ? "" : " | " . $this->data['pregao']->termo_referencia_origem ?>
            </h6>
        </a>
        <!-- Card Content - Collapse -->
        <div class="collapse show" id="collapseCardPregao">
            <div class="card-body">
                <p>Objeto:<?=$this->data['pregao']->objeto ?></p>
                <p>PAG:<?=$this->data['pregao']->numero_processo_PAG ?></p>
                <?=empty($this->data['pregao']->url_proposta) ? "" : "<a class='btn btn-primary' target='_blank' href='" . $this->data['pregao']->url_proposta . "'>PROPOSTA</a>" ?>
                <?=empty($this->data['pregao']->url_anexo) ? "" : "<a class='btn btn-primary' target='_blank' href='" . $this->data['pregao']->url_anexo . "'>ANEXOS</a>" ?>
                <?=empty($this->data['pregao']->url_siasg_net) ? "" : "<a class='btn btn-primary' target='_blank' href='" . $this->data['pregao']->url_siasg_net . "'>SIASG.NET</a>" ?>
            </div>
        </div>
    </div>