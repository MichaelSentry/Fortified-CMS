<?php
use NinjaSentry\Sai\Response\Message;

if( ! $this->message instanceof Message )
{
    throw new \Exception(
        'Expected class Sai\Response\Message was not found'
    );
}

?>
<?php if( $this->message->isWaiting() ): ?>
<div class="notify-wrap">
    <div class="container">
        <div class="row">
            <div class="notify col-sm-9 pull-right">
                <?php echo $this->message->deliver(); ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>