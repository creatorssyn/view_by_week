<? if(empty($releases)): ?><div class="alert alert-warning">Nothing here :(</div><? endif; ?>
<? foreach($releases as $release): ?>
<div class="row" style="">
    <div class="release_block col-lg-8 col-lg-offset-2">
        <h2><?=$release['title']?></h2>
        <div class="row">
            <div class="col-lg-6"><strong>BY:</strong> <?=$release['byline']?></div>
            <div class="col-lg-6"><strong>RELEASE:</strong> <?=date('m/d/Y', strtotime($release['release_date']))?></div>
        </div>
        
        <? if(!empty($release['notes'])): ?>
        <div class="row">
        <? foreach($release['notes'] as $note): ?>
            <div class="alert preview <? if($note['type'] == 'correction'): ?>alert-danger<? else: ?>alert-warning<? endif; ?>"><?=$note['note']?></div>
            <? endforeach; ?>
        </div>
        <? endif; ?>
        
        <div class="row">
            <div class="preview">
                <? if($release['preview_image'] != NULL): ?>
                <img src="<?=str_replace('&', '&amp;', $release['preview_image'])?>" alt="<?=$release['title']?>" />
                <? endif; if($release['preview_text'] != NULL): ?>
                <?=$release['preview_text']?>
                <? endif; ?>
            </div>
        </div>
        
        <h3>Download Links</h3>
        <? foreach($release['files'] as $i=>$file): ?>
            <? if($i%2 == 0): ?><div class="row"> <? endif; ?>
            <div class="col-lg-6"><a href="<?=$file['url']?>"><?=$file['description']?></a></div>
            <? if($i%2 == 1): ?></div><? endif; ?>
        <? endforeach; ?>

        <? if($i%2 == 0): ?></div><? endif; ?>

        <hr>
    </div>
</div>
<? endforeach; ?>