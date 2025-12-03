# JSON #
## JavaScript Object Notation ##

"Transporní formát" dat mezi systémy, nebo klientem a serverem, ukládání.   
Univerzální datový textový formát vuužitelný napříč jazyky.

### Způsob zápisu: ###

jednoduché typy:  
`123`, `"abcd""`, `1.87`

indexové pole:  
`[123, "Abc", 1.87]`

asociativní pole / objekt (klíče musí být v uvozovkách, nesmí být v apostofech):   
`{"klic1":123, "klic_2":"xyz", "klic3":1.87}`

Funkce pro práci s JSONem:  

PHP:  
`json_decode(string $json, ?bool $associative = null, int $depth = 512, int $flags = 0): mixed`    
`json_encode(mixed $value, int $flags = 0, int $depth = 512): string|false`

JavaScript:  
`JSON.stringify(data);`  
`JSON.parse(string);`

C#:  
`JsonSerializer.Serialize(data)`  
`JsonSerializer.Deserialize<Typ>(jsonString)`

...