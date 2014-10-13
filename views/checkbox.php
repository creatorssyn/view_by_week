<div class="form-group">
    <div class="col-lg-12">
        <div class="checkbox">
            <label for="box_<?=$feature['file_code']?>">
                <input type="checkbox" class="<?=strtolower($feature['category'])?>" id="box_<?=$feature['file_code']?>" name="features[]" value="<?=$feature['file_code']?>" data-title="<?=$feature['title']?>" data-file-code="<?=$feature['file_code']?>"> <?=$feature['title']?> 
            </label>
        </div>
    </div>
</div>