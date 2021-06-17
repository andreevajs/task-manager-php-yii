<?php

/* @var $workcosts array */

use yii\helpers\Html;

?>

<?php
    $total_days = $total_hours = $total_minutes = 0;
    foreach ($workcosts as $workcost) {
        $total_days += $workcost->days;
        $total_hours += $workcost->hours;
        $total_minutes += $workcost->minutes;
    }
    $total_hours += intdiv($total_minutes,60);
    $total_minutes = $total_minutes % 60;
    $total_days += intdiv($total_hours,24);
    $total_hours = $total_hours % 24;
?>

<p><b>Total time spent on task: </b>
    <?=$total_days?> days,
    <?=$total_hours?> hours,
    <?=$total_minutes?> min.
</p>

<b>Work cost facts:</b>
<ul>
    <?php foreach ($workcosts as $workcost): ?>
        <li>
            <span class="alert-warning"><?= $workcost->user->login ?></span>:
            <?=$workcost->days ?? 0?>d <?=$workcost->hours ?? 0?>h <?=$workcost->minutes?>m
            <?= $workcost->editable ?
                Html::a('delete', ['workcosts/delete', 'id' => $workcost->id,'task'=>$workcost->task_id],['class' => 'btn-danger btn-sm']) : ''
            ?>
            <br/>
            <?= $workcost->comment ?>
        </li>
    <?php endforeach; ?>
</ul>