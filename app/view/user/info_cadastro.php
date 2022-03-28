<div class="container-fluid" >
    <?php foreach($this->data as $key => $value) : ?>
        <?php if($key == 0) :?>
            <h1 class="h3 mb-4 text-gray-800" style="margin-top: 50px;"><?= $value ?></h1>
        <?php else: ?>
            <h1 class="h3 mb-4 text-gray-800"><?= $value ?></h1>
        <?php endif; ?>
    <?php endforeach; ?>    
</div>