<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>A Little Store</title>
	
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css" />
	
	<style type="text/css">
	    
	    * {
	         box-sizing: border-box;
	    }
	    
	    body {
	        margin: 0;
	    }
	    
	    table {
	        width: 100%;
	        text-align: center;
	    }
	    
	    .container {
	        width: 1024px;
	        margin: auto;
	        overflow: auto;
	        box-shadow: 0 5px 6px rgba(0,0,0,.26) ;
	    }
	    
	    .main {
	        width: 70%;
	        float:left;
	        background: #eeeeee;
	        vertical-align: top;
	        padding: 1em;
	    }
	    
	    .cart-list {
	       width: 29%;
	       float:left;
	       border-bottom: 1px solid #bbb;
	       vertical-align: top;
	    }
	    
	    
	    
	    .item {
	        background: #ffffff;
	        display: inline-block;
	        width: 150px;
	        border: 1px solid #bbb;
	        margin-bottom: .5em;
	    }
	    
	    .item img {
	        min-width: 100%;
	        max-width: 100%;
	        border-bottom: 1px solid #bbb;
	    }
	    
	    .item .add, #checkout, #pay {
	        background: #4caf50;
	        color: #ffffff;
	        padding: .5em 1em;
	        border-radius: 3px;
	        display:block;
	        margin: .25em;
	        text-align: center;
	        cursor: default;
	        transition: all .8s;
	    }
	    
	    .item .add:hover {
	        background:#8bc34a;
	    }
	    
	    #checkout {
	        background: #2196f3;
	    }
	    
	    
	    
	    
	    .counter {
	        padding: .5em;
	    }
	    
	    .counter input {
	        text-align: center;
	       min-width: 100%;
	        max-width: 100%;
	    }
	    
	    .remove {
	        color:#fff;
	        padding: .25em .5em;
	        font-weight: bold;
	        background: #f44336;
	        border-radius: 3px;
	        margin-bottom: .25em;
	        display: inline-block;
	    }
	    
	    #pay {
	    	border:none;
	    	width: 100%;
	    }
	    
	    .rate {
	    	text-align: center;
	    }
	    
	    .rate.rated {
	    	color: #2196f3;
	    }
	    
	    .rate span:hover{
	    	color: #2196f3;	
	    }
	    
	</style>
</head>
<body>
    <div class="container">