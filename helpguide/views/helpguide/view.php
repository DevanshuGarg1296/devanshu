<?php

use yii\helpers\Html;

/** @var app\modules\helpguide\models\HelpGuide $model */
?>

<div class="doc-content">
    <h4><?= Html::encode($model->title) ?></h4>
    <hr>
    <div class="doc-content">
        <?= $model->content ?>
    </div>

</div>