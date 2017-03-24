<div class='comment-author'>
    <?php
        if(!empty($comment->author_name)) {
            $authorText = $comment->author_name.", ".$comment->author_url;
        } else {
            $authorText = __("Anonymous");
        }
    ?>
    <p class='comment-author-name'><?php echo $authorText;?></p>
    <?php
        $hash = md5(strtolower(trim($comment->author_email)));
    ?>
</div>
<div class='comment-body <?php if($comment->flagged):?>comment-flagged<?php endif;?> '><?php echo $comment->body; ?></div>
