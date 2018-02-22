<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = 'RT-LIMS: Reproductive Technology Laboratory Information System';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>
    <?= $this->Html->css('rt-lims.css') ?>
    <?= $this->Html->css('font-awesome4.4.0/css/font-awesome.min.css') ?>
    <?= $this->Html->css('bootstrap3.3/css/bootstrap.min.css') ?>
    <?= $this->Html->css('http://code.jquery.com/ui/1.12.1/themes/ui-lightness/jquery-ui.css') ?>
    <?= $this->Html->css('//cdn.datatables.net/1.10.10/css/jquery.dataTables.css') ?>
    <?= $this->Html->css('toggle-switch.css') ?>
    <?= $this->Html->css('https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.1/css/selectize.bootstrap3.css') ?>
    <?= $this->Html->script('https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js') ?>
    <?= $this->Html->script('bootstrap3.3/js/bootstrap.min.js')?>
    <?= $this->Html->script('http://code.jquery.com/ui/1.12.1/jquery-ui.min.js') ?>
    <?= $this->Html->script('//cdn.datatables.net/1.10.10/js/jquery.dataTables.js')?>
    <?= $this->Html->script('sidebar_menu.js')?>
    <?= $this->Html->script('rt-lims.js')?>
    <?= $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.1/js/standalone/selectize.min.js')?>

    <?= $this->Html->script('https://cdn.datatables.net/buttons/1.5.0/js/dataTables.buttons.min.js') ?>
    <?= $this->Html->script('//cdn.datatables.net/buttons/1.5.0/js/buttons.flash.min.js') ?>
    <?= $this->Html->script('//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js') ?>
    <?= $this->Html->script('//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js') ?>
    <?= $this->Html->script('//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js') ?>
    <?= $this->Html->script('//cdn.datatables.net/buttons/1.5.0/js/buttons.html5.min.js') ?>
    <?= $this->Html->script('//cdn.datatables.net/buttons/1.5.0/js/buttons.print.min.js') ?>

    <?= $this->Html->meta('https://cdn.datatables.net/buttons/1.5.0/css/buttons.dataTables.min.css') ?>


    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>












</head>
<body>
<img id='logo-gfx' src="/img/mbp-logo-gfx.png">
    <div id="header"> <!-- Checks if debug is set to false, if it is it displays the normal banner, if not it displays a yellow version -->
      <?php
      if (!$debug) { ?>
          <?= $this->Html->image('/img/desktop-menu.png',[
            "alt" => "Mouse Biology Program - Reproductive Technology LIMS Logo",
            'url' => ['controller' => 'Pages'],
            'class'=>"header-img"]); ?>
      <?php } else { ?>
          <?= $this->Html->image('/img/desktop-menu-staging.png',[
            "alt" => "Mouse Biology Program - Reproductive Technology LIMS Logo",
            'url' => ['controller' => 'Pages'],
            'class'=>"header-img"]); ?>
      <?php } ?>
    </div>

  <div id="main-wrapper">
         <ul>
            <?php echo $this->element('navbar'); ?>
          </ul>
      <div class="article">
      
<?php
//Display change log button on all View pages
$tableAlias = Cake\Utility\Inflector::dasherize($this->name);
if ($this->request->params['action'] == 'view' && $tableAlias != 'change-log') {
  $entityName =  Cake\Utility\Inflector::singularize($tableAlias);
  $entityName = Cake\Utility\Inflector::variable($entityName);
  $entityId = $this->viewVars[$entityName]->id; ?>
          <div class="change-log-icon tab-icon">
            <a href='/changeLog/index/<?= $tableAlias ?>/<?= $entityId ?>'>
              <span class="important"><span class="glyphicon glyphicon-list-alt"></span>
              <small>change log</small></span>
            </a>
        </div>
<?php } ?>
        <div class="change-log-icon tab-icon">
          <a href='/users/logout'>
            <span class="important"><i class="fa fa-sign-out" aria-hidden="true"></i> <small>logout <sup>(<?= $userData['username']; ?>)</sup></small></span>
            
          </a>
        </div>
        <div class="print-icon tab-icon">
          <span class="important"><span class="glyphicon glyphicon-print"></span> <small>print</small></span>
        </div>

        <div style="float:right">
        <small><span style="color:#444;">You are here:</span></small> 
          <a style="text-decoration:underline;" href='/<?= $tableAlias ?>'>/<?= $this->name ?></a>
        </div>
        <div style="clear:both;"></div>
        <div style="height: 1px; border: 2px solid #ddd; margin:20px 0px 30px;"></div>

    	 <?= $this->Flash->render() ?><?= $this->fetch('content') ?>
      </div>
      <div id="fading-bottom"></div>


      </div>
    <footer></footer>
    </div>
	<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
  ga('create', 'UA-12379267-18', 'auto');
  ga('send', 'pageview');
  </script>
  
  <!-- 
    A global variable that identifies debug 
    mode for client side code (js). 
    window.DEBUG = ['debug' => true] Cake config setting
  -->
  <script>
    window.DEBUG = <?= $debug ? 'true' : 'false'; ?>;
  </script>
  
  <p id="ajax-loader"><img src="/img/ajax-loader.gif"><small>Loading. Please wait...</small></p>
  <style>
    #ajax-loader {
        display:none;
    }
  </style>
  
</body>
</html>
