<?php /* @var $q \sale\dao\QuerySaleItem */ ?>
<h3>Фильтры</h3>
<form action="/" mathod="get">
    <div class="list-group">
        <div>

            <label for="f_sale_text">Содержит текст <input id="f_sale_text" name="f[text]" type="text"
                                                           value="<?php echo $q->text; ?>" /></label>

        </div>   <div>
            <label for="f_sale_saleSize">Размер скидки от 
                <input id="f_sale_saleSize" name="f[saleSize]" type="text" value="<?php echo $q->saleSize; ?>"/></label>
        </div>    <div>

            <button type="submit" name="s1">Применить</button>
        </div> 
    </div>

</form>