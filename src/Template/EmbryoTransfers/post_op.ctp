<!-- <style>
    @media screen and (-webkit-min-device-pixel-ratio:0) { 
        .hide-webkit {
            visibility: hidden;
            display: none;
            margin: 0px !important;
        }
    }

    @media print and (-webkit-min-device-pixel-ratio:0) { 
        .hide-webkit {
            visibility: hidden;
            display: none;
            margin: 0px !important;
        }
    }

    body {
        -webkit-print-color-adjust:exact;
    }
    .borderless * {
        border:0 !important;

    }
    .container {
        width:1330px;
    }
    .bg-info {
        background-color:#D9EDF7 !important;
    }
</style> --> <!-- This seems to be messing up how it fits on one page when printed -->
<div class="container">
    <h2>Pre, Peri & Post Operative Observation Sheet</h2>
    <hr class="hide-webkit">
    <div class="row bg-info">
        <div class="col-xs-6">
            <?php
            if ($colonyName != '') {
                $colonyName = ' | '.$colonyName;
            }
            echo "<h2>ET ID: {$embryoTransfer->id} {$colonyName}</h2>"; ?>
        </div>
    </div>
    <hr class="hide-webkit">
    <div class="row">
        <div class="col-xs-4 horizontal-table">
            <h2>General Info</h2>
            <p>Investigator: <b> Lloyd</b></p>
            <p>Protocol: <b><?= h($embryoTransfer->protocol) ?></b></p>
            <p>Species: <b>Mouse</b></p>
            <p>Sex: <b>Female</b></p>
            <p>Strain: <b><?php echo $embryoTransfer->strain_name; ?></b></p>
            <p>Job ID: <b><?php if (isset($embryoTransfer->job_id)) { echo $embryoTransfer->job->id; } ?></b></p>
            <p>Order #: <b><?php if (isset($embryoTransfer->job_id)) { echo $embryoTransfer->job->order_no; } ?></b></p>
            <p>Expected DOB: 
            <b><?php
                if (isset($embryoTransfer->expected_dob)) { 
                    echo h($embryoTransfer->expected_dob->format('n/j/Y')); 
                } 
            ?></b></p>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Animal ID:</th>
                        <?php
                            foreach($embryoTransfer["recipients"] as $te){
                                echo "<th>".$te["ear_mark"]."</th>";
                            }
                        ?>
                    </tr>
                </thead>
                <tbody>
<!--                     <tr>
                        <td>DOB:</td>
                        <?php
                            foreach($embryoTransfer["recipients"] as $te){
                                $dob = $te["dob"];
                                if ($dob) {
                                    echo "<td>".$dob->format('n/j/Y')."</td>";
                                }
                            }
                        ?>
                    </tr> -->
