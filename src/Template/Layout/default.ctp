<?php

use Cake\Core\Configure;

/**
 * Default `html` block.
 */
if (!$this->fetch('html')) {
    $this->start('html');
    printf('<html lang="%s" class="no-js">', Configure::read('App.language'));
    $this->end();
}

/**
 * Default `title` block.
 */
//if (!$this->fetch('title')) {
    $this->start('title');
    echo Configure::read('App.title');
    $this->end();
//}

/**
 * Default `footer` block.
 */
if (!$this->fetch('tb_footer')) {
    $this->start('tb_footer');
    echo '<footer><div class="footer"><p align="center">';
    printf('Copyright &copy;%s %s. All rights reserved.', date('Y'), Configure::read('App.author'));
    echo '</p></div></footer>';
    $this->end();
}

/**
 * Default `body` block.
 */
$this->prepend('tb_body_attrs', ' class="' . implode(' ', [$this->request->controller, $this->request->action]) . '" ');
if (!$this->fetch('tb_body_start')) {
    $this->start('tb_body_start');
    echo '<body' . $this->fetch('tb_body_attrs') . '>';
    $this->end();
}
/**
 * Default `body` block.
 */
if (!$this->fetch('tb_nav')) {
    $this->start('tb_nav');
?>
<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
	  <?= $this->Html->link('<i class="fa fa-money fa-lg" aria-hidden="true"></i>', '/', ['class' => 'navbar-brand', 'escape' => false]) ?>
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
		<span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
	  <?= $this->Html->link(Configure::read('App.title'), '/', ['class' => 'navbar-brand']) ?>
    </div>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li><?= $this->Html->link(__('Journals'), ['controller' => 'journals']) ?></li>
        <li><?= $this->Html->link(__('Reports'), ['controller' => 'reports']) ?></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
		<li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
			<i class="fa fa-cog fa-lg" aria-hidden="true"></i>
			&nbsp;
			<span class="caret"></span>
		  </a>
          <ul class="dropdown-menu">
			<!-- <li><a>Users</a></li > -->
			<li><?= $this->Html->link(__('Categories'), ['controller' => 'categories']) ?></li>
			<li><?= $this->Html->link(__('Templates'), ['controller' => 'templates']) ?></li>
			<!-- <li><a>Settings</a></li> -->
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
<?php
    $this->end();
}
/**
 * Default `flash` block.
 */
if (!$this->fetch('tb_flash')) {
    $this->start('tb_flash');
    if (isset($this->Flash)) {
        echo $this->Flash->render();
    }
    $this->end();
}
if (!$this->fetch('tb_body_end')) {
    $this->start('tb_body_end');
    echo '</body>';
    $this->end();
}

/**
 * Prepend `meta` block with `author` and `favicon`.
 */
$this->prepend('meta', $this->Html->meta('author', null, ['name' => 'author', 'content' => Configure::read('App.author')]));
$this->prepend('meta', $this->Html->meta('favicon.ico', '/favicon.ico', ['type' => 'icon']));

/**
 * Prepend `css` block with Bootstrap stylesheets and append `$css`.
 */
$css =
<<<HTML
<style>
body {
  padding-top: 70px; /* For fixed top navigation bar */
}
.footer {
  padding: 10px 0;
}
.has-margin-bottom {
  margin-bottom: 15px;
}
.xs-icon {
  font-size: 110%;
}
.font-large {
  font-size: large;
}
.font-xlarge {
  font-size: x-large;
}
.float-right {
  float: right;
}
.inline-block {
  display: inline-block;
}
</style>
HTML;
$this->prepend('css', $this->Html->css([Configure::read('Css.bootstrap'), Configure::read('Css.fontawesome')]));

$this->append('css', $css);

/**
 * Prepend `script` block with jQuery and Bootstrap scripts
 */
$this->prepend('script', $this->Html->script([Configure::read('Js.jquery'), Configure::read('Js.bootstrap')]));
?>
<!DOCTYPE html>
<?= $this->fetch('html') ?>
<head>
  <?= $this->Html->charset() ?>
  <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1">
  <title><?= $this->fetch('title') ?></title>
  <?= $this->fetch('meta') ?>
  <?= $this->fetch('css') ?>
</head>
<?php
    echo $this->fetch('tb_body_start');
    echo $this->fetch('tb_nav');
    echo '<div class="container">';
    echo $this->fetch('tb_flash');
    echo $this->fetch('content');
    echo $this->fetch('tb_footer');
    echo '</div>';
    echo $this->fetch('script');
    echo $this->fetch('tb_body_end');
?>
</html>
