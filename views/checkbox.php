<div class="control-group">
	<div>
		<label class="checkbox" for="box_<?=$feature['file_code']?>"><?=$feature['title']?> 
			<input type="checkbox" class="<?=strtolower($feature['category'])?>" id="box_<?=$feature['file_code']?>" name="features[]" value="<?=$feature['file_code']?>" data-title="<?=$feature['title']?>" data-file-code="<?=$feature['file_code']?>">
		</label>
	</div>
</div>