<!--                     <tr>
                        <td>Age (days):</td>
                        <?php
                            foreach($embryoTransfer["recipients"] as $te){
                                $dob = new DateTime($te["dob"]);
                                $now = new DateTime();
                                $age = $dob->diff($now);
                                if ($age->format('%d') == 0) {
                                    echo "<td>0d ".$age->format('%H')."hrs</td>";
                                } else {
                                    echo "<td>".$age->format('%d')."</td>";
                                }
                            }
                        ?>
                    </tr> -->
                     <tr>
                        <td>Weight (g):</td>
                        <?php
                            foreach($embryoTransfer["recipients"] as $te){
                                echo "<td>".$te["weight"]."</td>";
                            }
                        ?>
                    </tr>
                </tbody>
                    
            </table>
            <p>Housing Site: <b><?php echo $embryoTransfer->et_location; ?></b></p>
            <p>Primary Recharge:  <b><?php if (isset($embryoTransfer->primary_recharge)) { echo h($embryoTransfer->primary_recharge); }  ?></b></p>
            <p>Secondary Recharge:  <b><?php if (isset($embryoTransfer->primary_recharge)) { echo h($embryoTransfer->secondary_recharge); }  ?></b></p>
        </div>
        <div class="col-xs-8 horizontal-table">
            <h2>Anesthesia Record</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th colspan="3">Surgery Info</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Date: <b><?php if (isset($embryoTransfer->et_date)) { echo h($embryoTransfer->et_date->format('n/j/Y')); } ?></b></td>
                        <td>Time: <b><?php if (isset($embryoTransfer->et_time)) { echo h($embryoTransfer->et_time->format('H:i')); } ?></b></td>
                        <td>Surgeon: <b><?php echo $embryoTransfer->user->initials; ?></b></td>
                    </tr>
                    <tr>
                        <td colspan="2">Procedure: <b>Embryo Transfer</b> </td>
                        <td>Anesthetist: <b><?php echo $embryoTransfer->user->initials; ?></b></td>
                    </tr>
                </tbody>
            </table>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th colspan="5">Anesthetic Induction and Maintenance</th>
                    </tr>
                    <tr>
                        <th>Animal</th>
                        <th><?php echo $embryoTransfer->anesthetic; ?></th>
                        <th>Time</th>
                        <th><?php echo $embryoTransfer->analgesic; ?></th>
                        <th>Time</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        foreach($embryoTransfer["recipients"] as $te){
                            echo "<tr>";
                            echo "<td>".$te["ear_mark"]."</td>";
                            echo "<td>".$te["anesthetic_vol"]."</td>";
                            echo "<td>".h($embryoTransfer->et_time->format('H:i'))."</td>";
                            echo "<td>".$te["analgesic_vol"]."</td>";
                            echo "<td>".h($embryoTransfer->et_time->format('H:i'))."</td>";
                            echo "</tr>";

                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row horizontal-table">
        <h2>Post-Operative Recovery</h2>
        <table class="table table-bordered">
            <thead>
                <?php
                    echo "<th></th>";
                    foreach($dates as $date){
                        echo "<th>".$date->format('m/d')."</th>";
                    }
                ?>
            </thead>
            <tbody>
                <?php 
                    foreach($embryoTransfer["recipients"] as $te){
                        echo "<tr>";
                        echo "<td>".$te["ear_mark"]."</td>";
                        foreach($dates as $date){
                            echo "<td><span style='color:red'>   </span></td>";
                        }
                        echo "</tr>";
                    }
                ?>
            </tbody>
        </table>
    </div>
    <div class="row">
        Clip Removal Date:________ Projected: <b><?php echo $dates[count($dates)-1]->format("m/d/y"); ?></b> Separation/Cage (CC) Date:________ Projected: <b><?php echo $dates[count($dates)-1]->format("m/d/y"); ?></b></div>

    <hr />
    <div class="row">
        <h2>Comments</h2>
        <textarea class="form-control" rows="5"><?= $embryoTransfer->comments ?></textarea>
    </div>
    <div class="row horizontal-table">
        <h2>Recipient/Litter Info</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Projected Dates</th>
                    <?php 
                        foreach($embryoTransfer->recipients as $te){
                            echo "<th>".$te["ear_mark"]."</th>";
                        }
                    ?>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Pregnant @ Separation?</td>
                    <?php 
                        foreach($embryoTransfer->recipients as $te){
                            echo "<td><span style='color:red'>   </span></td>";
                        }
                    ?>
                </tr>
                <tr>
                    <td>Date of Birth: </td>
                    <?php 
                        foreach($embryoTransfer->recipients as $te){
                            echo "<td><span style='color:red'>   </span></td>";
                        }
                    ?>
                </tr>
                <tr>
                    <td>TT/Rate/CC: </td>
                    <?php 
                        foreach($embryoTransfer->recipients as $te){
                            echo "<td><span style='color:red'>   </span></td>";
                        }
                    ?>
                </tr>
                <tr>
                    <td>Extra Cage Change</td>
                    <?php 
                        foreach($embryoTransfer->recipients as $te){
                            echo "<td><span style='color:red'>   </span></td>";
                        }
                    ?>
                </tr>
                <tr>
                    <td>Wean/CC: </td>
                    <?php 
                        foreach($embryoTransfer->recipients as $te){
                            echo "<td><span style='color:red'>   </span></td>";
                        }
                    ?>
                </tr>
                <tr>
                    <td>Extra Cage Change</td>
                    <?php 
                        foreach($embryoTransfer->recipients as $te){
                            echo "<td><span style='color:red'>   </span></td>";
                        }
                    ?>
                </tr>
                <tr>
                    <td>Extra Cage Change</td>
                    <?php 
                        foreach($embryoTransfer->recipients as $te){
                            echo "<td><span style='color:red'>   </span></td>";
                        }
                    ?>
                </tr>
                <tr>
                    <td>Removed from Maternity</td>
                    <?php 
                        foreach($embryoTransfer->recipients as $te){
                            echo "<td><span style='color:red'>   </span></td>";
                        }
                    ?>
                </tr>
            </tbody>
        </table>
    </div>
    <br>
</div>