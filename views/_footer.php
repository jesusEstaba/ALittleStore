	</div>
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
	<script type="text/javascript">
	    
	    $(() => {
	        $('.add').on('click', function() {
	            let id = $(this).attr('data-item');
	            let item = $(`input[data-item="${id}"]`);
	           
	            //send
	            $.get(`add/${id}/${item.val()}`, function(res) {
	                if ($(`td[data-item="${id}"]`)[0]) {
    	                let qty = $(`td[data-item="${id}"]`).html();
    	                $(`td[data-item="${id}"]`).html(Number(qty) + Number(item.val()))
    	                
    	            } else {
    	                $('#slots').append(`
        	                <tr>
        	                    <td data-item="${id}">${item.val()}</td>
        	                    <td>${item.attr('data-item-name')}</td>
        	                    <td>${item.attr('data-item-price')}</td>
        	                    <td>
        	                        <a class="remove" data-item="${id}">X</a>
        	                    </td>
        	                </tr>
        	            `);
    	            }
    	            
    	            item.val(1);
	            });
	        });
	        
	        $('#slots').on('click', '.remove', function() {
	            let id = $(this).attr('data-item');
	            let remove = $(this);
	            
	            $.get(`remove/${id}`, function(res) {
	                remove.parent().parent().remove();
	            });
	        });
	        
	
			$('.vote').on('click', function() {
				let id = $(this).attr('data-item')
				let amount = $(this).attr('data-rate');
				
				$.get(`rate/${id}/${amount}`, function(res) {
					window.location.href = '/';
				});
			});
	        
	        
	    })
	    
	    function toSubmit() {
			let method = $('input[name=method]:checked').val();
			let msg;
			
			$.post({
				url: 'pay',
				method: 'POST',
				data:{method}
			})
			.done(function(res) {
				let amount = Number(res);
				
				if(amount) {
					alert('Charged $' + amount);
					window.location.href = '/';
				} else {
					alert('Insufficient funds');	
				}
			});
			
			return false;
	    }
	    
	</script>
</body>
</html>