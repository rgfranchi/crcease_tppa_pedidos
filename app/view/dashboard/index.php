<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Pedidos</h1>
</div>

<!-- Content Row -->
<div class="row">
    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            TOTAL</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $this->data['total'] ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-list fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Solicitados</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $this->data['quantidade'][0] ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-anchor fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Aprovados</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $this->data['quantidade'][2] ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-hand-holding-usd fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Empenhados</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $this->data['quantidade'][6] ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Content Row -->

<div class="row">
    <!-- Area Chart -->
    <div class="col-6">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Pedidos</h6>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="pedidosPie" 
                        total="<?=$this->data['total'] ?>"
                        label='<?= json_encode($this->data['status']) ?>'
                        quantidade='<?= json_encode( $this->data['quantidade']) ?>'
                        cores='<?= json_encode( $this->data['cores']) ?>'
                    ></canvas>
                </div>
            </div>
        </div>
    </div>




    <!-- Pie Chart -->
    <div class="col-6">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Links</h6>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <a href="<?= $this->action("User", "add_externo"); ?>" class="btn btn-primary btn-icon-split btn-sm">
                    <span class="icon text-white-50">
                        <i class="fas fa-info-circle"></i>
                    </span>
                    <span class="text">Usuário sem acesso a rede do CRCEA-SE (Solicitar acesso)</span>
                </a>
                <div class="my-1"></div>
                <a target="_blank" href="http://ftp.crcease.intraer/DT/PLT/TPPA/" class="btn btn-info btn-icon-split btn-sm">
                    <span class="icon text-white-50">
                        <i class="fas fa-info-circle"></i>
                    </span>
                    <span class="text">Arquivos dos Projetos TPPA (TR PE NC NE NF etc...) </span>
                </a>
                <div class="my-1"></div>
                <a target="_blank" href="http://ftp.crcease.intraer/DT/PLT/TPPA/_DOCUMENTOS/CHECKLISTS" class="btn btn-info btn-icon-split btn-sm">
                    <span class="icon text-white-50">
                        <i class="fas fa-receipt"></i>
                    </span>
                    <span class="text">Checklist Pagamentos (GAP-SP e CAE), IN05 e Lei8666</span>
                </a>
                <div class="my-1"></div>
                <a target="_blank" href="http://portalint.crcease.intraer/aquisicao" class="btn btn-primary btn-icon-split btn-sm">
                    <span class="icon text-white-50">
                        <i class="fas fa-anchor"></i>
                    </span>
                    <span class="text">DA - Acompanhamento processual  (TR TOD) </span>
                </a>
                <div class="my-1"></div>
                <a target="_blank" href="http://ftp.crcease.intraer/DA/INT/Portal_INT/contabilidadeOrcamentaria/EmpenhosPendentesExecu%C3%A7%C3%A3o" class="btn btn-success btn-icon-split btn-sm">
                    <span class="icon text-white-50">
                        <i class="fas fa-exclamation-triangle"></i>
                    </span>
                    <span class="text">DA - Empenhos Pendentes</span>
                </a>
            </div>
        </div>
    </div>
</div>

<?php $this->template_js = array('charts/pie') ?>