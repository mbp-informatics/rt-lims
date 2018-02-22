<style>
.menu-placeholder {
    color:#666;
}
.current-link {
    color: #EC971F !important;
}

</style>
    <nav class="mobile-bar navbar navbar-default no-margin">
    <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header fixed-brand">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"  id="menu-toggle">
              <span id="menu-text">menu</span> <span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span>
            </button>
            <a class="navbar-brand" href="/"><img id="logo" src="/img/mbp-logo.png"> RT-LIMS</a>
        </div><!-- bs-example-navbar-collapse-1 -->
    </nav>

<div id="wrapper">
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav nav-pills nav-stacked" id="menu">

                <!-- CRISPR Design  -->
                <li>
                    <a href="#"><span class="fa-stack fa-lg pull-left"><i class="fa fa-exchange fa-stack-1x "></i></span>CRISPR Design <span class="caret"></span></a>
                       <ul class="nav-pills nav-stacked" style="list-style-type:none;">
                        <li><a href="/crispr-designs/bulk-upload">Add Design</a></li>
                        <li><a href="/crispr-designs/index">List Designs</a></li>

                        <li><a target="_BLANK" href="https://mgal-lims.mousebiology.org/PCR/index.php?tab=3">Order Primers<span class="glyphicon glyphicon-link dark-gray"></span></a></li>
                    </ul>
                </li>

                <!-- BREEDING  -->
                <li>
                    <a href="#"><span class="fa-stack fa-lg pull-left"><i class="fa fa-venus-mars fa-stack-1x "></i></span>Animals <span class="caret"></span></a>
                       <ul class="nav-pills nav-stacked" style="list-style-type:none;">
                           <li>
                               <a href="#">Animal Requests <span class="caret"></span></a>
                               <ul class="nav-pills nav-stacked" style="list-style-type:none;">
                                    <li><a target="_BLANK" href="https://online.mosaicvivarium.com/efeb6b5010934652aa65f2a6dec950/Vivarium/Animal/AnimalOrdering.aspx">Transfer Requests<span class="glyphicon glyphicon-link dark-gray"></span></a></li>
                                    <li><a target="_BLANK" href="https://online.mosaicvivarium.com/efeb6b5010934652aa65f2a6dec950/Vivarium/Animal/AnimalOrdering.aspx">Transfer Orders<span class="glyphicon glyphicon-link dark-gray"></span></a></li>
                                    <li><a href="/pseudopregnant-recipient-orders">Recipient Orders</a></li>
                                    <li><a href="/pseudopregnant-recipient-orders?in_house=1">In-house B6NCRL Orders</a></li>
                                    <li><a target="_BLANK" href="/pseudopregnant-recipient-orders/add">Recipient Requests<span class="glyphicon glyphicon-link dark-gray"></span></a></li>

                               </ul>
                           </li>
                           <li>
                               <a href="#">Breeding <span class="caret"></span></a>
                               <ul class="nav-pills nav-stacked" style="list-style-type:none;">
                                    <li><a href="/mosaic/listFounders">Founders</a></li>
                                    <li><a href="#"><span class="menu-placeholder">Breeding reports</span></a></li>
                               </ul>
                           </li>
                           <li><hr style="border-color:#222"></li>
                    </ul>
                </li>

                <!-- INJECTIONS -->
                <li>
                    <a href="#"><span class="fa-stack fa-lg pull-left"><i class="fa fa-compress fa-stack-1x "></i></span>Microinjections <span class="caret"></span></a>
                       <ul class="nav-pills nav-stacked" style="list-style-type:none;">
                           <li><a href="/injections/add">Add Injection</a></li>
                           <li><a href="/injections">List Injections</a></li>
                           <li><a href="/jobs/add_injection">Add Injection request</a></li>
                           <li><a href="/jobs?injection_requests=1">List Injection requests</a></li>
                           <li><a href="/embryo-transfers">ET</a></li>
                           <li><hr style="border-color:#222"></li>
                    </ul>
                </li>

                <!-- IVF/CRYO  -->
                <li>
                    <a href="#"><span class="fa-stack fa-lg pull-left"><i class="fa fa-barcode fa-stack-1x "></i></span>IVF/Cryo <span class="caret"></span></a>
                       <ul class="nav-pills nav-stacked" style="list-style-type:none;">
                           <li><a href="/jobs">Job requests</a></li>
                           <li><a href="/ivfs">IVF/ICSI</a></li>
                           <li>
                               <a href="#">Cryo Requests <span class="caret"></span></a>
                               <ul class="nav-pills nav-stacked" style="list-style-type:none;">
                                   <li><a href="/embryo-cryos">Embryo Cryo</a></li>
                                   <li><a href="/sperm-cryos">Sperm Cryo</a></li>
                                   <li><a href="/es-cells">ES Cells</a></li>
                               </ul>
                           </li>
                           <li><a href="/embryo-resus">Embryo Resus</a></li>
                            <li><a href="/embryo-transfers">Embryo Transfers</a></li>
                            <li><a href="#"><span class="menu-placeholder">Oocyte Cryo</span></a></li>
                            <!-- <li><a href="#">Genotype form</a></li> -->
                            <li>
                            <a href="#">Freezer Inventory <span class="caret"></span></a>
                                <ul class="nav-pills nav-stacked" style="list-style-type:none;">
                                    <li><a href="/inventory-vials">Vials</a></li>
                                    <li><a href="/inventory-shipped-vials">Shipped Vials</a></li>
                                    <li><a href="/inventory-containers">Containers</a></li>
                                    <li><a href="/inventory-boxes">Boxes</a></li>
                                </ul>
                           </li>
                    </ul>
                </li>
                <li><hr style="border-color:#222"></li>

            
            <!-- REPORTS  -->
            <li>
                <a href="#"><span class="fa-stack fa-lg pull-left"><i class="fa fa-bar-chart" aria-hidden="true"></i></span>Reports <span class="caret"></span></a>
                   <ul class="nav-pills nav-stacked" style="list-style-type:none;">
                      <li><a href="/reports/mscl-report">MSCL Report</a></li>
                      <li><a href="/reports/imits-report">iMits Report</a></li>
                      <li><a href="/reports/micl-project-report">MICL Project Report</a></li>
                      <li><a href="/reports/micl-ivf-report">MICL IVF Report</a></li>
                      <li><a href="/reports/micl-et-report">MICL ET Report</a></li>
                </ul>
            </li>

            <!-- GENES  -->
            <li>
                <a href="#"><span class="fa-stack fa-lg pull-left"><i class="fa fa-list fa-stack-1x "></i></span>Gene List <span class="caret"></span></a>
                   <ul class="nav-pills nav-stacked" style="list-style-type:none;">
                    <li><a href="/projects">List Projects</a></li>
                    <li><a href="/genes-statuses">Gene statuses</a></li>
                    <li><a href="/gene-name-changes">Gene name changes</a></li>
                    <li><a href="/mgi-genes-dump">All MGI genes</a></li>
                </ul>
            </li>

                <!-- Task lists  -->
                <li>
                    <a href="#"><span class="menu-placeholder"><span class="fa-stack fa-lg pull-left"><i class="fa fa-check fa-stack-1x "></i></span>Jobs&Tasks (TBD)<span class="caret"></span></span></a>
                    <ul class="nav-pills nav-stacked" style="list-style-type:none;">
                            <li><a href="#"><span class="menu-placeholder">Task List</span></a></li>
                            <li><a href="#"><span class="menu-placeholder">Job List</span></a></li>
                            <li><a href="#"><span class="menu-placeholder">New KOMP Job</span></a></li>
                            <li><a href="#"><span class="menu-placeholder">New MMRRC Job</span></a></li>
                            <li><a href="#"><span class="menu-placeholder">New PTS job</span></a></li>
                    </ul>
                </li>
                <li><hr style="border-color:#222"></li>

                <?php if ($userData['role_id'] == 1) { ?>
                <!-- Admin  -->
                <li>
                    <a href="#"><span class="fa-stack fa-lg pull-left"><i class="fa fa-database fa-stack-1x "></i></span>Admin menu <span class="caret"></span></a>
                        <ul class="nav-pills nav-stacked" style="list-style-type:none;">
                            <li><a href="/komp-projects-dump/">KOMP Projects</a></li>
                            <li><a href="/komp-clones-dump">KOMP Clones</a></li>
                            <li><a href="/komp-genes-dump">KOMP Genes</a></li>
                            <li><a href="/komp-vials-dump">KOMP Vials</a></li>
                            <li><hr style="border-color:#222"></li>
                            <li><a href="/imits-dump-mi-attempts">iMits MI Attempts</a></li>
                            <li><a href="/imits-dump-mi-plans/">iMits MI Plans</a></li>
                            <li><a href="/imits-dump-phenotype-attempts">iMits Phenotype Attempts</a></li>
                            <li><hr style="border-color:#222"></li>
                            <li><a href="/mgi-genes-dump/">All MGI genes</a></li>
                    </ul>
                </li>
                <?php } ?>

     </div>
    </div>
