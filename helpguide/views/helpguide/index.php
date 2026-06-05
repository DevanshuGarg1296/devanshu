<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

/** @var yii\web\View $this */
/** @var app\modules\helpguide\models\HelpGuide[] $docs */
/** @var yii\data\Pagination $pagination */

$this->title = 'Help Guide';
?>

<div class="container mt-4 helpguide-index">
    <h2 class="mb-3"><?= Html::encode($this->title) ?></h2>

    <p><?= Html::a('➕ Add New Item', ['create'], ['class' => 'btn btn-primary']) ?></p>

    <table class="table table-bordered align-middle text-center">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Content</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php if (!empty($docs)): ?>
            <?php foreach ($docs as $index => $doc): ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= Html::encode($doc->title) ?></td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary viewBtn" data-id="<?= $doc->id ?>">View</button>
                    </td>
                    <td>
                        <div class="form-check form-switch d-inline-block">
                            <input class="form-check-input statusSwitch" type="checkbox"
                                   role="switch"
                                   data-id="<?= $doc->id ?>"
                                   <?= $doc->status === 'active' ? 'checked' : '' ?>>
                        </div>
                    </td>
                    <td>
                        <?= Html::a('Edit', ['update', 'id' => $doc->id], ['class' => 'btn btn-sm btn-info']) ?>
                        <?= Html::a('Delete', ['delete', 'id' => $doc->id], [
                            'class' => 'btn btn-sm btn-danger',
                            'data' => [
                                'method' => 'post',
                                'confirm' => 'Are you sure you want to delete this item?',
                            ],
                        ]) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="5" class="text-muted">No records found.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>

    <div class="d-flex justify-content-center mt-3">
        <?= LinkPager::widget(['pagination' => $pagination]) ?>
    </div>
</div>

<!-- View Modal -->
<div class="modal fade" id="viewModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">View Content</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="viewContentBody">
          <p class="text-muted">Loading...</p>
      </div>
    </div>
  </div>
</div>

<?php
$toggleUrl = Url::to(['toggle-status']);
$viewUrl = Url::to(['view']);

$js = <<<JS
// Toggle status via AJAX
$(document).on('change', '.statusSwitch', function() {
    let id = $(this).data('id');
    $.post('$toggleUrl?id=' + id, {}, function(res) {
        console.log('Status updated:', res.status);
    });
});

// Load record into modal
$(document).on('click', '.viewBtn', function() {
    let id = $(this).data('id');
    $.get('$viewUrl?id=' + id, function(html) {
        // Extract .doc-content from the rendered view
        let content = $(html).find('.doc-content').html();
        $('#viewContentBody').html(content);
        let modal = new bootstrap.Modal(document.getElementById('viewModal'));
        modal.show();
    }).fail(function() {
        $('#viewContentBody').html('<p class="text-danger">Failed to load content.</p>');
    });
});
JS;

$this->registerJs($js);
?>
