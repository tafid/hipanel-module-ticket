<?php

/**
 * @var \yii\web\View $this
 * @var Client $client
 */
use hipanel\modules\client\grid\ClientGridView;
use hipanel\modules\client\models\Client;
use hipanel\modules\client\models\stub\ClientRelationFreeStub;
use hipanel\widgets\Box;
use hipanel\widgets\ClientSellerLink;
use yii\helpers\Html;

$this->registerCss('
/* Fix table horizontal scroll */
.b-ticket-client-info table {
    table-layout: fixed;
    width: 100%;
}

.b-ticket-client-info table td {
    word-wrap: break-word; / All browsers since IE 5.5+ /
    overflow-wrap: break-word; / Renamed property in CSS3 draft spec /
}
');

?>

<div class="col-md-12 b-ticket-client-info">
    <?php $box = Box::begin([
        'renderBody' => false,
        'options' => [
            'class' => 'box-solid',
        ],
    ]) ?>

    <?php if ($client instanceof ClientRelationFreeStub) : ?>
        <?= \hipanel\widgets\AsyncLoader::widget([
            'route' => ['@ticket/render-client-info', 'id' => $client->id],
            'containerSelector' => '.b-ticket-client-info'
        ]) ?>
    <?php endif ?>

    <?php $box->beginBody() ?>
        <div class="profile-block">
            <div class="profile-photo">
                <?php if (!empty($client->email)) : ?>
                    <?= $this->render('//layouts/gravatar', ['email' => $client->email, 'size' => 120, 'alt' => '']) ?>
                <?php endif ?>
            </div>
            <div class="profile-user-name">
                <?= ClientSellerLink::widget(['model' => $client]) ?>
            </div>
            <?php if (!$client instanceof ClientRelationFreeStub) : ?>
                <div class="profile-user-role"><?= Yii::t('hipanel:client', $client->type) ?></div>
            <?php endif ?>
        </div>

        <?php $box->beginFooter() ?>
            <?= ClientGridView::detailView([
                'model' => $client,
                'boxed' => false,
                'columns' => array_filter(
                    $client->login === 'anonym' ? ['name', 'email'] : [
                        'name', 'email', 'messengers', 'country', 'language', 'state',
                        Yii::$app->user->can('bill.read') ? 'balance' : null,
                        Yii::$app->user->can('bill.read') ? 'credit' : null,
                        'servers_spoiler', 'domains_spoiler', 'hosting',
                    ]
                ),
            ]) ?>

            <?php if ($client->login !== 'anonym') : ?>
                <?= Html::a(
                    '<i class="fa fa-info-circle" style="font-size: 120%"></i> &nbsp;&nbsp;' . Yii::t('hipanel:ticket', 'Client details'),
                    ['@client/view', 'id' => $client->id],
                    ['class' => 'btn  btn-default btn-sm btn-block']
                ) ?>
            <?php endif ?>
        <?php $box->endFooter() ?>
    <?php $box->endBody() ?>

    <?php $box->end() ?>
</div>
