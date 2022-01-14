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