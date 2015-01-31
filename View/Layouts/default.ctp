<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Cake Money - <?php echo $title_for_layout; ?></title>

  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">

  <!-- Le styles -->
  <?php
	echo $this->Html->script('https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js');

	echo $this->Html->css('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css');
	echo $this->Html->script('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js');
  ?>
  <style>
	body {
		padding-top: 70px; /* 70px to make the container go all the way to the bottom of the topbar */
	}
	.affix {
		position: fixed;
		top: 60px;
		width: 220px;
	}
  </style>

  <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
  <!--[if lt IE 9]>
  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->

  <?php
	echo $this->fetch('meta');
	echo $this->fetch('css');
  ?>
</head>

<body>
  <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
	<div class="container">
	  <div class="navbar-header">
		<div class="navbar-brand">
		  <?php echo $this->element('glyphicon', array('name' => 'piggy-bank')); ?>
		</div>
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
		  <span class="sr-only">Toggle navigation</span>
		  <span class="icon-bar"></span>
		  <span class="icon-bar"></span>
		  <span class="icon-bar"></span>
		</button>
		<?php echo $this->Html->link('Cake Money', array(
					'controller' => 'journals',
					'action' => 'index'
				), array('class' => 'navbar-brand'));
		?>
	  </div>

	  <div class="collapse navbar-collapse navbar-ex1-collapse">
		<ul class="nav navbar-nav">
		  <li><?php echo $this->Html->link(__('Journals'), array(
			'controller' => 'journals', 'action' => 'index'
			)); ?></li>
		  <li><?php echo $this->Html->link(__('Categories'), array(
			'controller' => 'categories', 'action' => 'index'
			)); ?></li>
		  <li><?php echo $this->Html->link(__('Reports'), array(
			'controller' => 'reports', 'action' => 'index'
			)); ?></li>
		</ul>
	  </div>
	</div>
  </nav>

  <section class="container">
	<?php echo $this->Session->flash(); ?>
	<?php echo $this->fetch('content'); ?>
  </section><!-- /container -->

  <footer>
	<p align="center">Copyright &copy; <?php echo date('Y') ?> Takeshi Nakamura. All rights reserved.</p>
  </footer>

  <!-- Le javascript
	================================================== -->
  <!-- Placed at the end of the document so the pages load faster -->
  <script src="//google-code-prettify.googlecode.com/svn/loader/run_prettify.js"></script>
  <?php echo $this->fetch('script'); ?>

</body>
</html>
