<?php if (!$action) { ?>
    <style>
    #wait-bg {
        z-index:1000;
        position: fixed;
        left: 0px;
        top:0px;
        width:100% !important;
        height:100% !important;
        background-color:white;
        opacity:2;
    }
    #wait-text {
        z-index:10002 !important;
        position: fixed;
        left: 5%;
        top: 10px;
        color:white;
        font-size:30px;
        padding:8px 20px 8px 20px;
        background-color: #FF69B4;
        opacity:1 !important;
        -webkit-border-radius: 10px 10px 10px 10px;
        border-radius: 10px 10px 10px 10px;
        width:180px;
    }
    #wait-img {
        position: fixed;
        z-index:1000;
        left:35%;
        top:25%;
    }
    </style>
    <div id="wait-overlay">
        <div id='wait-bg'></div>
        <img id='wait-img' src="/img/ele-loader.gif">
        <div id="wait-text">Loading...</div>
    </div>
    <div id='data-window'></div>
    <script>
    // Animate Loading dots
    var text = {0: 'Loading', 1:'Loading.', 2:'Loading..', 3:'Loading...'};
    i=1;
    var intHandle = setInterval(function(){
        $('#wait-text').html(text[i]);
        i++;
        (i===4) ? i = 0 : null;
    }, 500, i, text);

        $('document').ready(function(){
            $.get( "/reports/imits-report/get-data/downmark", function( data ) {
                $( "#data-window" ).html( data );
                $('.data-table').DataTable( {
                    responsive: true,
                    "order": [[ 0, "desc" ]]
                });
                /* Initiate Bootstrap tooltip */
                $('[data-toggle="tooltip"]').tooltip();
                $('#wait-overlay').hide('slow');
                $('#wait-overlay').remove();
          });
        });
    </script>
<?php } ?>
<?php if ($action == 'get-data') { ?>
<hr/ style="margin-bottom:5px">
<?= $this->Html->link('<span class="glyphicon glyphicon-plus"></span> '.__('Download as CSV'), ['action' => 'imitsReport', 'download'], array('escape' => false, 'class' => 'btn btn-success pad-button pull-right'));  ?>
<div class="injections index large-9 medium-8 columns content horizontal-table">
    <h3><span class="glyphicon glyphicon-list-alt"></span> <?= __('iMits Injections Tracker') ?></h3>
    <hr/>
    <div class="table-responsive horizontal-table">
        <table class="data-table table stripe order-column">
            <thead>
                <tr>
                <?php
                    foreach ($headers as $h) {
                        echo "<th>{$h}</th>";
                    }
                ?>
                </tr>
            </thead>
            <tbody>
                <?php 
                foreach ($dataSet as $injection): ?>
                <tr>
                     <?php foreach ($injection as $k=>$val) { ?>
                        <td>
                        <?php
                            if (is_array($val)) {
                                switch ($k) { //column number
                                case 1: //colonies
                                        foreach ($val as $col) {
                                            echo $col."<br/>";
                                        }
                                    break;
                                    case 2: //project names
                                        foreach ($val as $pid=>$pn) {
                                            echo "<a href='/projects/view/{$pid}'>".$pn."</a><br/>";
                                        }
                                    break;
                                    case 4: //imits
                                    if (!empty($val['mi_plans'])) {
                                        foreach ($val['mi_plans'] as $mip) {
                                            echo "Plan:&nbsp;<a target='_BLANK' href='https://www.mousephenotype.org/imits/mi_plans/{$mip}'>".$mip."</a><br/>";
                                        }
                                    }

                                    if (!empty($val['mi_attempts'])) {
                                        foreach ($val['mi_attempts'] as $mia) {
                                            echo "MI:&nbsp;<a target='_BLANK' href='https://www.mousephenotype.org/imits/mi_attempts/{$mia}'>".$mia."</a><br/>";
                                        }
                                    }
                                    if (!empty($val['pheno_attempts'])) {
                                        foreach ($val['pheno_attempts'] as $pa) {
                                            echo "PA:&nbsp;<a target='_BLANK' href='https://www.mousephenotype.org/imits/mi_attempts/{$pa}'>".$pa."</a><br/>";
                                        }
                                    }
                                    break;
                                    case 5: //iMits internal links
                                    if (!empty($val['mi_plans'])) {
                                        foreach ($val['mi_plans'] as $mip) {
                                            echo "Plan:&nbsp;<a href='/imits-dump-mi-plans/view/{$mip}'>".$mip."</a><br/>";
                                        }
                                    }

                                    if (!empty($val['mi_attempts'])) {
                                        foreach ($val['mi_attempts'] as $mia) {
                                            echo "MI:&nbsp;<a href='imits-dump-mi-attempts/view/{$mia}'>".$mia."</a><br/>";
                                        }
                                    }
                                    if (!empty($val['pheno_attempts'])) {
                                        foreach ($val['pheno_attempts'] as $pa) {
                                            echo "PA:&nbsp;<a href='/imits-dump-phenotype-attempts/view/{$pa}'>".$pa."</a><br/>";
                                        }
                                    }
                                    break;
                                }
                                
                        } elseif($k == 0) { //special case, rt-lims injection id
                            echo "<a href='/injections/view/{$val}'>{$val}</a>";
                        } elseif($k == 6 && !empty($val)) { //special case, comments
                            if (strlen($val) > 20) {
                                echo "<span title='".str_replace("'", "&#39;", $val)."'>".str_replace(' ', '&nbsp;', substr($val, 0, 20))."&nbsp;<small>[...]</small></span>";
                            } else {
                                echo $val;
                            }
                        } else {
                            echo $val;
                        }
                        ?></td>
                    <?php } ?>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <hr/>
</div>
<?php } ?>
