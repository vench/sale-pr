<?php /* @var $q \sale\dao\QuerySaleItem */ ?>
<?php /* @var $tags \sale\model\SaleTag[] */ ?>

<h3>Фильтры</h3>
<form action="/" mathod="get" role="form">

    <?php if (!empty($q->tagId)): ?>
        <input type="hidden" name="f[tag]" value="<?php echo $q->tagId; ?>" />
    <?php endif; ?>

    <div  class="form-group"> 
        <label for="f_sale_text">Содержит текст   </label> 
        <input id="f_sale_text" name="f[text]" type="text"  value="<?php echo $q->text; ?>" />

    </div>   

    <div  class="form-group">
        <label for="f_sale_saleSize">Размер скидки от </label>
        <input id="f_sale_saleSize" name="f[saleSize]" type="text" value="<?php echo $q->saleSize; ?>"/>
    </div>    

    <div  class="form-group">
        <label class="" for="f_sale_price">Цена </label>
        <div  class="form-group">     
            <input class="col-lg-4" id="f_sale_saleSize_1" name="f[price][0]" type="text" value="<?php echo $q->getPriceMin(); ?>"/>
            <span class="col-lg-1">-</span>
            <input class="col-lg-4" id="f_sale_saleSize_2" name="f[price][1]" type="text" value="<?php echo $q->getPriceMax(); ?>"/>
        </div>
        <div class="clearfix"></div>
    </div>



    <div  class="form-group">   
        <button class="btn btn-default" type="submit" name="s1">Применить</button>
    </div> 

    <?php if (!empty($tags)): ?>
        <div  class="form-group">
            <h3>Тэги</h3>

            <?php foreach ($tags as $tag): ?>
                <a  class="label label-default" href="/?f[tag]=<?php echo $tag->getId(); ?>"><?php echo $tag->getTitle(); ?></a> 
            <?php endforeach; ?>
            <br/>
            <a href="/?a=site/tags"><b>Все тэги...</b></a>
        </div>  
    <?php endif; ?>


</form>