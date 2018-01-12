<?php

use hipanel\modules\ticket\grid\StatisticGridView;
use hipanel\widgets\IndexPage;
use hipanel\widgets\Pjax;
use yii\helpers\Html;

$this->title                   = Yii::t('hipanel:ticket', 'Tickets');
$this->params['subtitle']      = array_filter(Yii::$app->request->get($model->formName(), [])) ? Yii::t('hipanel', 'filtered list') : Yii::t('hipanel', 'full list');
$this->params['breadcrumbs'][] = $this->title;

$this->registerCss(<<<'CSS'
.list-inline {
    display: inline-block;
    padding-left: .5em;
    margin-bottom: 5px;
}

.table-list-cell {
  position: relative;
  display: table-cell;
  padding: 0px 10px;
  vertical-align: top;
}

.table-list-cell-type {
  padding-top: 15px;
  padding-left: 0;
  padding-right: 0;
  width: 20px;
  text-align: center;
}

.table-list-title {
  width: 740px;
}

#ticket-grid td.answer .label {
    text-align: center;
    font-size: 9px;
    padding: 2px 5px;
    line-height: .9;
}
CSS
);
?>

<?php Pjax::begin(array_merge(Yii::$app->params['pjax'], ['enablePushState' => true])) ?>
    <?php $page = IndexPage::begin(compact('model', 'dataProvider')) ?>

    <?php $page->setSearchFormData(compact(['state_data', 'topic_data', 'priority_data'])) ?>

    <?php $page->beginContent('main-actions') ?>
        <?= Html::a(Yii::t('hipanel:ticket', 'Create ticket'), ['@ticket/create'], ['class' => 'btn btn-sm btn-success']) ?>
    <?php $page->endContent() ?>

    <?php $page->beginContent('sorter-actions') ?>
        <?= $page->renderSorter([
            'attributes' => [
                'create_time', 'lastanswer', 'spent',
                'subject', 'responsible_id', 'recipient', 'author', 'author_seller',
            ],
        ]) ?>
    <?php $page->endContent() ?>

    <?php $page->beginContent('representation-actions') ?>
        <?= $page->renderRepresentations($representationCollection) ?>
    <?php $page->endContent() ?>

    <?php $page->beginContent('table') ?>
        <?php $page->beginBulkForm() ?>
            <?= StatisticGridView::widget([
                'boxed' => false,
                'dataProvider' => $dataProvider,
                'filterModel'  => $model,
                'columns' => $representationCollection->getByName($uiModel->representation)->getColumns(),
            ]) ?>
        <?php $page->endBulkForm() ?>
    <?php $page->endContent() ?>

    <?php $page->end() ?>
<?php Pjax::end() ?>
