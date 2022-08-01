<?php

use yii\bootstrap4\Modal;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Event */
/* @var $order app\models\Order */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Events', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="event-view">

    <div class="jumbotron">
        <h1 class="display-4"><?= $model->name ?></h1>
        <p class="lead"><?= $model->description ?></p>
        <hr class="my-4">
        <p>Осталось билетов: <?= $model->tickets ?></p>
        <p class="lead">
            <?php if (!Yii::$app->user->isGuest && !$model->tickets == 0): ?>
                <a id="booking" class="btn btn-primary btn-lg" href="#" role="button">Забронировать</a>
            <?php elseif ($model->tickets == 0): ?>
                <h4>Билеты закончились</h4>
            <?php endif; ?>
        </p>
    </div>
    <?= Html::hiddenInput('ticket', $model->price, ['id' => 'ticket-price']); ?>
</div>

<?php
    Modal::begin([
            'id' => 'modal'
    ]);
        $form = \yii\widgets\ActiveForm::begin(['action' => ['order/create']]);
            echo $form->field($order, 'amount')->textInput();
            echo $form->field($order, 'event_id')->hiddenInput(['value' => $model->id])->label(false);
            echo '<h4 class="price"> </h4>';
            echo Html::submitButton('Забронировать', ['class' => 'btn btn-primary']);
        \yii\widgets\ActiveForm::end();
    Modal::end();

    $this->registerJs("$('#booking').click(() => { $('#modal').modal('show'); });");
    $this->registerJs("setInterval(() => { $('.price').html($('#order-amount').val() * $('#ticket-price').val() + ' &#8381;')}, 1)");
?>
