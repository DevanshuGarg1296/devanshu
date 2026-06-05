<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->registerCssFile('https://cdn.jsdelivr.net/npm/summernote@0.9.1/dist/summernote-bs5.min.css');
$this->registerJsFile('https://cdn.jsdelivr.net/npm/summernote@0.9.1/dist/summernote-bs5.min.js', ['depends' => [\yii\web\JqueryAsset::class]]);
?>

<div class="documentation-form container mt-4">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'content')->textarea(['id' => 'summernote']) ?>

    <div class="form-group mt-3">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

<?php
$this->registerJs("
    $('#summernote').summernote({
        placeholder: 'Type here...',
        height: 200
    });
");
?>
