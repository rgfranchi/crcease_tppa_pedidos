
<?php function natureza_despesa($select_natureza_despesa = "") { ?> 
<div class="col">
    <div class="form-group">
        <label for="natureza_despesa">Natureza de Despesa (ND):</label>
        <select id="natureza_despesa" name="natureza_despesa" class="form-control" aria-describedby="natureza_despesaHelp">
            <option value="33.90.30" <?= $select_natureza_despesa == '33.90.30' ? "selected" : "" ?>>Material de Consumo</option>
            <option value="33.90.39" <?= $select_natureza_despesa == '33.90.39' ? "selected" : "" ?>>Serviços de Terceiros Pessoa Jurídica</option>
            <option value="44.90.52" <?= $select_natureza_despesa == '44.90.52' ? "selected" : "" ?>>Material Permanente</option>
            <option value="44.90.40" <?= $select_natureza_despesa == '44.90.40' ? "selected" : "" ?>>Serviços de Tecnologia da Informação e Comunicação</option>
            <option value="33.90.40" <?= $select_natureza_despesa == '33.90.40' ? "selected" : "" ?>>Comunicação de Dados</option>
        </select>
        <small id="natureza_despesaHelp" class="form-text text-muted">Classificação</small>
    </div>
</div> 
<?php } ?>