<style> 
    .ship::after{
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
    @keyframes shipMove {
        0% {left: -8em; font-size: 1vw; transform: scale(-1,1);opacity: 0.4; content: "⛴"; color: gray;}
        60% {left: 10em; transform: scale(-1,1);}
        65% {left: 10em;transform: scale(1,1); font-size: 1.5vw; opacity: 1; color: navy;}
        85% {left: 0em; font-size: 2vw; content: "⛴";opacity: 0.5; font-size: 0.5vw;}    
        86% {left: 0em; content: '\01F4A5';opacity: 0.8;font-size: 0.5vw;}
        88% {left: 0em; content: '\01F4A5';opacity: 1; font-size: 2vw}
        95% {font-size: 1vw; opacity: 0.5;}
        100% {opacity: 0;
    }
</style>

<h1>
    ship battle
    <span class="ship"></span>
</h1>