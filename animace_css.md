<div style="padding: 0;  margin-bottom: -20px" title="Animace pomocí CSS">
    <img src="ship.svg" style="" width="1200" style="margin: 0" height="70" alt="css-in-readme">
</div> 

## Animace pomocí CSS ##

### CSS ###
v souboru styles.css

<pre style="white-space: pre; overflow-x: auto;"><code>
/* základní class - ::after se použije kvúli kontextu 💥 a ⛴ (znaky UNICODE) */
.lod::after{
    content: "";
    margin-left: 5px;
    color: black;
    font-style: normal;
    font-size: 2vw;
    animation: shipMove 20s ease infinite forwards;
    animation-delay: 3s;
    position: relative;
    display: inline-block;
    opacity: 0;
}


/* popis jednotlivých fází animace */
@keyframes shipMove {
    0% {left: -8em; font-size: 1vw; transform: scale(-1,1);opacity: 0.4; content: "⛴"; color: gray;}
    60% {left: 10em; transform: scale(-1,1);}
    65% {left: 10em;transform: scale(1,1); font-size: 1.5vw; opacity: 1; color: navy;}
    85% {left: 0em; font-size: 2vw; content: "⛴";opacity: 0.5; font-size: 0.5vw;}    
    86% {left: 0em; content: '💥';opacity: 0.8;font-size: 0.5vw;}
    88% {left: 0em; content: '💥';opacity: 1; font-size: 2vw}
    95% {font-size: 1vw; opacity: 0.5;}
    100% {opacity: 0;}
}
</code></pre>

### HTML ###

<pre style="white-space: pre; overflow-x: auto;"><code>
&lt;html>
    &lt;head>
        &lt;meta charset="utf-8">
        &lt;link rel="stylesheet" href="styles.css">
    &lt;/head>
    &lt;body>
        &lt;h1>&lt;a href="#">ship battle&lt;span class="lod">&lt;/span>&lt;/a>&lt;/h1>
    &lt;/body>
&lt;/html>
</code></pre>
