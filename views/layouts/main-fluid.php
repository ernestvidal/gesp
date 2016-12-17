<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>

<?php $this->beginBody() ?>

    <?php
    NavBar::begin([
        'brandLabel' => 'INVOICE APP',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);

    /*
    echo Nav::widget([
    'items' => [
        [
            'label' => 'Home',
            'url' => ['site/index'],
            'linkOptions' => [],
        ],
        [
            'label' => 'Articulos',
            'items' => [
              ['label' => 'Create', 'url' => ['/item/create']]
            ],
        ],
        [
            'label' => 'Articulos',
            'items' => [
                 ['label' => 'Level 1 - Dropdown A', 'url' => '#'],
                 '<li class="divider"></li>',
                 '<li class="dropdown-header">Dropdown Header</li>',
                 ['label' => 'Level 1 - Dropdown B', 'url' => '#'],
            ],
        ],
        [
            'label' => 'Contact',
            'url' => ['site/contact']
        ],
        [
            'label' => 'Login',
            'url' => ['site/login'],
            'visible' => Yii::$app->user->isGuest
        ],
    ],
    'options' => ['class' =>'nav-pills'], // set this to nav-tab to get tab-styled navigation
]);

    */
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => 'Home', 'url' => ['/site/index']],
            ['label' => 'Articulos', 'url' => ['/item/index']],
            ['label' => 'Identidades', 'url' => ['/identidad/index']],
            ['label' => 'Presupuestos',
              'items' => [
                ['label' => 'Listado', 'url' => ['/presupuesto/index']],
                ['label' => 'Nuevo', 'url' => ['/presupuesto/create']],
              ],
            ],
            ['label' => 'Pedidos',
              'items' => [
                ['label' => 'Listado', 'url' => ['/pedido/index']],
                ['label' => 'Nuevo', 'url' => ['/pedido/create']],
              ],
            ],
            ['label' => 'Albaranes',
              'items' => [
                ['label' => 'Listado', 'url' => ['/albaran/index']],
                ['label' => 'Nuevo', 'url' => ['/albaran/create']],
              ],
            ],
            ['label' => 'Facturas',
              'items' => [
                ['label' => 'Listado', 'url' => ['/factura/index']],
                ['label' => 'Nueva', 'url' => ['/factura/create']],
              ],           
           ],
            ['label' => 'Proformas',
              'items' => [
                ['label' => 'Listado', 'url' => ['/proforma/index']],
                ['label' => 'Nueva', 'url' => ['/proforma/create']],
              ],           
           ],
            ['label' => 'Informes', 'url' => ['/report/index']],
           // ['label' => 'About', 'url' => ['/site/about']],
           // ['label' => 'Contact', 'url' => ['/site/contact']],
           Yii::$app->user->isGuest ?
              ['label' => 'Login', 'url' => ['/site/login']] :
              [
                  'label' => 'Logout (' . Yii::$app->user->identity->username . ')',
                  'url' => ['/site/logout'],
                  'linkOptions' => ['data-method' => 'post']
              ],
        ],
    ]);

    NavBar::end();
    ?>



            
    <div id="contenido" class="container-fluid">
        <div class="row">
            <div class="col-md-1">
                <div id="sidebar">
                <ul class="list-unstyled">
                    <li>hola</li>
                    <li>hola</li>
                    <li>hola</li>
                    <li>hola</li>
                    <li>hola</li>
                    <li>hola</li>
                    <li>hola</li>
                    <li>hola</li>
                    <li>
                         <?= Html::a('FACTURAS', 'factura/index') ?>
                    </li>
                    <li><span class="glyphicon glyphicon-search" aria-hidden="true"></span></li>
                </ul>
            </div>
            </div>
            <div class="col-md-10">

                <?= Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>

                <?= $content ?>
            </div>
        </div>
    </div>

<!--
<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Ernest vidal <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>
-->
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
