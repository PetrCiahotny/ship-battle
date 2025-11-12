# Pole (array) #

![Pole](/docs-assets/arrays.png)

### Vlevo indexové pole ### 
`$a = [];`  
`$b = array();`  
`$c = ['aa', 'bb', 'cc', 123];`  
`$a[] = 'xyz';`  
`$x = $a[2];`


### Vpravo associativní pole ###
`$a = [];`  
`$b = array();`  
`$c = ['aa'=>'abc', 'bb'=>'def', 'cc'=> 123];`    
`$a['x'] = 'xyz';`  
`$x = $a['x'];`

### převod pole na string ###
`print_r($a, true);`