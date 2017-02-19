<?php
$this->title = 'Overview';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="identidad-overview">
    <div class="row">
        <div class="col-lg-12">
<?php var_dump($facturaModel[0]['cliente']); ?>
            <h3><?= $facturaModel[0]['cliente']['identidad_nombre'] ?></h3>
            <hr>
<?php
$facturaYear;
$facturacion = 0;

for ($i = 0; $i <= count($facturaModel); $i++) 
{
    $facturaYear = 
}
?>
        </div>


    </div>