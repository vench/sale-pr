<?php /* @var $form app\Form */ ?>
<form method="post">
  <div class="form-group">
    <label for="ptitle">Title</label>
    <input id="ptitle"  type="text" class="form-control" value="<?php echo $form->getValue('title');?>" name="<?php echo $form->getName('title');?>" >
    <?php if($form->hasErrors('title')): ?>
    <p><?php echo join(',', $form->getErrors('title'));?></p>
    <?php endif; ?>
  </div>
    
    
   <div class="form-group">
    <label for="pbody">Body</label>
    <textarea class="form-control" name="<?php echo $form->getName('body');?>" id="pbody"><?php echo $form->getValue('body');?></textarea>
    
    <?php if($form->hasErrors('body')): ?>
    <p><?php echo join(',', $form->getErrors('body'));?></p>
    <?php endif; ?>
  </div>
    
   <div class="form-group">
    <label for="pkeywords">Keywords</label>
    <input id="pkeywords"  type="text" class="form-control" value="<?php echo $form->getValue('keywords');?>" 
           name="<?php echo $form->getName('keywords');?>" >
    <?php if($form->hasErrors('keywords')): ?>
    <p><?php echo join(',', $form->getErrors('keywords'));?></p>
    <?php endif; ?>
  </div>
     
   
  <button type="submit" class="btn btn-default">Save</button>
</form>