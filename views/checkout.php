	<div class="main">
	        <a href="/">Go to Store</a>
	        <h3>In Pocket: $<?=number_format($pocket, 2)?></h3>
	        <hr>
	        <h3>In Cart</h3>
	        <table>
	            <thead>
	                <tr>
	                    <th>Qty</th>
	                    <th>Name</th>
	                    <th>Price</th>
	                </tr>
	            </thead>
	            <tbody id="slots">
	                <?php foreach($slots as $slot): ?>
        	            <tr>
        	                <td data-item="<?=$slot->item->id?>"><?=$slot->quantity?></td>
        	                <td><?=$slot->item->name?></td>
        	                <td>$<?=number_format($slot->item->price, 2)?></td>
        	            </tr>
    	            <?php endforeach; ?>
	            </tbody>
	        </table>
	        
	    </div>
	    
	    <div class="cart-list">
	        <h3>Transport Method</h3>
	        
	        <form onsubmit="return toSubmit();">
	            <label for="choice1">Pick Up </label>
	            <input required type="radio" id="choice1" name="method" value="pickup" />
	            <br />
	            <label for="choice2">UPS ($5)</label>
	            <input type="radio" id="choice2" name="method" value="ups" />
	            <br />
	            <h4>Total: $<?=number_format($total, 2)?></h4>
	            <br/>
	            <input type="submit" id="pay" value="PAY"/>
	        </form>

	    </div>