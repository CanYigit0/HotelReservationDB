<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>
			Hotel DATABASE
		</title>
		<style type="text/css">			
			body{
					margin: 0;
					padding: 0;
				}


				/*.middle{
					position: absolute;
					top: 50%;
					left: 50%;
					tramsform: translate(-50%,-50%);
					text-align: center;
				}*/

				.btn{
					background: none;
					border: 2px solid #000;
					font-family: "montserrat",sans-serif;
					font-weight: bold;
					padding: 12px 20px;
					min-width: 200px;
					margin: 10px;
					cursor: pointer;
					transition: color 0.4 linear;
					position: relative;
				}

				.btn:hover{
					color: #fff;
				}

				.btn::before{
					content: "";
					position: absolute;
					left: 0;
					top: 0;
					width: 100%;
					height: 100%;
					background: #32CD32;
					z-index: -1;
					transition: transform 0.5s;
					transform-origin: 0 0;
					transition-timing-function: cubic-bezier(0.5,1.6,0.4,0.7);
				}

				.button::before{
					transform: scaleX(0);
				}

				.button:hover::before{
					transform: scaleX(1);
				}
		</style>
	</head>
	<body>
		<div class = "container">
		</div>
		<form action = "project.php" method = "POST">
			<div class = "middle">
				<button class = "btn button">INSTALL DATABASE</button>
			</div>
		</form>
	</body>
</html>
