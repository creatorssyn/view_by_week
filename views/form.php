<? if(isset($_POST['submit'])): ?><div class="alert alert-error"><strong>Error:</strong> You must select a feature to continue</div><? endif; ?>

<form action="<?=SERVICE_ADDRESS?>?api_key=<?=$_GET['api_key']?>" method="post" class="form-horizontal">
    <div class="col-lg-4 col-lg-offset-1">
        <? if(!empty($features['Opinion'])): ?>
        <h2>Opinion <button class="btn btn-xs btn-info select-group" data-select-class="opinion">Select all</button></h2>
        <? foreach($features['Opinion'] as $feature): ?>
            <? include APPLICATION_ROOT.'views/checkbox.php'; ?>
        <? endforeach; ?>
        <? endif; ?>
        
        <? if(!empty($features['Lifestyle'])): ?>
        <h2>Lifestyles <button class="btn btn-xs btn-info select-group" data-select-class="lifestyle">Select all</button></h2>
        <? foreach($features['Lifestyle'] as $feature): ?>
            <? include APPLICATION_ROOT.'views/checkbox.php'; ?>
        <? endforeach; ?>
        <? endif; ?>
    </div>
    <div class="col-lg-4">
        <? if(!empty($features['Comic'])): ?>
        <h2>Comics <button class="btn btn-xs btn-info select-group" data-select-class="comic">Select all</button></h2>
        <? foreach($features['Comic'] as $feature): ?>
            <? include APPLICATION_ROOT.'views/checkbox.php'; ?>
        <? endforeach; ?>
        <? endif; ?>
    
        <? if(!empty($features['Cartoon'])): ?>
        <h2>Cartoons <button class="btn btn-xs btn-info select-group" data-select-class="cartoon">Select all</button></h2>
        <? foreach($features['Cartoon'] as $feature): ?>
            <? include APPLICATION_ROOT.'views/checkbox.php'; ?>
        <? endforeach; ?>
        <? endif; ?>
    </div>
    <div class="col-lg-3">
        <div class="affix">
            <select name="days">
                <option value="7">Last week</option>
                <? for($i=2; $i<=10; $i++): ?><option value="<?=(7*$i)?>">Last <?=$i?> weeks</option><? endfor; ?>
            </select>
            <br>
            <button class="btn btn-large btn-primary" id="dl-button" type="submit" name="submit" value="Downloads!">Downloads</button>
            
            <hr>
            <h4>Currently Selected:</h4>
            <ul id="checked"></ul>
            <div>
                <button class="btn btn-small" id="all">Select All</button>
                <button class="btn btn-small" id="clear">Clear All</button>
            </div>
        </div>
    </div>
</form>