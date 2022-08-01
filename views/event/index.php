<?php

use app\models\Event;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Афиша';
?>
<div class="event-index">

    <h1><?= Html::encode($this->title) ?></h1> <hr>

    <?php $items = [];
    foreach (Event::find()->limit(3)->all() as $event) {
        /** @var Event $event */
        $items[] = [
            'content' => Html::a('<img src="' . $event->image . '" width="100%" height="350px" />', ['event/view', 'id' => $event->id]),
            'caption' => '<h4>' . $event->name . '</h4>',
            'captionOptions' => ['class' => ['d-none', 'd-md-block']]
        ];
    }?>
    <?= \yii\bootstrap4\Carousel::widget([
            'items' => $items
    ]) ?>

    <hr>
    <div class="card-deck">
    <?php foreach ($dataProvider->models as $event): ?>
        <div class="card">
            <img src="<?= $event->image ?>" class="card-img-top" alt="..." style="height: 18rem">
            <div class="card-body">
                <h5 class="card-title"><?= $event->name ?></h5>
                <p class="card-text"><?= $event->description ?></p>
                <h4><?= $event->price ?> &#8381; </h4>
                <?= Html::a('Подробнее', ['event/view', 'id' => $event->id], ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    <?php endforeach; ?>
    </div>

</div>
