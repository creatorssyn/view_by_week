<? if(isset($_POST['submit'])): ?><div class="alert alert-error"><strong>Error:</strong> You must select a feature to continue</div><? endif; ?>

<form action="" method="post" class="form-horizontal">
    <div class="span4 offset1">
        <? if(!empty($features['Opinion'])): ?>
        <h2>Opinion <a href="javascript:void" class="btn btn-small btn-inverse select-group" data-select-class="opinion">Select all</a></h2>
        <? foreach($features['Opinion'] as $feature): ?>
            <? include APPLICATION_ROOT.'views/checkbox.php'; ?>
        <? endforeach; ?>
        <? endif; ?>
        
        <? if(!empty($features['Lifestyle'])): ?>
        <h2>Lifestyles <a href="javascript:void" class="btn btn-small btn-inverse select-group" data-select-class="lifestyle">Select all</a></h2>
        <? foreach($features['Lifestyle'] as $feature): ?>
            <? include APPLICATION_ROOT.'views/checkbox.php'; ?>
        <? endforeach; ?>
        <? endif; ?>
    </div>
    <div class="span4">
        <? if(!empty($features['Comic'])): ?>
        <h2>Comics <a href="javascript:void" class="btn btn-small btn-inverse select-group" data-select-class="comic">Select all</a></h2>
        <? foreach($features['Comic'] as $feature): ?>
            <? include APPLICATION_ROOT.'views/checkbox.php'; ?>
        <? endforeach; ?>
        <? endif; ?>
    
        <? if(!empty($features['Cartoon'])): ?>
        <h2>Cartoons <a href="javascript:void" class="btn btn-small btn-inverse select-group" data-select-class="cartoon">Select all</a></h2>
        <? foreach($features['Cartoon'] as $feature): ?>
            <? include APPLICATION_ROOT.'views/checkbox.php'; ?>
        <? endforeach; ?>
        <? endif; ?>
    </div>
    <div class="span3">
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