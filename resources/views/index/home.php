<?php
/** @var \Enpii\WP_Plugin\Enpii_Base\Dependencies\League\Plates\Template\Template $this */
?>
<?php $this->layout('layouts/main' , ['title' => 'Home']) ?>

<h1> Home </h1>
<p>Hello, <?=$this->e('Something')?></p>
