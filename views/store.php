	<div class="main">
	        <h1>A Litte Store</h1>
	        <div class="items-shop">
	           <?php foreach($items as $item): ?>
    	            <div class="item">
    	                <img src="images/<?=$item->image?>" />
    	                <div class="rate <?=$item->is_rated ? 'rated' : '' ?>" data-item="<?=$item->id?>">
    	                	<?php for($i=1; $i <= 5; $i++): ?>
    	                		<?php if($item->rate >= $i): ?>
    	                			<span data-item="<?=$item->id?>" data-rate="<?=$i?>" class="fa vote fa-star"></span>
    	                		<?php else: ?>
    	                			<span data-item="<?=$item->id?>" data-rate="<?=$i?>" class="fa vote fa-star-o"></span>
    	                		<?php endif; ?>
    	                	<?php endfor; ?>
    	                </div>
    	                <p><?=$item->name?></p>
    	                <p><em>$<?=number_format($item->price, 2)?></em></p>
    	                <div class="counter">
    	                    <input 
        	                    type="number" 
        	                    min="1" 
        	                    value="1" 
        	                    data-item="<?=$item->id?>"
        	                    data-item-name="<?=$item->name?>"
        	                    data-item-price="$<?=number_format($item->price, 2)?>"
    	                    />
    	                </div>
    	                <a class="add" data-item="<?=$item->id?>">ADD</a>
    	            </div>
	            <?php endforeach; ?>
	        </div>
	    </div>
	    <div class="cart-list">
	        <h3>In Pocket: $<?=number_format($pocket, 2)?></h3>
	        <hr>
	        <h3>In Cart</h3>
	        <table>
	            <thead>
	                <tr>
	                    <th>Qty</th>
	                    <th>Name</th>
	                    <th>Price</th>
	                   <th></th>
	                </tr>
	            </thead>
	            <tbody id="slots">
	                <?php foreach($slots as $slot): ?>
        	            <tr>
        	                <td data-item="<?=$slot->item->id?>"><?=$slot->quantity?></td>
        	                <td><?=$slot->item->name?></td>
        	                <td>$<?=number_format($slot->item->price, 2)?></td>
        	                <td>
        	                    <a class="remove" data-item="<?=$slot->item->id?>">X</a>
        	                </td>
        	            </tr>
    	            <?php endforeach; ?>
	            </tbody>
	        </table>
	        <a href="checkout" id="checkout">CHECKOUT</a>
	</div>