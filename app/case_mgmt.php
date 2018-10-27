<p>*Required</p>

<form class="form-horizontal" action="" method="post">
	<input type="hidden" name="caseID" value="<?php echo $caseID; ?>"/>
	<fieldset>
		<div class="form-group"> <!-- Row 1 -->
			<!-- Column 1 -->
			<label class="col-lg-2 control-label" for="caseNum">Case Number*</label>
			<!-- Column 2 -->
			<div class="col-lg-4">
				<input class="form-control" type="text" name="caseNum" value="<?php echo $caseNum; ?>"/>
			</div>
		</div><!-- /Row 1 -->
		<div class="form-group"> <!-- Row 2 -->
			<!-- Column 1 -->
			<label class="col-lg-2 control-label" for="caseName">Case Name*</label>
			<!-- Column 2 -->
			<div class="col-lg-4">
				<input class="form-control" type="text" name="caseName" value="<?php echo $caseName; ?>" />
			</div>
		</div><!-- /Row 2 -->				
				
		<div class="form-group"> <!-- Row 3 -->
			<!-- Column 1 -->
			<label class="col-lg-2 control-label" for="startDate">Start Date*</label>
			<!-- Column 2 -->
			<div class="col-lg-4">
				<input class="form-control" type="date" name="startDate" value="<?php echo $formatted_date_long=date_format($startDate, 'F jS, Y'); ?>" readonly/>
			</div>
		</div><!-- /Row 3 -->
		
		<div class="form-group"> <!-- Row 4 -->
			<!-- Column 1 -->
			<label class="col-lg-2 control-label" for="endDate">End Date</label>
			<!-- Column 2 -->
			<div class="col-lg-4">
				<input class="form-control" type="date" id="endDate" name="endDate" value="<?php echo $endDate; ?>" />
			</div>
		</div><!-- /Row 4 -->
		
		<div class="form-group"> <!-- Row 5 -->
			<!-- Column 1 -->
			<label class="col-lg-2 control-label" for="deliveryDate">Delivery Date</label>
			<!-- Column 2 -->
			<div class="col-lg-4">
				<input class="form-control" type="date" id="deliveryDate" name="deliveryDate"  value="<?php echo $deliveryDate; ?>" />
			</div>
		</div><!-- /Row 5 -->
		
		<div class="form-group"> <!-- Last Row -->
			<div class="col-lg-4 col-lg-offset-2">
				<button class="btn btn-primary" type="submit" name="submit">Update Case</button>
			</div>
		</div><!-- /Last Row -->
	</fieldset>
</form>