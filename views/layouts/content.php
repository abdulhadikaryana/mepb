<?php
use yii\widgets\Breadcrumbs;

?>

<!-- page content -->
<div class="right_col" role="main">
    <?=Breadcrumbs::widget(
        [
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]
    ) ?>
    <?= $content; ?>
</div>
<!-- /page content -->