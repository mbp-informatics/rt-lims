<div>
	<h1 align=middle>Murine Reproductive Technology</h1>
	<h3 align=middle>The Mouse Biology Program at The University of California, Davis </h3>
	<p align=middle>Comprehensive Laboratory-Wide Information Management <p>
	<?php echo $this->Html->link(__('Learn more') . ' &raquo;', array('controller' => 'pages', 'action' => 'display', 'about'), array('class' => 'btn btn-primary btn-large', 'escape' => false)); ?></p>
</div>
<div>
	<div>
		<h2>CRISPR Design</h2>
		<p>MGEL will perform a thorough informatics review of the gene of interest and provide a full design schematic illustrating 
		the target allele, critical exon, and guide RNA (gRNA) sequence(s). For construct validation, the MBP will perform an in vitr2o 
		cleavage assay to validate targeting efficiency of the proposed gRNA expression constructs.  Briefly, genomic DNA encompassing 
		the gRNA(s) binding site will be amplified by PCR. The resulting amplicon will be incubated with gRNA(s) and Cas9 (nuclease)
		and analyzed for expected fragments via agarose gel electrophoresis. This is an essential quality control step to verify gRNA
		targeting for Cas9-induced double stranded break (DSB) prior to microinjection.  Only gRNA(s) that pass this quality control
		step will be used for microinjection.</p>
		<p><?php echo $this->Html->link(__('View details') . ' &raquo;', array('controller' => 'pages', 'action' => 'display', 'behavioral_phenotyping'), array('class' => 'btn', 'escape' => false)); ?></p>
	</div>
	<div>
		<h2>Microinjection</h2>
		<p>Microinjection service includes microinjection of a minimum of 180 fertilized C57BL/6N zygotes (other strains available upon request),
		 embryo transfers into pseudopregnant recipients, and housing of pups for up to 10 weeks of age. Microinjection and embryo transfer is
		 intended to generate at least 1 genotypically-confirmed F0 (“founder”).<p>
		 <?php echo $this->Html->link(__('View details') . ' &raquo;', array('controller' => 'pages', 'action' => 'display', 'diagnostic_pathology'), array('class' => 'btn', 'escape' => false)); ?></p>
   </div>
	<div>
		<h2>Genotyping</h2>
		<p>Genomic DNA isolated from tail or toe snips collected from 10-12 day old born pups will be used for PCR amplification of the endogenous 
		loci followed by sequencing. Sequence chromatograms will show mixed sequences at the cut site, including sequence repaired by non-homologous 
		endjoining (NHEJ). Each PCR product with mixed sequencing is sub-cloned. Up to 10 individual clones will be isolated and sequenced to confirm 
		targeting...<p>
		<?php echo $this->Html->link(__('View details') . ' &raquo;', array('controller' => 'pages', 'action' => 'display', 'about'), array('class' => 'btn', 'escape' => false)); ?></p>
	</div>
</div>