<?php
return array("allS"=>function ($controller){
			return new \services\ui\IAllService ();
			},"inj"=>function ($ctrl){
				return new \services\ui\IAllService ();
			});
