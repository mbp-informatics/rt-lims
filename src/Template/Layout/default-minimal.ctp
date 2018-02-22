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


    <?= $this->Html->css('bootstrap3.3/css/bootstrap.min.css') ?>
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
<style>
/* Prevents browsers from printing URLs */
@media print {
  a[href]:after {
    content: none !important;
  }
}
div.horizontal-table td
 {
    width:15%;
}
td.actions {
    min-width:150px;
}
td {
    width:60%;
}
.indented {
    margin-left:65px;
}
div.indented td {
    width:65%;
}
.collapse {
  display:block !important;
}
button, td.actions, th.actions, .btn, #ajax-loader {
  display:none !important;
}
.row {
  margin: 0px;
}
.alert {
  font-weight: bold;
  margin: 10px;
  padding: 0;
  text-align: center;
}
td, th {
  line-height:100% !important;
  padding:5px !important;
}
.horizontal-table {
  margin:-10px !important;
}
.panel-info {
  margin-top:10px;
}
hr {
  margin:5px !important;
}
br {
  display:none;
}
h3 {
  font-size:14px;
  font-weight:bold;
  text-align: center;
  text-decoration:underline;
  margin:0px;
}

table {
  margin-bottom:0px !important;
}

.panel {
  width:99% !important;
}

.horizontal-table {
  margin:0px !important;
  padding:0px !important;
}


</style>
<script>
$('#accordion .collapse').collapse('show');
</script>
  <div id="main-wrapper">
      <div class="article">
    	 <?= $this->Flash->render() ?><?= $this->fetch('content') ?>
      </div>
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
<script>
//Don't print Change Log
var elem = document.querySelector('#change-log-wrapper');
elem.parentNode.removeChild(elem);

</script>

</body>
</html>
